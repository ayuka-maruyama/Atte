@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/usersdate.css') }}">
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
            <a href="/users" class="header__link">ユーザー一覧</a>
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
<div class="users">
    <div class="all-date__header">
        <h3 class="all-date__title">ユーザー一覧</h3>
    </div>
    <div class="all-date__main">
        <table class="all-date__table">
            <tr class="table__row">
                <th class="work-time__title">名前</th>
                <th class="work-time__title">勤怠一覧</th>
            </tr>
            @foreach($users as $user)
            <tr class="table__row">
                <td class="work-time__item">{{ $user->name }}</td>
                <td class="work-time__item">
                    <form action="{{ route('userWorkTime') }}" method="get">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button class="work-time__button" type="submit">勤怠一覧</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        {{ $users->links('vendor/pagination/custom') }}
    </div>
</div>
@endsection