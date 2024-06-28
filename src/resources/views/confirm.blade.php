@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="confirm">
    <div class="main">
        <h2 class="main-title">メールをご確認ください</h2>
    </div>
    <div class="message">
        <p class="message">
            会員登録を受け付けました。</br>
            現在は仮登録の状態です。</br>
            ご入力いただいたメールアドレス宛に、確認のメールをお送りしています。</br>
            メールに記載のURLをクリックし会員登録を完了させてください。</br>
            もし、メールが届いていない場合は、迷惑メールフォルダをご確認ください。</br>
        </p>
    </div>
</div>
@endsection