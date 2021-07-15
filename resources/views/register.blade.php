@extends('layouts.app')
@section('title', 'Register | Task Manager')

@section('script')
<script src="{{ asset('js/register.validation.js') }}"></script>
@endsection

@section('app_content')
<div class="ui hidden divider"></div>

<div class="ui stackable centered page grid">
  <div class="column twelve wide">

    @if (Session::has('message'))
    <div class="ui {{Session::get('status')}} message">
      {{Session::get('message')}}
    </div>
    @endif

    <h1 class="ui header">Register </h1>
    <form class="ui form register" method="POST" action="{{route('register.user')}}">
      @csrf
      <div class="ui error message"></div>

      <div class="field">
        <label>Name</label>
        <div class="two fields">
          <div class="field">
            <input type="text" name="first_name" placeholder="First Name">
          </div>
          <div class="field">
            <input type="text" name="last_name" placeholder="Last Name">
          </div>
        </div>
      </div>

      <div class="field">
        <label>Email Address</label>
        <input type="email" name="email" placeholder="Email Address">
      </div>

      <div class="field">
        <label>Password</label>
        <input type="password" name="password" placeholder="Password">
      </div>

      <div class="ui submit button submit_register" id="submitBtn">Submit</div>
      <span>&nbsp;&nbsp; or &nbsp;&nbsp;<a href="{{route('login')}}">Login</span></a>
    </form>
    <!-- <p></p> -->
  </div>
</div>

@endsection