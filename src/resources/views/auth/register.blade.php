@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
    <div class="register">
        <h2 class="register__ttl">会員登録</h2>
        <div class="register__form">
            <form class="form-area" action="/register" method="post">
            @csrf
                <input class="form-area__input" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="名前">
                <div class="error">
                    @error('name')
                    {{ message('name') }}
                    @enderror
                </div>
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
                <input class="form-area__input" type="password" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="確認用パスワード">
                <div class="error">
                    @error('password_confirmation')
                    {{ message('password_confirmation') }}
                    @enderror
                </div>
                <div class="form-area__button">
                    <button class="form-area__button-submit" type="submit">会員登録</button>
                </div>
            </form>
            <div class="register__txt">
                <p class="register__txt-p">アカウントをお持ちの方はこちらから</p>
                <a class="register__txt-link" href="/login">ログイン</a>
            </div>
        </div>
    </div>
@endsection