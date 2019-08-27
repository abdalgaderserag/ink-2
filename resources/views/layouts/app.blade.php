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
<div id="app" class="flex-box">
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
                    <img onclick="let type = '';
                    document.getElementById('notifications').style.display == 'none'? type = 'block':type = 'none';
                    document.getElementById('notifications').style.display = type;"
                         src="/images/layouts/notification.svg" alt="">
                    <div id="notifications" style="display: none;position: absolute;">
                        <notifications></notifications>
                    </div>
                </div>
                <form id="logout" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
                <div class="nav-menu" onclick="localStorage.clear();document.getElementById('logout').submit();">
                    <img src="/images/layouts/menu.svg" alt="">
                </div>
            </div>
        @elseguest
            <a href="/log" class="link-clear">Login</a>
            <a href="/log?register=true" class="link-clear">Register</a>
        @endauth

    </div>

    <div class="container flex-box">
        @yield('content')
        <div style="display: none;" id="pop-up">
        </div>
    </div>
</div>
<script>

    window.axios.defaults.headers.common["Authorization"] = `Bearer ${localStorage.access_token}`;

    /*window.Echo.constructor({
        broadcaster: 'socket.io',
        host: window.location.hostname + ':6001',
        auth: {
            headers: {
                Authorization: `Bearer ${localStorage.access_token}`,
            }
        }
    });*/

    //cla height.
    let nav = document.getElementsByClassName('nav-bar')[0];
    let height = window.innerHeight - nav.offsetHeight;

    let mediaTemp;
    let app = new Vue({
        el: '#app',
        @auth
        data: {
            user: {!! \Illuminate\Support\Facades\Auth::user() !!},
        },
        @endauth
    });


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
<input style="display: none" type="file" id="upload-ink">
<div onclick="event.preventDefault();document.getElementById('upload-ink').click();" class="attachment flex-box">
<img src="/images/ink/attachment.svg">
<span>Add image or video or Gif</span>
</div>
<div id="images-edit" class="flex-box images-pop">
${getImages()}
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
        ready();
    }

    function ready() {
        document.getElementById('upload-ink').onchange = (e) => {
            let read = new FileReader();
            read.readAsDataURL(e.target.files[0]);
            read.onload = () => {
                axios.post('/api/upload', {result: read.result})
                    .then(response => {
                        addedImage(response.data.path);
                    });
            }
        };
    }

    function addedImage(src) {
        document.getElementById('images-edit').innerHTML = document.getElementById('images-edit').innerHTML + getImage(src);
        mediaTemp.media.push(src);
    }

    function getImages() {
        if (mediaTemp.media == null)
            return '';

        let media = ``;
        for (let i = 0; i < mediaTemp.media.length; i++)
            media = media + getImage(mediaTemp.media[i]);
        return media;
    }

    function getImage(src) {
        return `<div class="flex-box pop-icon">
<img style="object-fit: cover;" class="image" src="${src}">
<div onclick="event.target.parentElement.parentElement.remove();">
<svg>
<path d="m4 8 l8 0" style="stroke: white;"/>
</svg>
</div>
</div>`;
    }


    @yield('foot-script')

        window.onresize = function () {
        height = window.innerHeight - nav.offsetHeight;

        //bind the height to views.
        if (document.getElementsByClassName('left-section').length !== 0) {
            document.getElementsByClassName('left-section')[0].style.height = height + 'px';
            document.getElementsByClassName('main-section')[0].style.height = height + 'px';
            document.getElementsByClassName('main')[0].style.minHeight = 1 + height + 'px';
        }
    };
</script>
</body>
</html>
