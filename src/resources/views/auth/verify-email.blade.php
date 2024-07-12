@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('登録ありがとうございます！') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('新しい確認リンクがメールアドレスに送信されました。') }}
                    </div>
                    @endif

                    {{ __('ご入力いただいたメールアドレスへ認証リンクを送信しました。') }}<br>
                    {{ __('クリックをして認証を完了させてください。') }}<br>
                    {{ __('もし、認証メールが届かない場合は以下のリンクで認証メールの再送をしてください。') }}
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline"><span class=span>{{ __('こちらをクリックしてもう一度リクエストしてください。')}}</span></button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection