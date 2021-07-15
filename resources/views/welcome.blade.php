@extends('layouts.app')
@section('title', 'Welcome')
@section('app_content')
<div class="flex-center position-ref full-height">
    <div class="content">
        <h1 class="ui header title m-b-md">
            Task Manager
        </h1>
        <a href="{{route('login')}}"><button class="ui black large button">Login</button></a>
        <a href="{{route('register')}}"><button class="ui blue large button">Register your account</button></a>
    </div>
</div>
@endsection