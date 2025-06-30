<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ダッシュボード - トマト日記</title>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;700&family=Mochiy+Pop+P+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
   <script>
        // Controllerから渡される$weatherCounts, $harvestLabels, $harvestValuesが存在することを確認
        // null合体演算子 `?? []` を使って、もしデータがない場合でも空の配列になるようにします。
        // これにより、JavaScript側でreduceなどの配列メソッドを安全に呼び出せます。
        window.weatherLabels = @json($weatherLabels ?? []); // $weatherCounts ではなく $weatherLabels を使う
        window.weatherValues = @json($weatherValues ?? []); // $weatherCounts ではなく $weatherValues を使う

        // harvestLabelsとharvestValuesはControllerで既に配列として整形されているため、そのまま使用
        window.harvestLabels = @json($harvestLabels ?? []);
        window.harvestValues = @json($harvestValues ?? []);

        // FullCalendarのイベントクリックで使うベースURL
        window.diaryIndexBaseUrl = "{{ route('diary.index') }}";

        // ★★★ デバッグ用: これらのconsole.logは、問題解決後に削除してもOKです ★★★
        console.log('Blade - weatherLabels:', window.weatherLabels);
        console.log('Blade - weatherValues:', window.weatherValues);
        console.log('Blade - harvestLabels:', window.harvestLabels);
        console.log('Blade - harvestValues:', window.harvestValues);
    </script>
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
                    <a href="{{ route('diary.create') }}" class="menu-item">
                        
                        <h3>日記を書く</h3>
                        <p>日記の入力・天候・写真</p>
                    </a>
                    <a href="{{ route('diary.index') }}" class="menu-item">
                        <h3>日記管理</h3>
                        <p>日記の確認・編集・削除</p>
                    </a>
                    <a href="#statistics" class="menu-item" id="statistics-link">
                        <h3>統計情報</h3>
                        <p>利用状況の統計グラフ/カレンダー</p>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="menu-item">
                        <h3>各種設定</h3>
                        <p>PDF仕様書変更/壁紙変更/配色テーマ変更</p>
                    </a>
                </div>
            </section>
           
             
            {{-- --- 天気データ ドーナツグラフ --- --}}
            <section class="dashboard-section chart-section">
                <h2>日記の天気別件数</h2>
                <div class="chart-container">
                    <canvas id="weatherDoughnutChart"></canvas>
                    {{-- 天気別日記件数の表示要素 --}}
                    <div class="center-text">
                        <span class="total-count">{{ $totalWeatherCount ?? 0 }}</span>
                        <span class="total-label">合計件数</span>
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
                        <span class="total-count">{{ $totalTomatoCount ?? 0 }}</span>
                        <span class="total-label">合計個数</span>
                    </div>
                </div>
            </section>
            {{-- --- 日記カレンダー --- --}}
            <section class="dashboard-section">
                <h2>日記カレンダー</h2>
                <div id='calendar' data-events="{{ json_encode($events) }}"></div>
            </section>

        </main>
    </div>



    {{-- あなたのChart.jsカスタムスクリプトを読み込む --}}
    {{-- Chart.js本体の後に読み込むことが重要です --}}
    <script src="{{ asset('js/chart_logic.js') }}"></script>



    <script>
    document.getElementById('statistics-link').addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.getElementById('statistics');
        const y = target.getBoundingClientRect().top + window.pageYOffset - 80;
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
                /* カレンダー用の基本的なスタイル (必要に応じて調整) */
        #calendar {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            font-family: 'M PLUS Rounded 1c', sans-serif;
            background-color: #fffaf5; /* 柔らかいクリーム色 */
            border-radius: 15px; /* 角を丸くする */
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* 影を付ける */
        }

        /* --- カレンダーヘッダー --- */
        .fc-header-toolbar {
            margin-bottom: 1.5em !important; /* !importantで優先度を上げる */
        }

        .fc-header-toolbar .fc-toolbar-title {
            font-family: 'Mochiy Pop P One', sans-serif; /* タイトルにポップなフォントを適用 */
            color: #ff6347; /* トマト色 */
        }

        /* --- ボタン --- */
        .fc-button {
            background-color: #ff7f50 !important; /* コーラル色 */
            border: none !important;
            color: white !important;
            text-transform: capitalize !important;
            border-radius: 8px !important; /* ボタンの角を丸く */
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .fc-button:hover {
            background-color: #ff6347 !important; /* ホバー時に少し濃い色に */
        }

        /* --- 今日の日付 --- */
        .fc-day-today {
            background-color: #fff0e6 !important; /* 薄いオレンジ */
            color: #d9534f;
            font-weight: bold;
        }

        /* --- イベントのドット --- */
        .fc-daygrid-event-dot {
            border-color: #ff6347 !important;
            border-width: 5px !important; /* ドットを大きくする */
        }

        /* --- 日付の数字 --- */
        .fc-daygrid-day-number {
            color: #5a3e36; /* 落ち着いた茶色 */
            font-weight: 600;
        }

        /* --- 曜日ヘッダー --- */
        .fc-col-header-cell-cushion {
            color: #ff7f50; /* コーラル色 */
            font-weight: 700;
        }
    </style>
</body>
</html> 