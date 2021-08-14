@extends('layouts.main')
@section('title', 'Dashboard | Department')
@section('script')
<!-- <script src="//cdn.quilljs.com/1.3.6/quill.js"></script> -->
<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

<!-- Theme included stylesheets -->
<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">

@endsection
@section('dashboard_content')
@include('partials.header')


<div class="ui container" style="position:relative;margin:80px auto;padding:80px auto;">
  @if (Session::has('message'))
  <div class="ui {{Session::get('status')}} message">
    {{Session::get('message')}}
  </div>
  @endif

  <h2 class="header"><b> {{$department->name}} Department</b></h2>
  <p class="ui divider"></p>
  <form class="ui form dept" method="POST" action="{{route('admin.connection.store')}}">
    @csrf
    <div class="ui error message"></div>


    <div class="field">
      <label>Add User to Department</label>
      <input type="hidden" name="department_id" value="{{$department->id}}">
      <select name="user_id" class="ui search dropdown">
        <option value="">Select Staff</option>
        @foreach ($non_members as $nm )
        <option value="{{$nm->id}}">{{$nm->first_name}} {{$nm->last_name}} (Level:{{$nm->role}})</option>
        @endforeach
      </select>

    </div>

    <div class="ui submit button blue submit_register" id="submitBtn">Add Staff to Department</div>

  </form>







  <div class="ui grid stackable" style="margin:50px auto;">
    <div class="four wide column">
    <h3>Team Members</h3>

    @if (count($members) > 0)

<div class="ui stacked segments">
  @foreach ($members as $m )

  <div class="ui segment">
    <p>{{$m->first_name}} {{$m->last_name}} (Level: {{$m->role}})</p>
    @if (auth()->user()->role >= $m->role && auth()->user()->id != $m->user_id )
    <span><a style="color: red;" href="/admin/user/remove/{{$m->connection_id}}">Remove</a></span>

    @elseif (auth()->user()->id == $m->user_id)
    <span>ME</span>

    @else
    @endif

  </div>
  @endforeach

</div>
    @else
      <div>
        <p>Seems, there's no one here. Start by adding someone</p>
      </div>
    @endif
     
    </div>
    <div class="twelve wide column">


    </div>

  </div>
</div>




<script>
  jQuery(function() {
    // and here your code

    $('.ui.form.dept').form({
      on: 'blur',
      fields: {
        user_id: {
          identifier: 'user_id',
          rules: [{
            type: 'empty',
            prompt: 'Please select a user'
          }, ]
        }

      },
      onSuccess: function(event, fields) {
        return true;
      }
    });

  });
</script>


@endsection