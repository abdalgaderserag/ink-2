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
        <div class="pop-up"
             style="width: 100%;height: -webkit-fill-available;position: fixed;background-color: #3939396e">
            <div style="background-color: white;min-height: 400px;width: 62%;margin: 82px 0 0 16%;border-top: 6px solid #f98835;">
                <div><- Edit Comment</div>
                <textarea style="width: 94%;margin-left: 1%;padding: 0 2%;" cols="30" rows="10">

                </textarea>
                <div>
                    <img src="/images/ink/attachment.svg" style="width: 30px;height: 30px;margin: 1% 1% 0 0;" alt="">
                </div>
                <div class="flex-box" style="height: 60px;padding: 5px 1%;justify-content: flex-start;">

                    {{--Img View--}}
                    <div class="flex-box" style="justify-content: flex-start">
                        <img style="height: 50px;width: 50px;border-radius: 15px" src="/images/avatars/ariya.jpg"
                             alt="">
                        <div style="cursor: pointer;">
                            <svg style="background-color: #f98835;border-radius: 50%;margin: 0 0 0 -10px;" width="16"
                                 height="16">
                                <path d="m4 8 l8 0" style="stroke: white;"/>
                            </svg>
                        </div>
                    </div>
                    {{--Img View--}}

                </div>
                <div style="padding: 0 20px 0 0;text-align: right">
                    <button style="text-decoration: underline;padding: 4px 2%;width: 10%;border: 0 solid #b2b2b2;background-color: white;border-radius: 16px;font-size: 2.4vh">
                        Cancel
                    </button>
                    <button style="color:white;padding: 4px 2%;width: 10%;border: 1px solid #b2b2b2;background-color: #f98835;border-radius: 16px;font-size: 2.4vh">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    function deleteImage(e) {
        console.log(e);
    }

    function pop() {
        let element = ''
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
