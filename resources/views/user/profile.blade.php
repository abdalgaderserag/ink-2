@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pop.css') }}">
@endsection

@section('head-script')
    <script>

    </script>
@endsection

@section('content')
    <div class="left-section">
        <div>
        </div>
    </div>
    <div class="flex-box main-section">
        <div class="main">


            <div style="border-bottom: 12px solid #f98835;background-color: #f98835;height: 240px;">
                <img src="{{ $user->background }}"
                     style="width: 100%;height: 240px;object-fit: cover;margin: 0 0 -4px 0;" alt="">
            </div>
            <div class="flex-box" style="justify-content: flex-start;">
                <div id="avatar-holder"
                     style="background-color: #f98835;width: 120px;height: 120px;border-radius: 50%;border: 10px solid;border-color: #f4f4f4;margin: -61px 0 0 3%;">
                </div>
                <img id="profile-avatar" class="profile-avatar"
                     style="display:none;width: 120px;height: 120px;border-radius: 50%;border: 10px solid;border-color: #f4f4f4;margin: -61px 0 0 3%;"
                     src="{{ $user->avatar }}" alt="">
                <div style="width: 75%;margin-top: 8px">
                    <div class="flex-box" style="justify-content: space-between">
                        {{--text section --}}
                        <div style="width: 50%">
                            <span style="color: #f98835;font-weight: 100;font-size: 2.7vh">{{ $user->name }}</span><br>
                            <span style="color: #878787;font-weight: 100;font-size: 2vh">{{ '@' . $user->slug }}</span>
                        </div>

                        {{--following accs--}}
                        <div class="flex-box" style="justify-content: space-around;width: 100%;">
                            <div style="text-align: center;color: #878787;">
                                <span style="color: black;">following</span><br>
                                <span>2</span>
                            </div>

                            <div style="text-align: center;color: #878787;">
                                <span style="color: black;">followers</span><br>
                                <span>20</span>
                            </div>

                        </div>
                    </div>

                    {{--details--}}
                    <div style="width: 100%;margin-top: 20px">
                        <div>{{ $user->details }}</div>
                        <div>
                            <button style="font-size: 2.4vh;padding: 2px 6%;background-color: white;border: 1px solid gray;margin: 8px 0 0 0;">
                                follow
                            </button>
                        </div>
                    </div>

                </div>
            </div>


            <ink-main></ink-main>
        </div>
        <div class="right-section">
            <div>
            </div>
        </div>
    </div>
@endsection

@section('foot-script')
    document.getElementById('profile-avatar').onload = () => {
    document.getElementById('profile-avatar').style.display = 'block';
    document.getElementById('avatar-holder').remove();
    }
@endsection