<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/destyle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    <title>Document</title>
</head>
<body>

<header class="header">
    <div class="header__content">
        <h2 class="header_ttl">Atte</h2>
        @yield('header')
    </div>
</header>

<main class="main__content">
    @yield('content')
</main>

<footer class="footer">
    <div class="footer__txt">
        <small class="footer__tag">Atte,inc.</small>
    </div>
</footer>

</body>
</html>