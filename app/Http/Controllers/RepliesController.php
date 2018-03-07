<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    /**
     * RepliesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->only('store');
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

            session()->flash('The thread has been stored');

        } catch (\Exception $exception) {

            \Log::error($exception->getMessage());

            session()->flash('The thread has not been stored');
        }

        return redirect()->back();
    }
}
