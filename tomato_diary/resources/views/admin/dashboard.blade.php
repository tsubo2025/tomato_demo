<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ダッシュボード - トマト日記</title>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;700&family=Mochiy+Pop+P+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>管理者ダッシュボード</h1>
            <form action="{{ route('admin.logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-button">ログアウト</button>
            </form>
        </header>

        <main class="dashboard-content">
            <section class="dashboard-section">
                <h2>管理メニュー</h2>
                <div class="menu-grid">
                    <a href="#" class="menu-item">
                        <h3>ユーザー管理</h3>
                        <p>ユーザー情報の確認・編集</p>
                    </a>
                    <a href="#" class="menu-item">
                        <h3>日記管理</h3>
                        <p>日記の確認・編集・削除</p>
                    </a>
                    <a href="#" class="menu-item">
                        <h3>統計情報</h3>
                        <p>利用状況の統計</p>
                    </a>
                    <a href="#" class="menu-item">
                        <h3>設定</h3>
                        <p>システム設定</p>
                    </a>
                </div>
            </section>
        </main>
    </div>
</body>
</html> 