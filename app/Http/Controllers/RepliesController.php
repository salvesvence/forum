<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    /**
     * Store a new reply associated to a given thread.
     *
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Thread $thread)
    {
        try {

            $thread->replies()->create([
                'body' => request('body'),
                'user_id' => auth()->id()
            ]);

            session()->flash(['message' => 'The thread has been stored']);

        } catch (\Exception $exception) {

            \Log::error($exception->getMessage());

            session()->flash(['message' => 'The thread has not been stored']);
        }

        return redirect()->back();
    }
}
