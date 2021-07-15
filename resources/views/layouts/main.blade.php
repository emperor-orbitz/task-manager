<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<title>@yield('title', 'AC Task Manager')</title>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Fonts -->
  <link rel="stylesheet" type="text/css" href="{{ asset('css/semantic.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="{{ asset('js/semantic.min.js') }}"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/semantic-ui-icon@2.3.3/icon.css" rel="stylesheet">

  @yield('script')
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
</head>

<body>
  @yield('dashboard_content')
</body>

</html>