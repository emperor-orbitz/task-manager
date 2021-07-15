@extends('layouts.app')
@section('title', 'Login | Task Manager')

@section('script')
<script src="{{ asset('js/register.validation.js') }}"></script>
@endsection

@section('app_content')
<div class="ui hidden divider"></div>

<div class="ui stackable centered page grid" style="margin-top: 50px;">
  <div class="column twelve wide">

    @if (Session::has('message'))
    <div class="ui {{Session::get('status')}} message">
      {{Session::get('message')}}
    </div>
    @endif

    <h1 class="ui header">Login </h1>
    <form class="ui form login" method="POST" action="{{route('login.user')}}">
      @csrf
      <div class="ui error message"></div>

      <div class="field">
        <label>Email Address</label>
        <input type="email" name="email" placeholder="Email Address">
      </div>

      <div class="field">
        <label>Password</label>
        <input type="password" name="password" placeholder="Password">
      </div>

      <div class="ui submit button" id="submitLogin">Submit</div>
      <span>&nbsp;&nbsp; or &nbsp;&nbsp;<a href="{{route('register')}}">Register</span></a>

    </form>
    <!-- <p></p> -->
  </div>
</div>

@endsection