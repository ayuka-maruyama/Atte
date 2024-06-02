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
    <h2 class="content_message">
        <?php $user = Auth::user(); ?>{{ $user->name }} さんお疲れ様です！
    </h2>
    <div class="stamp__area">
        <form class="stamp__form" action="" method="post">
            @csrf
            <div class="stamp__area-top">
                <button class="start__button" type="submit">勤務開始</button>
                <button class="end__button" type="submit">勤務終了</button>
            </div>
            <div class="stamp__area-bottom">
                <button class="break_start__button" type="submit">休憩開始</button>
                <button class="break_end__button" type="submit">休憩終了</button>
            </div>
        </form>
    </div>
</div>
@endsection