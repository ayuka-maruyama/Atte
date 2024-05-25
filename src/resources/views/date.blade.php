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
    <div class="date">
        <h3 class="date__title">2024-05-25</h3>
        <!-- テーブル作成後日付を取得して表示させる -->
        <div class="work-time">
            <table class="work-time__table">
                <tr class="table__row">
                    <th class="work-time__title">名前</th>
                    <th class="work-time__title">勤務開始</th>
                    <th class="work-time__title">勤務終了</th>
                    <th class="work-time__title">休憩時間</th>
                    <th class="work-time__title">勤務時間</th>
                </tr>
                <tr class="table__row">
                    <!-- テーブル作成後、それぞれの項目を表示させる -->
                    <td class="work-time__item">テスト太郎</td>
                    <td class="work-time__item">10:00:00</td>
                    <td class="work-time__item">20:00:00</td>
                    <td class="work-time__item">00:30:00</td>
                    <td class="work-time__item">09:30:00</td>
                </tr>
                <tr class="table__row">
                    <!-- テーブル作成後、それぞれの項目を表示させる -->
                    <td class="work-time__item">テスト太郎</td>
                    <td class="work-time__item">10:00:00</td>
                    <td class="work-time__item">20:00:00</td>
                    <td class="work-time__item">00:30:00</td>
                    <td class="work-time__item">09:30:00</td>
                </tr>
                <tr class="table__row">
                    <!-- テーブル作成後、それぞれの項目を表示させる -->
                    <td class="work-time__item">テスト太郎</td>
                    <td class="work-time__item">10:00:00</td>
                    <td class="work-time__item">20:00:00</td>
                    <td class="work-time__item">00:30:00</td>
                    <td class="work-time__item">09:30:00</td>
                </tr>
                <tr class="table__row">
                    <!-- テーブル作成後、それぞれの項目を表示させる -->
                    <td class="work-time__item">テスト太郎</td>
                    <td class="work-time__item">10:00:00</td>
                    <td class="work-time__item">20:00:00</td>
                    <td class="work-time__item">00:30:00</td>
                    <td class="work-time__item">09:30:00</td>
                </tr>
                <tr class="table__row">
                    <!-- テーブル作成後、それぞれの項目を表示させる -->
                    <td class="work-time__item">テスト太郎</td>
                    <td class="work-time__item">10:00:00</td>
                    <td class="work-time__item">20:00:00</td>
                    <td class="work-time__item">00:30:00</td>
                    <td class="work-time__item">09:30:00</td>
                </tr>
            </table>
            <!-- ページネーションの部分を記述する -->
        </div>
    </div>
@endsection