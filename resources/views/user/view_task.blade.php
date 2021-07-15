




















































@extends('layouts.main')
@section('title', 'Dashboard | Timelines -> Tasks')
@section('script')
<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

<!-- Theme included stylesheets -->
<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">

@endsection
@section('dashboard_content')
@include('partials.user.header')

<div style="position:relative;">

<div class="ui container" style="margin:80px auto;">
  @if (Session::has('message'))
  <div class="ui {{Session::get('status')}} message">
    {{Session::get('message')}}
  </div>
  @endif


  <h2 class="header">{{$task->title}} (Status: {{ucfirst($task->progress)}})</h2>
  <p><b>About this Task:</b> {{$task->description}}</p>
  <p><b>From</b>: {{date("F jS, Y", strtotime($task->start))}} to  {{date("F jS, Y", strtotime($task->end))}}</p>

  <p class="ui divider"></p>
  <form class="ui form task" method="POST" action="/user/task/edit">
    @csrf
    <div class="ui error message"></div>
    <input type="hidden" name="task_id" value="{{$task->id}}">

 

    <input type="hidden" name="task_updates" placeholder="Finish Date">
    <div class="field">
      <label>Progress Summmary</label>
      <textarea name="notes" id="" cols="30" rows="5"></textarea>
    </div>
    
    <div class="field">
      <label>Add Progress in Details</label>
      <div id="editor-container">
        <p>Any Resultss?</p>
      </div>
    </div>

    <div class="ui submit button blue submit_register" id="submitBtn">Add Progress</div>
    <!-- <span><a href="{{route('login')}}">Login</span></a>  -->
  </form>


    <div style="margin:80px auto; padding-bottom: 50px;">
    <h2 class="header">Project Timeline Activities</h2>
    <p class="ui divider"></p>
    
    <table class="ui single line table">
  <thead>
    <tr>
        <th>No.</th>
      <th>User</th>
      <th>Notes</th>
      <th>See Details/Draft</th>
      <th>Last Updated</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($timelines as $timeline)
    <tr>
    <td> {{$loop->iteration}}</td>

      <td>  {{$timeline->first_name}} {{$timeline->last_name}}</td>
      <td>  {{$timeline->notes}}</td>
      <td><a href="/user/task/draft/{{$timeline->id}}"> See Details</a></td>
      <td>{{date("F jS", strtotime($timeline->updated_at))}} </td>
    </tr>

    @empty
    <div class="ui message">
  <div class="header">
    Attention
  </div>
  <p>You have not made any Progress to this Task!</p>
</div>
    @endforelse


    </tbody>
</table>








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
    // $('.ui.accordion').accordion();

    // var about = document.querySelector('input[name=notes]');
    // about.value = quill.setContents(<?php echo $task->notes;?>);

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
        var about = document.querySelector('input[name=task_updates]');
        about.value = JSON.stringify(quill.getContents());
        return true;
      }
    });

  });
</script>

@endsection