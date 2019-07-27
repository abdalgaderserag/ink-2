@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pop.css') }}">
@endsection

@section('content')
    <div class="left-section">
        <div>
        </div>
    </div>
    <div class="flex-box main-section">
        <div class="main">
            <ink-main></ink-main>
        </div>
        <div class="right-section">
            <div>
            </div>
        </div>
    </div>
@endsection
