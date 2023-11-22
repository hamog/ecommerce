<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no"
          name="viewport">
    <meta name="csrf-token"
          content="{{ csrf_token() }}">
    <title>Ecommerce Dashboard - @yield('title')</title>

    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
          crossorigin="anonymous">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
<div id="app">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>

        @include('layouts.partials.navbar')

        @include('layouts.partials.sidebar')

        <div class="main-content">
            @yield('content')
        </div>

        @include('layouts.partials.footer')
    </div>
</div>
</body>

</html>
