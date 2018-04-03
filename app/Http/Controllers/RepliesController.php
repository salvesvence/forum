<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Support\Facades\Gate;

class RepliesController extends Controller
{
    /**
     * RepliesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of replies.
     *
     * @param $channelId
     * @param Thread $thread
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }

    /**
     * Store a new reply associated to a given thread.
     *
     * @param $channelId
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channelId, Thread $thread)
    {
        if(Gate::denies('create', new Reply())) {
            return response()->json([
                'message' => 'You are posting too frequently. Please, take a break. :)'
            ], 422);
        }

        try {

            $this->validate(request(), ['body' => 'required|spamfree']);

            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'message' => 'The reply has been stored',
                'reply' => $reply->load('owner')
            ]);

        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }
    }

    /**
     * Store a new reply associated to a given thread.
     *
     * @param Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {

            $this->validate(request(), ['body' => 'required|spamfree']);

            $reply->update(['body' => request('body')]);

            $message = 'The reply has been updated.';

        } catch (\Exception $exception) {

            \Log::error($exception->getMessage());

            $message = 'The reply has not been updated.';
        }


        if(request()->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->back()->with('flash', $message);
    }

    /**
     * Delete the reply given.
     *
     * @param Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {

            $reply->delete();

            $message = 'The reply has been deleted.';

        } catch (\Exception $exception) {

            \Log::error($exception->getMessage());

            $message = 'The reply has not been deleted.';
        }

        if(request()->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->back()->with('flash', $message);
    }
}
