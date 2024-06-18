@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/date.css') }}">
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
<div class="attendance">
    <div class="date">
        <a href="{{ route('attendance', ['date' => $previousDate]) }}" class="date__title-before">&lt;</a>
        <h3 class="date__title">{{ $date }}</h3>
        <a href="{{ route('attendance', ['date' => $nextDate]) }}" class="date__title-after">&gt;</a>
    </div>
    <div class="work-time">
        <table class="work-time__table">
            <tr class="table__row">
                <th class="work-time__title">名前</th>
                <th class="work-time__title">勤務開始</th>
                <th class="work-time__title">勤務終了</th>
                <th class="work-time__title">休憩時間</th>
                <th class="work-time__title">勤務時間</th>
            </tr>
            @foreach($workRecords as $record)
            <tr class="table__row">
                <td class="work-time__item">{{ $record->user->name }}</td>
                <td class="work-time__item">{{ $record->start_time }}</td>
                <td class="work-time__item">{{ $record->end_time }}</td>
                <td class="work-time__item">{{ $breakTimesByWorkId[$record->id] ?? '00:00:00' }}</td>
                <td class="work-time__item">{{ $pureWorkTimes[$record->id] ?? '00:00:00' }}</td>
            </tr>
            @endforeach
        </table>
        {{ $workRecords->appends(['date' => $date])->links('vendor/pagination/custom') }}
    </div>
</div>
@endsection