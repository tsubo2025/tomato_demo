<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>トマト観察日記</title>

    <!-- CSSファイル -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Hachi+Maru+Pop&display=swap" rel="stylesheet">
</head>

<body data-sound-path="{{ asset('sound/uguisu.mp3') }}" 
      data-bounce-sound-path="{{ asset('sound/bounce.mp3') }}"
      data-tomato-image-path="{{ asset('image/tomato/tomato_red.png') }}"
      data-canned-tomato-image-path="{{ asset('image/tomato/kandume_tomato.png') }}">
    <h1 class="title" id="animated-title">トマト観察日記</h1>

    <div id="animation-container">
    </div>

    <div id="main-content">
        <h2>ようこそ、トマト観察日記へ！</h2>
        <p>ここでは、日々のトマトたちを観察しています。たまに、缶詰になったトマトも落ちてきますね。彼らがどのように育ち、そしてどうなるのか、静かに見守りましょう。</p>
        <p>このページは、背景のトマトアニメーションを透かして表示しています。</p>

        <button id="next-page-button" class="action-button">トマトを見に行く</button>
    </div>
    <div>
        <button id="admin-page-button" class="admin-button">管理者の方はこちら</button>
    </div>

    <div id="big-tomato" class="big-tomato"></div>

    <div id="next-screen" class="next-screen">
        <h2>トマトの国へようこそ！</h2>
        <p>きっとたくさんのトマトが実っています。</p>
        <a href="{{ route('diary.public.index') }}">詳細を見る</a>
    </div>

    <!-- JavaScriptファイル -->
    <script src="{{ asset('js/welcome.js') }}"></script>
</body>

</html>