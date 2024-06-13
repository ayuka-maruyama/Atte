@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/stamp.css') }}">
@endsection

@section('header')
<nav class="header__nav">
    <ul class="header__nav-ul">
        <li class="header__nav-item">
            <a href="/" class="header__link">ホーム</a>
        </li>
        <li class="header__nav-item">
            <a href="/attendance" class="header__link">日付一覧</a>
        </li>
        <li class="header__nav-item">
            <form class="header__logout" action="/logout" method="post">
                @csrf
                <button class="header__nav-button" type="submit">ログアウト</button>
            </form>
        </li>
    </ul>
</nav>
@endsection

@section('content')
<div class="content__area">
    <div class="content__area-message">
        <h2 class="content_message">
            <?php $user = Auth::user(); ?>{{ $user->name }} さんお疲れ様です！
        </h2>

        <!-- フラッシュメッセージ。 -->
        @if(session('flash_message'))
        <div class="flash_message">
            {{ session('flash_message') }}
        </div>
        @endif
    </div>
    <div class="stamp__area">
        <div class="stamp__area-top">
            <form class="stamp__form" action="{{ route('starttime') }}" method="post">
                @csrf
                <button type="submit" class="start__button button @if ($workStart) disabled @endif" @if ($workStart) disabled @endif>
                    勤務開始
                </button>
            </form>
            <form class="stamp__form" action="{{ route('endtime') }}" method="post">
                @csrf
                <button type="submit" class="end__button button @if (!$workStart || $workEnd || ($breakStart && !$breakEnd)) disabled @endif" @if (!$workStart || $workEnd || ($breakStart && !$breakEnd)) disabled @endif>
                    勤務終了
                </button>
            </form>
        </div>
        <div class="stamp__area-bottom">
            <form class="stamp__form" action="{{ route('breakStart') }}" method="POST">
                @csrf
                <button type="submit" class="break_start__button button @if (!$workStart || $workEnd || ($breakStart && !$breakEnd)) disabled @endif" @if (!$workStart || $workEnd || ($breakStart && !$breakEnd)) disabled @endif>
                    休憩開始
                </button>
            </form>

            <form class="stamp__form" action="{{ route('breakEnd') }}" method="POST">
                @csrf
                <button type="submit" class="break-end__button button @if (!$workStart || !$breakStart || $workEnd || ($breakStart && $breakEnd)) || ($breakStart && !$breakEnd)) disabled @endif" @if (!$workStart || !$breakStart || $workEnd || ($breakStart && $breakEnd)) || ($breakStart && !$breakEnd)) disabled @endif>
                    休憩終了
                </button>
            </form>
        </div>
    </div>
</div>
</div>
@endsection