<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン - トマト日記</title>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;700&family=Mochiy+Pop+P+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">
</head>
<body>
    <div class="login-container">
        <h1>管理者ログイン</h1>
        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif
        <form method="POST" action="{{ route('admin.login') }}" class="login-form">
            @csrf
            <div class="form-group">
                <label for="username">ユーザーID</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-button">ログイン</button>
        </form>
        <a href="{{ route('welcome') }}" class="back-button">トップページに戻る</a>
    </div>
</body>
</html> 