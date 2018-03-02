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
        $thread->replies()->create([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return redirect()->back();
    }
}
