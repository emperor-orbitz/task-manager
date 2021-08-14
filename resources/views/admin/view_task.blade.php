@extends('layouts.main')
@section('title', 'Dashboard | Timelines | Tasks')
@section('script')
<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

<!-- Theme included stylesheets -->
<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">

@endsection
@section('dashboard_content')
@include('partials.header')

<div style="position:relative;">

  <div class="ui container" style="margin:80px auto;">
    @if (Session::has('message'))
    <div class="ui {{Session::get('status')}} message">
      {{Session::get('message')}}
    </div>
    @endif


    <h2 class="header">Project Timeline Activities for {{$task->title}}</h2>
    <p><b>About this Task:</b> {{$task->description}}</p>
    <p><b>Project Duration</b>: {{date("F jS, Y", strtotime($task->start))}} to {{date("F jS, Y", strtotime($task->end))}}</p>
    <!-- <p><b>A:</b> {{$task->description}}</p> -->

    <!-- <p class="ui divider"></p> -->
    <!-- <form class="ui form task" method="POST" action="{{route('admin.task.edit')}}">
    @csrf
    <div class="ui error message"></div>
    <input type="hidden" name="id" value="{{$task->id}}">

    
    <div class="field">
        <label>Update Project Status (completed/in progress/archived)</label>
        <select name="progress" placeholder="Select User Role" value="{{$task->progress}}">
        <option value="">Change Status</option>
        <option value="complete" >Completed</option>
        <option value="progress">In Progress</option>
        <option value="archive">Archived</option>

        </select>
      </div>

    <div class="field">
      <div class="two fields">
        <div class="field">
          <label>Change Start</label>
          <input type="date" value="{{date('Y-m-d', strtotime($task->start))}}" name="start" placeholder="Start Date">
        </div>
        <div class="field">
          <label>Change Finish (Deadline)</label>
          <input type="date" value="{{date('Y-m-d', strtotime($task->start))}}" name="finish" placeholder="Finish Date">
        </div>
      </div>
    </div>

    <input type="hidden" name="notes" placeholder="Finish Date">
    <div class="field">
      <label>Update Task Notes</label>
      <div id="editor-container">
        <p>Tell Me. What has to be done.</p>
      </div>
    </div>

    <div class="ui submit button blue submit_register" id="submitBtn">Update Task</div>
    <span><a href="{{route('login')}}">Login</span></a> 
  </form>
 -->

    <div style="padding-bottom: 50px;">
      <!-- <h2 class="header"></h2> -->
      <p class="ui divider" style="margin-top:30px;margin-bottom:30px"></p>
      @if (count($timelines) > 0)

      <table class="ui single line table">
        <thead>
          <tr>
            <th>No.</th>    
            <th>Last Updated</th>

            <th>Progress</th>
            <th>Notes</th>
            <th>See Details/Draft</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($timelines as $timeline)
          <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{date("F jS", strtotime($timeline->updated_at))}} </td>

            <td style="color:green"> {{$timeline->progress}}%</td>
            <td> {{$timeline->notes}}</td>
            <td><a href="/admin/task/draft/{{$timeline->id}}"> See Details</a></td>
          </tr>
          @endforeach



        </tbody>
      </table>
      @else
      <p>This User hasn't made updates to this task yet!</p>

      @endif









    </div>

  </div>


</div>


<script>
  var quill = new Quill('#editor-container', {
    modules: {
      toolbar: [
        ['bold', 'italic'],
        ['link', 'blockquote', 'code-block', 'image'],
        [{
          list: 'ordered'
        }, {
          list: 'bullet'
        }]
      ]
    },


    placeholder: 'Compose an epic...',
    theme: 'snow'
  });



  jQuery(function() {
    // and here your code
    $('.ui.accordion').accordion();

    var about = document.querySelector('input[name=notes]');
    about.value = quill.setContents(<?php echo $task->notes; ?>);

    console.log(<?php echo $task->notes; ?>);
    $('.ui.form.task').form({
      on: 'blur',
      fields: {

        start: {
          identifier: 'start',
          rules: [{
            type: 'empty',
            prompt: 'Please enter a valid start date'
          }, ]
        },

        progress: {
          identifier: 'progress',
          rules: [{
            type: 'empty',
            prompt: 'Please Update Progress'
          }, ]
        },
        finish: {
          identifier: 'finish',
          rules: [{
            type: 'empty',
            prompt: 'Please enter a valid finish date'
          }]
        }
      },
      onSuccess: function(event, fields) {
        var about = document.querySelector('input[name=notes]');
        about.value = JSON.stringify(quill.getContents());
        return true;
      }
    });

  });
</script>

@endsection