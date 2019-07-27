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
<?php
\Illuminate\Support\Facades\Auth::loginUsingId(1);
?>
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
                    <img src="{{ \Illuminate\Support\Facades\Auth::user()->avatar }}" alt="">
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
        <div style="display: none;" id="pop-up">
        </div>
    </div>
</div>
<script>

    function deleteImage(e) {
        console.log(e);
    }

    function pop(media = 'asdasd') {
        document.getElementById('pop-up').style.display = 'block';
        let element = `<div class="pop-card">
<div class="pop-header"><- Edit Comment</div>
<textarea cols="30" rows="10">
${media}
</textarea>
<div class="attachment">
<img src="/images/ink/attachment.svg">
</div>
<div class="flex-box images-pop">
<div class="flex-box pop-icon">
<img class="image" src="/images/avatars/ariya.jpg">
<div>
<svg>
<path d="m4 8 l8 0" style="stroke: white;"/>
</svg>
</div>
</div>
</div>
<div class="pop-buttons">
<span>
Cancel
</span>
<button>
Save
</button>
</div>
</div>`;
        return element;
    }

    let app = new Vue({
        el: '#app',
        data: {
            user: {!! \Illuminate\Support\Facades\Auth::user() !!}
        }
    });
</script>
</body>
</html>
