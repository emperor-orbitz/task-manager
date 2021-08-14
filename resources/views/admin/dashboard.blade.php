@extends('layouts.main')
@section('title', 'Dashboard')
@section('script')
<script>
  jQuery(function() {

    $(".openModal").click(function() {
      $('.mini.modal').modal('show')

      document.getElementById("deleteBtn").href = `/admin/user/delete/${this.id}`;

    })

    $(".openModalSupervisor").click(function() {
      if(this.name != 2) return window.location.href = `/admin/user/task/${this.id}`;

      $('.mini.modal.supervisor_modal').modal('show');
      document.getElementById("deleteBtnSupervisor").href = `/admin/user/task/${this.id}`;

    })
  })
</script>
@endsection
@section('dashboard_content')
@include('partials.header')


<div class="ui container" style="position:relative;margin:100px auto !important;padding:100px auto !important;">
  @if (Session::has('message'))
  <div class="ui {{Session::get('status')}} message">
    {{Session::get('message')}}
  </div>
  @endif

  <div style="margin:50px auto">
    <h1 class="header">Welcome, Admin</h1>
    <a href="{{route('admin.department.create')}}">
      <button class="ui primary button">
        Create Department
      </button>
    </a>
    <a href="{{route('admin.user')}}">
      <button class="ui black button">
        Create A New User
      </button>
    </a>
    <a href="{{route('admin.task.create')}}">
      <button class="ui green button">
        Create Task
      </button>
    </a>

    <!-- <a href="{{route('admin.task.create')}}">
      <button class="ui grey button">
        View all Tasks
      </button>
    </a> -->
  </div>






  <div class="ui container segment" style="border:0px">
    <h3 class="header"><b>Departments</b></h3>
    <p class="ui divider"></p>
    <div class="ui grid stackable">


      @forelse ($departments as $department)

      <div class="four wide column">
        <a href="/admin/department/{{$department->id}}">
          <div class="ui card" style="cursor:pointer;">
            <div class="content">
              <div class="header">{{$department->name}}</div>
              <div class="meta">Created on {{date("F jS,", strtotime($department->created_at))}} </div>
              <div class="description">
                <p>
                  {{$department->description}}
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


  <h3 class="header"><b>Users</b></h3>
  <p class="ui divider"></p>

  <div class="ui container segment" style="min-height:300px;border:0px; margin-bottom:50px !important">
    <div class="ui grid stackable">

      <table class="ui selectable celled table">
        <thead>
          <tr>
            <th>id</th>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Role(Level)</th>
            <th>Actions (Caution)</th>

          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)

          <tr>
            <td>
              @if (auth()->user()->id === $user->id)
              ME
              @else

              -

              @endif
            </td>
            <td><a href="{{route('admin.user.get.edit', ['id'=> $user->id])}}">{{$user->email}}</a></td>
            <td>{{$user->first_name}}</td>
            <td>{{$user->last_name}}</td>
            <td>{{$user->role}}</td>
            <td>
              @if (auth()->user()->id === $user->id)
              Unavailable
              @else
              <button id="{{$user->id}}" class="openModal ui red button mini ">Delete User</button>
              <a href="{{route('admin.user.get.edit', ['id'=> $user->id])}}"><button class="ui button mini ">Update Details</button></a>
              @if ($user->role != 3)
              <button id="{{$user->id}}" name="{{$user->role}}" class="ui green button mini openModalSupervisor">Tasks/ Assign Task</button> 

              @else
                -
              @endif
              @endif

            </td>

          </tr>

          @endforeach
        </tbody>
      </table>



    </div>




  </div>

  <!--Start Modal-->
  <div class="mini ui modal">
    <div class="header">Remove User?</div>
    <div class="content">
      <p>Are you sure you want to remove this user?</p>
    </div>
    <div class="actions">

      <a id="deleteBtn" href="/admin/user/delete/">
        <button class="ui red button">Approve</button>

      </a>
      <div class="ui cancel button">Cancel</div>
    </div>
  </div>
</div>

<!--End Modal-->


 <!--Start 'Are you sure' Modal-->
 <div class="mini ui modal supervisor_modal">
    <div class="header">Assign Supervisor?</div>
    <div class="content">
      <p>Do you want to assign task to a Supervisor? He'll still see it.</p>
    </div>
    <div class="actions">

      <a id="deleteBtnSupervisor" href="/admin/user/delete/">
        <button class="ui green button">Continue</button>

      </a>
      <div class="ui cancel button">Cancel</div>
    </div>
  </div>
</div>

<!--End 'Are you sure' Modal-->

</div>


<!-- </div> -->

</div>


@endsection