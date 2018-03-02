<?php

namespace App\Http\Controllers;

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

            session()->flash('The thread has been stored');

        } catch (\Exception $exception) {

            \Log::error($exception->getMessage());

            session()->flash('The thread has not been stored');
        }

        return redirect()->back();
    }
}
