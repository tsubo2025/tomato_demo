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
                    <a href="{{ route('diary.index') }}" class="menu-item">
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
           
            ---
            {{-- --- 天気データ ドーナツグラフ --- --}}
            <section class="dashboard-section chart-section">
                <h2>日記の天気別件数</h2>
                <div class="chart-container" style="width: 400px; height: 400px; margin: 0 auto;">
                    <canvas id="weatherDoughnutChart"></canvas>
                </div>
            </section>

            ---
            {{-- --- トマトの個数 ドーナツグラフ --- --}}
            <section class="dashboard-section chart-section">
                <h2>トマト収穫数の分布</h2>
                <div class="chart-container" style="width: 400px; height: 400px; margin: 0 auto;">
                    <canvas id="harvestDoughnutChart"></canvas>
                </div>
            </section> 
        </main>
    </div>
      <script>
        // --- 天気データグラフ ---
        // コントローラから渡されるデータ
        const weatherLabels = @json($weatherLabels ?? []);
        const weatherValues = @json($weatherValues ?? []);

        if (weatherLabels.length > 0 && weatherValues.length > 0) {
            const weatherCtx = document.getElementById('weatherDoughnutChart').getContext('2d');
            new Chart(weatherCtx, {
                type: 'doughnut',
                data: {
                    labels: weatherLabels,
                    datasets: [{
                        data: weatherValues,
                        backgroundColor: [ // 天候の種類に応じて色を調整
                            'rgba(255, 206, 86, 0.8)',   // 晴れ
                            'rgba(169, 169, 169, 0.8)', // 曇り
                            'rgba(54, 162, 235, 0.8)',  // 雨
                            'rgba(220, 220, 220, 0.8)', // 雪
                            'rgba(153, 102, 255, 0.8)'  // その他
                        ],
                        borderColor: [
                            'rgba(255, 206, 86, 1)',
                            'rgba(169, 169, 169, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(220, 220, 220, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: '天気ごとの日記の件数'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += context.parsed + '件'; // ツールチップに「件」を追加
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        } else {
            document.getElementById('weatherDoughnutChart').parentElement.innerHTML = '<p style="text-align: center;">天気データがありません。</p>';
        }


        // --- トマトの個数グラフ ---
        // コントローラから渡されるデータ
        const harvestLabels = @json($harvestLabels ?? []);
        const harvestValues = @json($harvestValues ?? []);

        if (harvestLabels.length > 0 && harvestValues.length > 0) {
            const harvestCtx = document.getElementById('harvestDoughnutChart').getContext('2d');
            new Chart(harvestCtx, {
                type: 'doughnut',
                data: {
                    labels: harvestLabels,
                    datasets: [{
                        data: harvestValues,
                        backgroundColor: [
                            'rgba(255, 159, 64, 0.8)',  // 少なかった日 (オレンジ系)
                            'rgba(75, 192, 192, 0.8)', // 普通の日 (緑系)
                            'rgba(153, 102, 255, 0.8)'  // 多かった日 (紫系)
                        ],
                        borderColor: [
                            'rgba(255, 159, 64, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'トマト収穫個数の分布'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += context.parsed + '件'; // ツールチップに「件」を追加
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        } else {
             document.getElementById('harvestDoughnutChart').parentElement.innerHTML = '<p style="text-align: center;">トマト収穫データがありません。</p>';
        }
    </script>
</body>
</html> 