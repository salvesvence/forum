@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create a new Thread</div>

                    <div class="panel-body">
                        <form method="post" action="{{ route('threads.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="channel">Chose a channel:</label>
                                <select name="channel_id" id="channel" class="form-control" required>
                                    <option>Chose one...</option>
                                    @foreach(\App\Channel::all() as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>{{ ucfirst($channel->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" required
                                       name="title" placeholder="title" value="{{ old('title') }}">
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <textarea class="form-control" id="body" name="body" required
                                          placeholder="body" rows="8">{{ old('body') }}</textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>

                            @if(count($errors))
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection