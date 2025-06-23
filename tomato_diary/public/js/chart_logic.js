// public/js/chart_logic.js

// Windowオブジェクトからデータにアクセス
const weatherLabels = window.weatherLabels;
const weatherValues = window.weatherValues;
const harvestLabels = window.harvestLabels;
const harvestValues = window.harvestValues;
// totalTomatoCountはHTMLで直接表示するため、ここでの取得は不要ですが、
// JSプラグインで表示する場合は必要です。

const totalWeatherCount = weatherValues.reduce((a, b) => a + b, 0);

// --- 天気データグラフ ---
if (weatherLabels && weatherLabels.length > 0 && weatherValues && weatherValues.length > 0) {
    const weatherCtx = document.getElementById('weatherDoughnutChart').getContext('2d');
    new Chart(weatherCtx, {
        type: 'doughnut',
        data: {
            labels: weatherLabels,
            datasets: [{
                data: weatherValues,
                backgroundColor: [
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
                    text: '天気ごとの日記の件数',
                    font: {
                    size: 24
    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed !== null) {
                                label += context.parsed + '件';
                            }
                            return label;
                        }
                    }
                }
            }
        },
    });
} else {
    // データがない場合のメッセージ表示
    const weatherChartContainer = document.getElementById('weatherDoughnutChart').parentElement;
    if (weatherChartContainer) {
        weatherChartContainer.innerHTML = '<p style="text-align: center;">天気データがありません。</p>';
    }
}


// --- トマトの個数グラフ ---
if (harvestLabels && harvestLabels.length > 0 && harvestValues && harvestValues.length > 0) {
    const harvestCtx = document.getElementById('harvestDoughnutChart').getContext('2d');
    new Chart(harvestCtx, {
        type: 'doughnut',
        data: {
            labels: harvestLabels,
            datasets: [{
                data: harvestValues,
                backgroundColor: [
                    'rgba(255, 159, 64, 0.8)',  // 少なかった日
                    'rgba(75, 192, 192, 0.8)', // 普通の日
                    'rgba(153, 102, 255, 0.8)'  // 多かった日
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
                    text: 'トマト収穫個数の分布',
                    font: {
                        size: 24
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed !== null) {
                                label += context.parsed + '件';
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
} else {
    // データがない場合のメッセージ表示
    const harvestChartContainer = document.getElementById('harvestDoughnutChart').parentElement;
    if (harvestChartContainer) {
        harvestChartContainer.innerHTML = '<p style="text-align: center;">トマト収穫データがありません。</p>';
    }
}