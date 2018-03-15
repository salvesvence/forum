<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    /**
     * RepliesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
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
        $this->validate(request(), ['body' => 'required']);

        try {

            $thread->replies()->create([
                'body' => request('body'),
                'user_id' => auth()->id()
            ]);

            session()->flash('flash', 'The reply has been stored');

        } catch (\Exception $exception) {

            \Log::error($exception->getMessage());

            session()->flash('flash', 'The reply has not been stored');
        }

        return redirect()->back();
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

        $reply->delete();

        session()->flash('flash', 'The reply has been deleted.');

        return redirect()->back();
    }
}
