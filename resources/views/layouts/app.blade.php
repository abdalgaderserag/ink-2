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
@yield('head-script')

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

        @auth
            <div class="flex-box g g2">
                <div class="nav-avatar">
                    <a href="/profile">
                        <img src="{{ \Illuminate\Support\Facades\Auth::user()->avatar }}" alt="">
                    </a>
                </div>
                <div class="notifications">
                    <img src="/images/layouts/notification.svg" alt="">
                </div>
                <form id="logout" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
                <div class="nav-menu" onclick="document.getElementById('logout').submit();">
                    <img src="/images/layouts/menu.svg" alt="">
                </div>
            </div>
        @endauth

    </div>

    <div class="container flex-box">
        @yield('content')
        <div style="display: none;" id="pop-up">
        </div>
    </div>
</div>
<script>
    let mediaTemp;
    let app = new Vue({
        el: '#app',
        data: {
            user: {!! \Illuminate\Support\Facades\Auth::user() !!}
        }
    });

    //cla height.
    let nav = document.getElementsByClassName('nav-bar')[0];
    let height = window.innerHeight - nav.offsetHeight;


    //bind the height to views.
    if (document.getElementsByClassName('left-section').length !== 0) {
        document.getElementsByClassName('left-section')[0].style.height = height + 'px';
        document.getElementsByClassName('main-section')[0].style.height = height + 'px';
        document.getElementsByClassName('main')[0].style.minHeight = 1 + height + 'px';
    }

    //Click event listen for the hide the menus
    document.onclick = (e) => {
        let cardMenu = document.getElementsByClassName('card-menu');
        for (let i = 0; i < cardMenu.length; i++) {
            if (!(e.target.className == 'card-menu' || e.target.id == 'arrow' || e.target.localName == 'path'))
                cardMenu[i].style.display = 'none';
        }
    };


    //GET ugly
    function pop() {
        //start drawing
        document.getElementById('pop-up').style.display = 'block';
        element = `<div class="pop-card">
<div class="pop-header">
<img onclick="document.getElementById('pop-up').style.display = 'none';" src="/images/ink/back.png" style="cursor: pointer;width: 32px;margin:0 0 -5px 0">
Edit Comment</div>
<textarea id="pop-text" cols="30" rows="10">
${mediaTemp.text}
</textarea>
<div class="attachment flex-box">
<img src="/images/ink/attachment.svg">
<span>Add image or video or Gif</span>
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
<span onclick="document.getElementById('pop-up').style.display = 'none';">
Cancel
</span>
<button id="save">
Save
</button>
</div>
</div>`;
        //    bind draw
        document.getElementById('pop-up').innerHTML = element;
    }

    @yield('foot-script')

</script>
</body>
</html>
