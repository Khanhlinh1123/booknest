<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Admin Dashboard')</title>
  <link rel="stylesheet" href="{{ asset('adminator/style.css') }}">
  <link rel="stylesheet" href="{{ asset('adminator/vendor.css') }}">
</head>
<body class="app">
  @yield('content')

  <script src="{{ asset('adminator/vendor.js') }}"></script>
  <script src="{{ asset('adminator/bundle.js') }}"></script>
</body>
</html>
