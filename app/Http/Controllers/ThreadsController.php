<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilters;
use App\Inspections\Spam;
use App\Thread;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    /**
     * ThreadsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        if(request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new thread. 
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created thread.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Spam $spam
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Spam $spam)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);

        $spam->detect($request->body);

        try {

            $thread = Thread::create([
                'user_id' => auth()->id(),
                'channel_id' => $request->channel_id,
                'title' => $request->title,
                'body' => $request->body,
            ]);

            return redirect($thread->path())
                ->with('flash', 'The thread has been stored correctly.');

        } catch (\Exception $exception) {

            \Log::error($exception->getMessage());

            return redirect()->back()
                ->with('flash', 'The thread has not been stored correctly.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $channelId
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread)
    {
        if(auth()->check()) {
            auth()->user()->read($thread);
        }

        $key = sprintf("users.%s.visits.%s", auth()->id(), $thread->id);

        cache()->forever($key, Carbon::now());

        return view('threads.show', compact('thread'));
    }

    /**
     * Remove the specified thread from storage.
     *
     * @param $channel
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel, Thread $thread)
    {
        $this->authorize('delete', $thread);

        $thread->delete();

        if(request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/threads')
            ->with('flash', 'The thread has been destroyed correctly.');
    }

    /**
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return mixed
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->get();
    }
}
