@extends('layouts.app')

@section('styles')
    <style>

        body {
            font-family: sans-serif;
        }

        .log-box {
            width: 349px;
            background-color: #FFFFFF;
            padding: 68px;
            border-top: #F98835 solid 8px;
        }

        .log-title {
            width: 100%;
            text-align: center;
            font-size: 38px;
        }

        .log-box input {
            width: 100%;
            margin-top: 32px;
            font-size: 16px;
            padding: 12px;
            border: 2px solid #d2d2d2;
            border-radius: 4px;
        }

        .log-box button {
            width: 30%;
            margin-left: 35%;
            margin-top: 32px;
            font-size: 16px;
            text-align: center;
            color: #FFFFFF;
            background: linear-gradient(to right, #FD2220, #F98835);
            border: 0px solid #404040;
            border-radius: 4px;
            padding: 12px;
        }

        .footer {
            background-color: #333333;
            width: 100%;
            height: 180px;
            margin-top: 45.95997%;
        }

        .log {
            margin: 8% 13.177159%;
            width: 73.645682%;
        }

        .box-title {
            margin-bottom: 18px;
        }

        .box-title h1 {
            margin: 12px 0px;
        }

        .box-title span {
            font-size: 22px;
            color: #333333a3;
        }
    </style>
@endsection

@section('content')
    <div id="log-body" style="width: 100%;overflow-y: auto;">
        <div class="log">
            <div class="log-box" style="float: left;margin-right: 10px">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="log-title">
                        Sign In
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           placeholder="username or email"
                           required autofocus>


                    <input id="password" type="password" name="password" placeholder="password" required>


                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>
                </form>
            </div>

            <div class="box-title">
                <h1>New to Ink?</h1>
                <span>
                Join our huge communite today by sign up in the form blow.
            </span>
            </div>


            <div class="log-box" style="float: left;margin-left: 10px">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="log-title">
                        Sign Up
                    </div>

                    <input type="text" name="name" placeholder="name" required>

                    <input type="text" name="slug" placeholder="slug" required>

                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email" required>

                    <input type="password" name="password" placeholder="password" required>

                    <input type="password" name="password" placeholder="confirm password" required>

                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                </form>
            </div>
        </div>


        <div style="height: 200px;width: 100%;margin-top:90px;background-color: #636b6f;float: right;">
        </div>
    </div>
@endsection


@section('foot-script')
    document.getElementById('log-body').style.height = height + 'px';
@endsection