@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/worktime.css') }}">
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
<div class="user-details">
    <div class="user-details__header">
        <h3 class="user-details__title">{{ $user->name }}　さんの勤怠情報</h3>
    </div>
    <div class="user-details__main">
        <table class="user-details__table">
            <tr class="table__row">
                <th class="work-time__title">日付</th>
                <th class="work-time__title">開始時間</th>
                <th class="work-time__title">終了時間</th>
                <th class="work-time__title">休憩時間</th>
                <th class="work-time__title">実働時間</th>
            </tr>
            @if(isset($worktimes) && $worktimes->isNotEmpty())
            @foreach($worktimes as $worktime)
            <tr class="table__row">
                <td class="work-time__item">{{ $worktime->date }}</td>
                <td class="work-time__item">{{ $worktime->start_time }}</td>
                <td class="work-time__item">{{ $worktime->end_time }}</td>
                <td class="work-time__item">{{ $breakTimesByWorkId[$worktime->id] ?? '休憩なし' }}</td>
                <td class="work-time__item">{{ $pureWorkTimes[$worktime->id] ?? '計算中' }}</td>
            </tr>
            @endforeach
            @else
            <tr class="table__row">
                <td colspan="5" class="work-time__item">勤怠情報がありません</td>
            </tr>
            @endif
        </table>
        @if(isset($worktimes))
        {{ $worktimes->appends(['user_id' => $userId])->links() }}
        @endif
    </div>
</div>
@endsection