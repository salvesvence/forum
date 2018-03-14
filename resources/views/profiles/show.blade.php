@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header">
                    <h1>
                        {{ $profileUser->name }}
                        <small>since {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>
                </div>

                @foreach($activities as $activity)
                    @include("profiles.activities.{$activity->type}")
                @endforeach

            </div>
        </div>
    </div>
@endsection