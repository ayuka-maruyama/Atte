@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="login">
        <h2 class="login__ttl">ログイン</h2>
        <div class="login__form">
            <form class="form-area" action="/login" method="post">
            @csrf
                <div class="form-area__email">
                    <input class="form-area__input" type="email" name="email" id="email" value="{{ old('email') }}" placeholder="メールアドレス">
                    <div class="error">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-area__password">                
                    <input class="form-area__input" type="password" name="password" id="password" value="{{ old('password') }}" placeholder="パスワード">
                    <div class="error">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <button class="form-area__button" type="submit">
                    <div class="form-area__button-submit">ログイン</div>
                </button>
            </form>
            <div class="login__txt">
                <p class="login__txt-p">アカウントをお持ちでない方はこちらから</p>
                <a class="login__txt-link" href="/register">会員登録</a>
            </div>
        </div>
    </div>
@endsection