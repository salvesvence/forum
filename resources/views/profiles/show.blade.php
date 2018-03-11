@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{ $profileUser->name }}
        </div>
    </div>
@endsection