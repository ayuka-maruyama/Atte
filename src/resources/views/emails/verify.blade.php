<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>メールアドレスの確認</title>
</head>

<style>
    body {
        border: 6px double red;
        max-width: 70vw;
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
        margin: 0 auto;
        width: 30vw;
    }

    .small-message_p {
        font-size: 15px;
        color: #7c7a7a;
    }
</style>

<body>
    <div class="txt-message">
        <p class="message">以下のボタンをクリックしてメールアドレスを確認してください。</p>
        <div class="link">
            <a class="link" href="{{ $url }}">メールアドレスを確認する</a>
        </div>
        <p class="message">もしこのメールに心当たりがない場合は、このメールを無視してください。</p>
    </div>
    <div class="small-massage">
        <p class="small-message_p">ボタンをクリックできない場合は、以下のURLをコピーしてブラウザに貼り付けてください。</p>
        <p class="small-message_p">{{ $url }}</p>
    </div>
</body>

</html>