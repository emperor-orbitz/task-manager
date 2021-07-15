@extends('layouts.main')
@section('title', 'Dashboard | Departments')
@section('script')
<script>
  jQuery(function() {
    // and here your code


    $('.ui.form.department').form({
      on: 'blur',
      fields: {
        name: {
          identifier: 'name',
          rules: [{
            type: 'empty',
            prompt: 'Please enter a description with atleast 4 characters'
          }, ]
        },
        description: {
          identifier: 'description',
          rules: [{
            type: 'empty',
            prompt: 'Please enter a description with atleast 4 characters'
          }, ]
        }
      }
    });
  });
</script>
@endsection
@section('dashboard_content')
@include('partials.header')


<div class="ui container" style="position:relative;margin:80px auto;">
  @if (Session::has('message'))
  <div class="ui {{Session::get('status')}} message">
    {{Session::get('message')}}
  </div>
  @endif

  <h2 class="header"><b>New Departments</b></h2>
  <p class="ui divider"></p>
  <form class="ui form department" method="POST" action="{{route('admin.department.store')}}">
    @csrf
    <div class="ui error message"></div>

    <div class="field">
      <label>Name</label>
      <input type="text" name="name" placeholder="Name">
    </div>


    <div class="field">
      <label>Description</label>
      <input type="text" name="description" placeholder="Description">
    </div>


    <div class="ui submit button submit_department" id="submitBtn">Submit</div>
    <!-- <span>&nbsp;&nbsp; or &nbsp;&nbsp;<a href="{{route('login')}}">Login</span></a>  -->
  </form>

</div>




@endsection