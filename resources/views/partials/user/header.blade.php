<div class="ui top fixed menu" style="position:relative">
  <a href="{{route('user.dashboard')}}">
    <div class="item" style="cursor:pointer;" id="toggleMenu">
      <span class="material-icons">widgets</span>
      <span>Task Manager</span>
    </div>
  </a>
  <div class="right menu">
    <div class="ui simple dropdown item">
      Menu
      <i class="dropdown icon"></i>
      <div class="menu">
        <!-- <div class="item">Departments</div> -->
        <!-- <div class="item"><a href="{{route('supervisor.user')}}">Create User</a></div>
        <div class="item"><a href="{{route('supervisor.task.create')}}">Create Task</a></div> -->

        <div class="item" style="color: red !important;"> <a href="{{route('logout')}}">Logout</a> </div>

      </div>
    </div>
    <a class="item">Hi, {{auth()->user()['first_name']}}</a>
  </div>
</div>