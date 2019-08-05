@extends('layouts.app')

@section('content')
    <div class="left-section">
        <div>
        </div>
    </div>
    <div class="main-section">
        <input type="file" id="upload" style="display: none">
        <div class="main">
            <div>
                <img onclick="event.preventDefault();document.getElementById('upload').click()" class="images"
                     src="{{ \Illuminate\Support\Facades\Auth::user()->background }}" width="100%"
                     height="240px"
                     style="cursor:pointer;margin-bottom: 40px;object-fit: cover"
                     alt="">

                <div class="flex-box" style="justify-content: flex-start">
                    <div>
                        <div style="width: 150px">
                            <img onclick="document.getElementById('upload').click();" class="images"
                                 src="{{ \Illuminate\Support\Facades\Auth::user()->avatar }}"
                                 style="cursor:pointer;border-radius: 20px;margin-bottom: 8px" width="150px" height="150px" alt="">
                            <span style="color: #f98835">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                            <span style="color: #636b6f;font-size: 15px;">{{ '@' . \Illuminate\Support\Facades\Auth::user()->slug }}</span>
                            <span>{{ \Illuminate\Support\Facades\Auth::user()->details }}</span>
                        </div>
                    </div>

                    <div style="width: 76%;margin-left: 3%">
                        <form method="post" action="{{ route('edit.profile') }}">
                            @csrf
                            <div class="flex-box" style="flex-direction: column;">
                                <input type="text" class="text-input" name="name" style="margin-top: 12px"
                                       placeholder="name"
                                       value="{{ \Illuminate\Support\Facades\Auth::user()->name }}">
                                {{--<input type="text" class="text-input" style="margin-top: 12px" name="slug"--}}
                                       {{--value="{{ \Illuminate\Support\Facades\Auth::user()->slug }}"--}}
                                       {{--placeholder="user.name">--}}
                                <textarea name="details" style="margin-top: 12px" class="text-input" cols="30" rows="10"
                                          placeholder="details about the user">{{ \Illuminate\Support\Facades\Auth::user()->details }}</textarea>
                                <button type="submit" class="input-bottom"
                                        style="width: 16%;margin-left: 42%;margin-top: 12px">Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="right-section">
        <div></div>
    </div>
@endsection