<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ダッシュボード - トマト日記</title>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;700&family=Mochiy+Pop+P+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <a href="{{ route('diary.index') }}" class="menu-item">
                        <h3>日記管理</h3>
                        <p>日記の確認・編集・削除</p>
                    </a>
                    <a href="#statistics" class="menu-item" id="statistics-link">
                        <h3>統計情報</h3>
                        <p>利用状況の統計</p>
                    </a>
                    <a href="#" class="menu-item">
                        <h3>設定</h3>
                        <p>システム設定</p>
                    </a>
                </div>
            </section>
           
             
            {{-- --- 天気データ ドーナツグラフ --- --}}
            <section class="dashboard-section chart-section">
                <h2>日記の天気別件数</h2>
                <div class="chart-container">
                    <canvas id="weatherDoughnutChart"></canvas>
                </div>
            </section>

            
            {{-- --- トマトの個数 ドーナツグラフ --- --}}
            <section id="statistics" class="dashboard-section chart-section">
                <h2>トマト収穫数の分布</h2>
                {{-- position: relative を設定して、子要素の絶対配置に対応させる --}}
                <div class="chart-container">
                    <canvas id="harvestDoughnutChart"></canvas>
                    {{-- トマト総収穫個数の表示要素 --}}
                    <div class="center-text">
                        <span class="total-count">{{ $totalTomatoCount ?? 0 }}</span><br>
                        <span class="total-label">合計個数</span>
                    </div>
                </div>
            </section>

        </main>
    </div>

    {{-- グラフデータをJavaScript変数に代入し、外部JSファイルへ渡す準備 --}}
    <script>
        // コントローラから渡されたデータをグローバル変数として定義
        // これにより、chart_logic.jsからこれらの変数にアクセスできます
        window.weatherLabels = @json($weatherLabels ?? []);
        window.weatherValues = @json($weatherValues ?? []);
        window.harvestLabels = @json($harvestLabels ?? []);
        window.harvestValues = @json($harvestValues ?? []);
        // totalTomatoCountはHTMLで直接表示するため、JSに渡す必要がないが、
        // プラグインで表示するならこれも渡す
        // window.totalTomatoCount = @json($totalTomatoCount ?? 0);
    </script>

    {{-- あなたのChart.jsカスタムスクリプトを読み込む --}}
    {{-- Chart.js本体の後に読み込むことが重要です --}}
    <script src="{{ asset('js/chart_logic.js') }}"></script>

    <script>
    document.getElementById('statistics-link').addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.getElementById('statistics');
        const y = target.getBoundingClientRect().top + window.pageYOffset - 80; // 80px上にオフセット
        window.scrollTo({ top: y, behavior: 'smooth' });
    });
    </script>

    <style>
        @media (max-width: 600px) {
            .center-text .total-count {
                font-size: 2em;
            }
            .center-text .total-label {
                font-size: 1em;
            }
        }
        .chart-container {
            width: 100%;
            max-width: 400px;
            aspect-ratio: 1 / 1;
            margin: 0 auto;
            position: relative;
        }
        .chart-container canvas {
            width: 100% !important;
            height: 100% !important;
            display: block;
            margin: 0 auto;
        }
        #statistics {
            scroll-margin-top: 80px; /* ヘッダーの高さや余白分だけ調整 */
        }
    </style>
</body>
</html> 