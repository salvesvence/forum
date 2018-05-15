@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header">
                    <h1>{{ $profileUser->name }}</h1>
                    <img src="{{ asset($profileUser->avatar_path) }}" width="100" height="100" class="thumbnail">
                    @can('update', $profileUser)
                        <form method="post" action="{{ route('avatar', $profileUser->id) }}"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input class="form-control" type="file" name="avatar">
                            </div>
                            <button class="btn btn-primary" type="submit">Add Avatar</button>
                        </form>
                    @endcan
                </div>

                @forelse($activities as $date => $activity)
                    <h3 class="page-header">{{ $date }}</h3>
                    @foreach($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include("profiles.activities.{$record->type}", ['activity' => $record])
                        @endif
                    @endforeach
                @empty
                    <p>There is no activity for this user yet.</p>
                @endforelse

            </div>
        </div>
    </div>
@endsection