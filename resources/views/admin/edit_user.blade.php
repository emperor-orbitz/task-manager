@extends('layouts.main')
@section('title', 'Dashboard | Edit '.$data->first_name )
@section('script')
<!-- <script src="//cdn.quilljs.com/1.3.6/quill.js"></script> -->
<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

<!-- Theme included stylesheets -->
<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">

@endsection
@section('dashboard_content')
@include('partials.header')


<div class="ui hidden divider"></div>

<div class="ui stackable centered page grid">
    <div class="column twelve wide">

        @if (Session::has('message'))
        <div class="ui {{Session::get('status')}} message">
            {{Session::get('message')}}
        </div>
        @endif

        <h1 class="ui header">Edit User </h1>
        <form class="ui form new" method="POST" action="{{route('admin.user.post.edit')}}">
            @csrf
            <div class="ui error message"></div>
            <input type="hidden" name="id" value="{{$data->id}}">
            <div class="field">
                <label>Name</label>
                <div class="two fields">
                    <div class="field">
                        <input type="text" name="first_name" placeholder="First Name" value="{{$data->first_name}}">
                    </div>
                    <div class="field">
                        <input type="text" name="last_name" placeholder="Last Name" value="{{$data->last_name}}">
                    </div>
                </div>
            </div>

            <div class="field">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Email Address" value="{{$data->email}}">
            </div>


            <div class="field">
                <label>User Type</label>
                <select name="role" placeholder="Select User Role">
                    <option value="">Select User Role</option>
                    <option value="3" {{$data->role == '3'? 'selected': 'false' }}>Admin</option>
                    <option value="2" {{$data->role == '2'? 'selected': 'false' }}>Supervisor/ Team Lead</option>
                    <option value="1" {{$data->role == '1'? 'selected': 'false' }}>User/ Member</option>
                </select>
            </div>

            <div class="ui submit button submit_register" id="submitBtn">Update User Details</div>
        </form>
        <!-- <p></p>-->
    </div>

    <div class="column twelve wide">
            <hr>
        @if (Session::has('password_status'))
        <div class="ui {{Session::get('password_status')}} message">
            {{Session::get('password_message')}}
        </div>
        @endif

        <h3 class="ui header">Update Password</h3>
        <form class="ui form new" method="POST" action="{{route('admin.user.password.edit')}}">
            @csrf
            <div class="ui error message"></div>

            <div class="field">
                <input type="hidden" name="id" value="{{$data->id}}">

                <label>Password</label>
                <input type="password" required name="password" placeholder="Set New Password" value="">
            </div>
            <div class="ui submit button submit_register" id="submitBtn">Update Password</div>
        </form>
        <!-- <p></p>-->
    </div>
</div>




<script>
    jQuery(function() {
        // and here your code

        $('.ui.form.new').form({
            on: 'blur',
            fields: {
                first_name: {
                    identifier: 'first_name',
                    rules: [{
                        type: 'empty',
                        prompt: 'Please enter a title with atleast 7 characters'
                    }, ]
                },
                last_name: {
                    identifier: 'last_name',
                    rules: [{
                        type: 'empty',
                        prompt: 'Please enter a description with atleast 7 characters'
                    }, ]
                },
                email: {
                    identifier: 'email',
                    rules: [{
                        type: 'email',
                        prompt: 'Please enter a valid Email Address'
                    }, ]
                },

                role: {
                    identifier: 'role',
                    rules: [{
                        type: 'empty',
                        prompt: 'Please select a Role'
                    }, ]
                },
                password: {
                    identifier: 'password',
                    rules: [{
                        type: 'minLength[6]',
                        prompt: 'Please enter a valid Password'
                    }]
                }
            },
            onSuccess: function(event, fields) {
                // var about = document.querySelector('input[name=notes]');
                // about.value = JSON.stringify(quill.getContents());
                return true;
            }
        });

    });
</script>

@endsection