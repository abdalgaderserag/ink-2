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


            <div id="background-holder" style="border-bottom: 12px solid #f98835;background-color: #f98835;">
                <img id="background" src="{{ $user->background }}"
                     style="width: 100%;object-fit: cover;margin: 0 0 -4px 0;" alt="">
            </div>
            <div class="flex-box" style="justify-content: flex-start;">
                <div id="avatar-holder"
                     style="background-color: #f98835;width: 90px;height: 90px;border-radius: 50%;border: 10px solid;border-color: #f4f4f4;margin: -61px 0 0 3%;">
                </div>
                <img id="profile-avatar" class="profile-avatar"
                     style="display:none;width: 90px;height: 90px;border-radius: 50%;border: 10px solid;border-color: #f4f4f4;margin: -61px 0 0 3%;"
                     src="{{ $user->avatar }}" alt="">
                <div style="width: 75%;margin-top: 8px">
                    <div class="flex-box" style="justify-content: space-between">
                        {{--text section --}}
                        <div style="width: 50%">
                            <span style="color: #f98835;font-weight: 100;font-size: 2.7vh">{{ $user->name }}</span>
                            <a href="/edit/profile" class="link-clear">
                                <span style="font-size: 2vh;color: gray;padding: 0 0 0 12px;cursor: pointer;">Edit</span>
                            </a>
                            <br>
                            <span style="color: #878787;font-weight: 100;font-size: 2vh">{{ '@' . $user->slug }}</span>
                        </div>

                        {{--following accs--}}
                        <div class="flex-box" style="justify-content: space-around;width: 100%;">
                            <div style="text-align: center;color: #878787;">
                                <span style="color: black;">following</span><br>
                                <span>{{ $following }}</span>
                            </div>

                            <div style="text-align: center;color: #878787;">
                                <span style="color: black;">followers</span><br>
                                <span id="followers">{{ $followers }}</span>
                            </div>

                        </div>
                    </div>

                    {{--details--}}
                    <div style="width: 100%;margin-top: 20px">
                        <div>{{ $user->details }}</div>
                        @if($user->id != \Illuminate\Support\Facades\Auth::id())
                            <div>
                                @if( $follow == 0)
                                    <button id="follow-button"
                                            style="font-size: 2.4vh;padding: 5px 6%;color:white;background: linear-gradient(to right, #FC4027, #f98835);border-width: 0;border-radius:14px;margin: 8px 0 0 0;">
                                        follow
                                    </button>
                                @else
                                    <button id="follow-button"
                                            style="font-size: 2.4vh;padding: 5px 6%;color:#362017;background: #e0e0e0;border-width: 0;border-radius:14px;margin: 8px 0 0 0; ">
                                        followed
                                    </button>
                                @endif
                            </div>
                        @endif
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
    {{--<script>--}}
    document.getElementById('profile-avatar').onload = () => {
    document.getElementById('profile-avatar').style.display = 'block';
    document.getElementById('avatar-holder').remove();
    };
    let bgWidth = document.getElementById('background').offsetWidth;
    document.getElementById('background').style.height = (bgWidth * (1.5 / 4)) + 'px';
    document.getElementById('background-holder').style.height = (bgWidth * (1.5 / 4)) + 'px';

    function deIncFollowers(val = '+') {
    let number = Number.parseInt(document.getElementById('followers').innerText);
    if (val == '+')
    number++;
    else
    number--;
    document.getElementById('followers').innerText = number;
    }

    @if($user->id != \Illuminate\Support\Facades\Auth::id())
        document.getElementById('follow-button').onclick = (e) => {
        if (e.target.innerText == 'follow') {
        let bgColor = e.target.style.background;
        e.target.style.background = '#e0e0e0';
        e.target.style.color = '#362017';
        e.target.innerText = 'followed';
        deIncFollowers();

        axios.post('/api/follow', {
        user_id: {{ $user->id }},
        }).catch(error => {
        deIncFollowers('-');
        e.target.style.background = bgColor;
        e.target.style.color = '#000';
        });
        } else if (e.target.innerText == 'followed') {
        let bgColor = e.target.style.background;
        e.target.style.background = 'linear-gradient(to right, #FC4027, #f98835)';
        e.target.style.color = '#fff';
        deIncFollowers('-');
        e.target.innerText = 'follow';

        axios.delete('/api/follow/{{ $user->id }}')
        .catch(error => {
        deIncFollowers();
        e.target.style.background = '#e0e0e0';
        e.target.style.color = '#362017';
        e.target.innerText = 'followed';
        });
        }
        };
    @endif

@endsection