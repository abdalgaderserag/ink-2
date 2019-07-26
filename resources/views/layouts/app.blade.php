<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
{{--<link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
{{--<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">--}}

<!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
<div id="app">

    <div class="nav-bar flex-box">
        <div class="flex-box g g1">
            <div class="logo-title">
                <a href="/" class="link-clear">Ink.</a>
            </div>
            <div class="search">
                <input type="search" placeholder="search">
            </div>
        </div>
        <div class="flex-box g g2">
            <div class="nav-avatar">
                <a href="/profile">
                    <img src="/images/avatars/a5364090-db15-4621-9661-1be314605dac.png" alt="">
                </a>
            </div>
            <div class="notifications">
                <img src="/images/layouts/notification.svg" alt="">
            </div>
            <div class="nav-menu">
                <img src="/images/layouts/menu.svg" alt="">
            </div>
        </div>
    </div>

    <div class="container flex-box">
        @yield('content')
    </div>
</div>
<script>
    <?php
            \Illuminate\Support\Facades\Auth::loginUsingId(1);
    ?>
    let app = new Vue({
        el: '#app',
        data: {
            user: {!! \Illuminate\Support\Facades\Auth::user() !!}
        }
    });
</script>
</body>
</html>
