@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <style>
        .ink-main {
            width: 100%;
            background-color: white;
        }

        .card-header {
            justify-content: flex-start;
        }

        .ink-card{
            width: 92%;
            padding: 0 4%;
        }

        .ink-avatar {
            /*padding: 10px 0 0 3%;*/
        }

        .ink-avatar-img {
            width: 60px;
            height: 60px;
            border: 2px solid #f98835;
            border-radius: 50%;
            margin: 0 0 -38px 28%;
        }

        .ink-user-name {
            color: #f98835;
            padding: 0 0 0 22px;
            margin: 10px 0 0 0;
        }

        .card-body {
            border: 2px solid #f98835;
            padding: 35px 2% 8px 2%;
        }

        .card-footer {
            justify-content: space-between;
        }
    </style>
@endsection

@section('content')
    <div class="left-section">
        <div>
        </div>
    </div>
    <div class="main-section">
        <div class="main">
            <ink-main></ink-main>
        </div>
        <div class="right-section">
            <div>
            </div>
        </div>
    </div>
@endsection
