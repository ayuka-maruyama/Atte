@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('メールアドレスの確認') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('新しい確認リンクがメールアドレスに送信されました。') }}
                    </div>
                    @endif

                    {{ __('続行する前に、メールで確認リンクを確認してください。') }}<br>
                    {{ __('もしメールを受け取っていない場合') }}、
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