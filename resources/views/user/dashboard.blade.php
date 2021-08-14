@extends('layouts.main')
@section('title', 'Dashboard')
@section('script')
<script>
  jQuery(function() {

 
  })
</script>
@endsection
@section('dashboard_content')
@include('partials.user.header')


<div class="ui container" style="position:relative;margin:100px auto !important;padding:100px auto !important;">
  @if (Session::has('message'))
  <div class="ui {{Session::get('status')}} message">
    {{Session::get('message')}}
  </div>
  @endif

  <div style="margin:50px auto">
    <h1 class="header">Hi User</h1>
    <p>Check your Departments to know Pending Task to attend to.</p>
  </div>
  <h3 class="header"><b>Your Task(s)</b></h3>
  <p class="ui divider"></p>





  <div class="ui container segment" style="border:0px">
    <div class="ui grid stackable">


      @forelse ( $tasks as $task )
      <div class="four wide column">
        <a href="/user/task/view/{{$task->id}}">
          <div class="ui card" style="cursor:pointer;">
            <div class="content">
              <div class="header">{{$task->title}}</div>
              <div class="meta">Created on {{date("F jS,", strtotime($task->created_at))}} </div>
              <div class="description">
                <p>
                  {{$task->description}}
                </p>
              </div>
            </div>
            <div class="extra content">
              <i class="check ui icon"></i>
              click to view
            </div>
          </div>
        </a>
      </div>

      @empty
        
      <div style="text-align:center; width:100%; padding:20px">
        <span class="material-icons" style="font-size: 100px;">
          hourglass_empty
        </span>
        <p>There are no departments here</p>
      </div>

      @endforelse 


    </div>
  </div>




  <!-- USERS-->


  <h3 class="header"><b>Everyone in the Organisation ({{count($users)}})</b></h3>
  <p class="ui divider"></p>

  <div class="ui container segment" style="min-height:300px;border:0px; ">
    <div class="ui grid stackable">

      <table class="ui selectable celled table">
        <thead>
          <tr>
            <th>id</th>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Role(Level)</th>
            <!-- <th>Delete (Caution)</th> -->

          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)

          <tr>
            <td>

              <u>{{$loop->iteration}}</u>
            </td>
            <td>{{$user->email}}</td>
            <td>{{$user->first_name}}</td>
            <td>{{$user->last_name}}</td>
            <td>{{$user->role}}</td>
            <!-- <th><a href="/admin/user/delete/{{$user->id}}" style="color: red !important;">Remove User</a></th> -->

          </tr>

          @endforeach
        </tbody>
      </table>



    </div>




  </div>
</div>


<!-- </div> -->

</div>


@endsection