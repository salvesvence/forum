<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Inspections\Spam;

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
     * @param Spam $spam
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channelId, Thread $thread, Spam $spam)
    {
        $this->validate(request(), ['body' => 'required']);

        $spam->detect(request('body'));

        $reply = null;

        try {

            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id()
            ]);

            $message = 'The reply has been stored';

        } catch (\Exception $exception) {

            \Log::error($exception->getMessage());

            $message = 'The reply has not been stored';
        }

        if(request()->expectsJson()) {
            return response()->json([
                'message' => $message,
                'reply' => $reply->load('owner')
            ]);
        }

        return redirect()->back()->with('flash', $message);
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

        $this->validate(request(), ['body' => 'required']);

        try {

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
