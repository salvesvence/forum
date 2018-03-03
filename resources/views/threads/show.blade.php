@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">{{ $thread->creator->name }}</a> posted: {{ $thread->title }}</div>
                    <div class="panel-body">{{ $thread->body }}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>
        @if(auth()->check())
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form action="{{ route('thread.replies.store', $thread->id) }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea id="body" name="body" class="form-control"
                                      placeholder="Have something to say?" rows="5">
                            </textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Post</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection