@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')

<div class="mb-4 text-sm text-gray-600">
    ご登録ありがとうございます！<br>
    ご入力いただいたメールアドレスへ認証リンクを送信しましたので、クリックして認証を完了させてください。<br>
    もし、認証メールが届かない場合は再送させていただきます。
</div>

@if (session('status') == 'verification-link-sent')
<div class="mb-4 font-medium text-sm text-green-600">
    新しい認証メールが送信されました。
</div>
@endif

<div class="mt-4 flex items-center justify-between">
    <form method="POST" action="/logout">
        @csrf

        <button type="submit" class="underline mt-4 text-gray-600 hover:text-gray-900">
            ログアウト
        </button>
    </form>
</div>
@endsection