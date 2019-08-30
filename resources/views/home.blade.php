@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pop.css') }}">
@endsection

@section('content')
    <div class="left-section">
        <chat></chat>
    </div>
    <div class="flex-box main-section">
        <div class="main">
            <?php print_r($access['access_token']) ?>
            <ink-main></ink-main>
        </div>
        <div class="right-section">
            <div>
            </div>
        </div>
    </div>
@endsection


@section('foot-script')
    {{--<script>--}}
    Echo.private('App.Chat.1').notification((noti) => {
    console.log(noti)
    });
@endsection