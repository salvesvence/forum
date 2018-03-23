<?php

namespace App\Http\Controllers;

use App\Thread;

class ThreadSubscriptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Subscribe the current logged user to the thread given.
     *
     * @param $channelId
     * @param Thread $thread
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store($channelId, Thread $thread)
    {
        try {

            $thread->subscribe();

            $message = 'You have been subscribed to this thread.';

        } catch (\Exception $exception) {

            \Log::error($exception->getMessage());

            $message = 'You have not been subscribed to this thread.';
        }

        if(request()->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->back()->with('flash', $message);
    }

    /**
     * Unsubscribe the current logged user to the thread given.
     *
     * @param $channelId
     * @param Thread $thread
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($channelId, Thread $thread)
    {
        try {

            $thread->unsubscribe();

            $message = 'You have been unsubscribed to this thread.';

        } catch (\Exception $exception) {

            \Log::error($exception->getMessage());

            $message = 'You have not been unsubscribed to this thread.';
        }

        if(request()->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->back()->with('flash', $message);
    }
}