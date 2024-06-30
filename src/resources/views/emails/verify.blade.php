<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>メールアドレスの確認</title>
</head>

<style>
    body {
        max-width: 80vw;
        margin: 0 auto;
        text-align: center;
    }

    .message {
        font-size: 20px;
        margin: 10px;
    }

    .link {
        border: 1px solid black;
        background: black;
        padding: 10px;
        font-size: 18px;
        color: #FFFFFF;
        text-decoration: none;
        margin: 30px;
    }

    .small-message {
        font-size: 15px;
        color: #7c7a7a;
    }
</style>

<body>
    <p class="message">以下のボタンをクリックしてメールアドレスを確認してください。</p>
    <a class="link" href="{{ $url }}">メールアドレスを確認する</a>
    <p class="message">もしこのメールに心当たりがない場合は、このメールを無視してください。</p>
    <p class="small-message">ボタンをクリックできない場合は、以下のURLをコピーしてブラウザに貼り付けてください。</p>
    <p class="small-message">{{ $url }}</p>
</body>

</html>