@extends('layouts.main')
@section('title', 'Dashboard | Create Tasks')
@section('script')
<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

<!-- Theme included stylesheets -->
<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
<script>
  jQuery(function() {
    $('.ui.dropdown')
    .dropdown()
  ;
    $("input:radio[name=assignment]").on("change", function() {
      if ($(this).is(":checked")) {
        // do stuff
        if (this.id === 'department') {
          $("#department_select").show()
          $("#staff_select").hide()

        } else {
          $("#staff_select").show()
          $("#department_select").hide()

        }
      }
    }).change()



  })
</script>


@endsection
@section('dashboard_content')
@include('partials.header')


<div class="ui container" style="position:relative;margin:80px auto;padding:80px auto;">
  @if (Session::has('message'))
  <div class="ui {{Session::get('status')}} message">
    {{Session::get('message')}}
  </div>
  @endif
  <!-- 'title','department_id', 'description', 'assigner','status','start','finish', 'notes' -->

  <h2 class="header"><b>New Task</b></h2>
  <p class="ui divider"></p>
  <form class="ui form task" method="POST" action="{{route('admin.task.store')}}">
    @csrf
    <div class="ui error message"></div>
    <div class="ui segment">

    <div class="field">
      <div class="two fields">
        <div class="field">
          <label>Task Title</label>
          <input type="text" name="title" placeholder="Task Title">
        </div>
        <div class="field">
          <label>Task Description</label>
          <input type="text" name="description" placeholder="Task Description">
        </div>


      </div>
    </div>


      <!-- <div class="field">

        <div class="ui form">
          <div class="grouped fields">
            <label>Who gets this task?</label>
            <div class="field">
              <div class="ui radio checkbox">
                <input type="radio" id="department" name="assignment" checked="checked">
                <label>An whole department (Seen by Everyone in the department)</label>
              </div>
            </div>
            <div class="field">
              <div class="ui radio checkbox">
                <input type="radio" id="staff" name="assignment">
                <label>Select Staffs</label>
              </div>
            </div>

          </div>
        </div>
      </div> -->

      <!-- <div class="field" id="department_select">
        <label>Assign Department </label>
        <select name="department_id" class="ui fluid dropdown">
          <option value="">Select Staffs</option>
          @foreach ($departments as $department )
          <option value="{{$department->id}}">{{$department->name}}</option>
          @endforeach

        </select>
      </div> -->
      <!-- <div class="field" id="staff_select">
        <label>Assign to Staffs </label>
        <select name="staff_id[]" class="ui fluid search dropdown" multiple="multiple">
          <option value="">Select Staff(s)</option>
          @foreach ($staffs as $staff )
          <option value="{{$staff->id}}">{{$staff->first_name}}</option>
          @endforeach

        </select>

  
      </div> -->




    <div class="field">
      <label>Start Date</label>
      <input type="date" name="start" placeholder="Start Date">
    </div>

    <div class="field">
      <label>Finish Date</label>
      <input type="date" name="finish" placeholder="Finish Date">
    </div>

    <input type="hidden" name="notes" placeholder="Finish Date">

    <div class="field">
      <label>Task Notes</label>
      <div id="editor-container">
        <p>Tell Me. What has to be done.</p>
      </div>
    </div>

    <div class="ui submit button blue submit_register" id="submitBtn">Create Task</div>
    </div>

  </form>
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

    $('.ui.form.task').form({
      on: 'blur',
      fields: {
        title: {
          identifier: 'title',
          rules: [{
            type: 'empty',
            prompt: 'Please enter a title with atleast 7 characters'
          }, ]
        },
        description: {
          identifier: 'description',
          rules: [{
            type: 'empty',
            prompt: 'Please enter a description with atleast 7 characters'
          }, ]
        },
        start: {
          identifier: 'start',
          rules: [{
            type: 'empty',
            prompt: 'Please enter a valid start date'
          }, ]
        },

        department: {
          identifier: 'department',
          rules: [{
            type: 'empty',
            prompt: 'Please select a department'
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