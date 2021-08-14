@extends('layouts.main')
@section('title', 'Dashboard | Tasks')
@section('script')
<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

<!-- Theme included stylesheets -->
<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
<script>
    jQuery(function() {
        $('.ui.dropdown')
            .dropdown();
    })
</script>


@endsection
@section('dashboard_content')
@include('partials.supervisor.header')


<div class="ui container" style="position:relative;margin:80px auto;padding:80px auto;">
@if (Session::has('message'))
  <div class="ui {{Session::get('status')}} message">
    {{Session::get('message')}}
  </div>
  @endif


    <div style="min-height:150px;">
        <h1>{{$user->first_name}}'s Task</h1>
        <p><b>Full Name:</b> {{$user->first_name}} {{ $user->last_name}}</p>
        <span><b>Email/ Login ID:</b> {{$user->email}}</span>
    </div>



    <div>

        <div class="ui segment">
            <form class="ui form task" method="POST" action="{{route('admin.user.task.create')}}">
            @csrf
            <div class="ui error message"></div>
                <div style="margin-bottom:50px">
                <input type="hidden" name="user_id" value="{{$user->id}}">
                    <div class="ui fluid search selection dropdown" style="margin-bottom: 10px;">
                        <input type="hidden" name="task_id">
                        <i class="dropdown icon"></i>
                        <div class="default text">Select Task</div>
                        <div class="menu">
                            @foreach ($tasks as $task)
                            <div class="item" data-value="{{$task->id}}">{{$task->title}}</div>
                            @endforeach

                        </div>
                    </div>
                    <button type="submit" class="fluid ui button">Add to User Panel</button>

                </div>
            </form>

            @if (count($task_connections) > 0)
            <h3>Tasks Panel</h3>



            <table class="ui celled responsive table">
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
                    @foreach ($task_connections as $task )
                    <tr>
                        <td data-label="Title">{{ ucfirst($task->title) }}</td>
                        <td data-label="Start">{{ date("F jS, Y", strtotime($task->start)) }}</td>
                        <td data-label="Due Date">{{ date("F jS, Y", strtotime($task->finish)) }}</td>
                        <td data-label="Progress">
                            @if($task->progress =='progress' || $task->progress =='complete')
                            <span style="color:green">{{ucfirst($task->progress)}}</span>
                            @else
                            <span>{{ $task->progress }}</span>
                            @endif
                        </td>
                        <td data-label="Created On">{{ date("F jS, Y", strtotime($task->created_at)) }}</td>
                        <td data-label="delete"><a href="/supervisor/task/delete/{{$task->id}}" style="color:red"><u>Delete</u></a> | <a href="/supervisor/task/view/{{$task->id}}"><u>See Timelines</u></a></td>


                    </tr>
                    @endforeach


                </tbody>
            </table>

            @else
            <div class="ui" style="text-align: center;">
                <span class="material-icons" style="font-size: 100px;">
                    add_to_queue
                </span>
                <p>Add New Tasks to this Staff</p>
            </div>
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

        $('.ui.form.task').form({
            on: 'blur',
            fields: {
                task_id: {
                    identifier: 'task_id',
                    rules: [{
                        type: 'empty',
                        prompt: 'Cannot accept empty Task'
                    }, ]
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