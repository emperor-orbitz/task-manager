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
@include('partials.user.header')


<div class="ui container" style="position:relative;margin:80px auto;padding:80px auto;">
  @if (Session::has('message'))
  <div class="ui {{Session::get('status')}} message">
    {{Session::get('message')}}
  </div>
  @endif

  <h2 class="header"><b> {{$department->name}} Department</b></h2>
  <p class="ui divider"></p>
 







  <div class="ui grid stackable" style="margin:50px auto;">
    <div class="four wide column">

      <h3>Team Members</h3>

      <div class="ui stacked segments">
        @foreach ($members as $m )

        <div class="ui segment">
          <p>{{$m->first_name}} {{$m->last_name}} (Level: {{$m->role}})</p>
          @if (auth()->user()->role >= $m->role && auth()->user()->id != $m->user_id )
          <span><a style="color: red;" href="/supervisor/user/remove/{{$m->connection_id}}">Remove</a></span>

          @elseif (auth()->user()->id == $m->user_id)
          <span>ME</span>

          @else
          @endif
          <!-- @if (auth()->user()->id == $m->user_id )
          <span>Me</span> 
          @endif -->
        </div>
        @endforeach

      </div>
    </div>
    <div class="twelve wide column">

      <h3>Tasks</h3>

      <table class="ui celled table">
        <thead>
          <tr>
            <th>Title</th>
            <th>Start</th>
            <th>Finish</th>
            <th>Progress</th>
            <th>Created On</th>
            <th>Action</th>


          </tr>
        </thead>
        <tbody>
          @forelse ($tasks as $task )
          <tr>
            <td data-label="Title">{{ ucfirst($task->title) }}</td>
            <td data-label="Start">{{ date("F jS, Y", strtotime($task->start)) }}</td>
            <td data-label="Finish">{{ date("F jS, Y", strtotime($task->finish)) }}</td>
            <td data-label="Progress">
              @if($task->progress =='progress' || $task->progress =='complete')
              <span style="color:green">{{ucfirst($task->progress)}}</span>
              @else
              <span>{{ $task->progress }}</span>
              @endif
            </td>
            <td data-label="Created On">{{ date("F jS, Y", strtotime($task->created_at)) }}</td>
            <td data-label="delete"><a href="/user/task/view/{{$task->id}}"><u> Input Progress</u></a></td>
          </tr>
          @empty
          <div class="ui message">

            <p>No Task Available.</p>
          </div>
          @endforelse


        </tbody>
      </table>



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