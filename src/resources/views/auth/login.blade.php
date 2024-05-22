@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="login">
        <h2 class="login__ttl">会員登録</h2>
        <div class="login__form">
            <form class="form-area" action="/login" method="post">
            @csrf
                <input class="form-area__input" type="mail" name="email" id="email" value="{{ old('email') }}" placeholder="メールアドレス">
                <div class="error">
                    @error('email')
                    {{ message('email') }}
                    @enderror
                </div>
                <input class="form-area__input" type="password" name="password" id="password" value="{{ old('password') }}" placeholder="パスワード">
                <div class="error">
                    @error('password')
                    {{ message('password') }}
                    @enderror
                </div>
                <div class="form-area__button">
                    <button class="form-area__button-submit" type="submit">ログイン</button>
                </div>
            </form>
            <div class="login__txt">
                <p class="login__txt-p">アカウントをお持ちの方はこちらから</p>
                <a class="login__txt-link" href="/">ログイン</a>
            </div>
        </div>
    </div>
@endsection