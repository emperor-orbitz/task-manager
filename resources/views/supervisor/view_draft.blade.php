@extends('layouts.main')
@section('title', 'Dashboard | Timelines -> Draft')
@section('script')
<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

<!-- Theme included stylesheets -->
<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
<style>
img{
  width:100%;
}
</style>
@endsection
@section('dashboard_content')
@include('partials.supervisor.header')

<div style="position:relative;">

  <div class="ui text container" style="margin:80px auto;">


    <h3 class="header">{{$timeline->notes}}</h3>

    <p class="ui divider"></p>

    <div style="display: none;" id="editor-container">
      <p>Tell Me. What has to be done.</p>
    </div>
    <div id="show"> </div>



  </div>


</div>


<script>
  var quill = new Quill('#editor-container', {
    modules: {
      toolbar: []
    },


    placeholder: 'Compose an epic...',
    theme: 'bubble'
  });



  jQuery(function() {
    // and here your code

    var about = document.querySelector('input[name=notes]');
    quill.setContents(<?php echo $timeline->task_updates; ?>);
    var html = quill.root.innerHTML;
    document.getElementById('show').innerHTML = html;
    console.log(<?php echo $timeline->task_updates; ?>);


  });
</script>

@endsection