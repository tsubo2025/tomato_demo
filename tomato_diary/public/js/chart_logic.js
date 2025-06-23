// Chart.jsのスクリプトブロック内、または外部JSファイルに記述

// カスタムプラグインの定義
const centerTextPlugin = {
    id: 'centerText',
    beforeDraw(chart) {
        // このプラグインを適用するグラフを特定 (ここではharvestDoughnutChart)
        if (chart.canvas.id !== 'harvestDoughnutChart') {
            return; // 目的のグラフでなければ処理をスキップ
        }

        const { width, height, ctx } = chart;
        ctx.restore(); // 以前の描画状態を復元

        // 合計値とラベルを定義 (Bladeから渡された$totalTomatoCountを使う)
        const totalCount = @json($totalTomatoCount ?? 0); // Laravelから渡された合計値
        const totalLabel = '合計個数';

        ctx.font = '700 ' + (height / 8) + 'px "M PLUS Rounded 1c"'; // フォントサイズを動的に
        ctx.textBaseline = 'middle';
        ctx.fillStyle = '#e74c3c'; // 合計数の色

        const totalText = totalCount.toString();
        const textX = width / 2;
        const textY = height / 2 - (height / 25); // 少し上にずらす

        ctx.textAlign = 'center';
        ctx.fillText(totalText, textX, textY);

        ctx.font = '400 ' + (height / 25) + 'px "M PLUS Rounded 1c"'; // ラベルのフォントサイズ
        ctx.fillStyle = '#666'; // ラベルの色
        ctx.fillText(totalLabel, textX, height / 2 + (height / 25)); // 少し下にずらす

        ctx.save(); // 現在の描画状態を保存
    }
};

// --- トマトの個数グラフのChart.jsインスタンスを作成 ---
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
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)'
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
                                label += context.parsed + '件';
                            }
                            return label;
                        }
                    }
                }
            }
        },
        // プラグインを登録
        plugins: [centerTextPlugin] // ここにカスタムプラグインを追加
    });
} else {
    document.getElementById('harvestDoughnutChart').parentElement.innerHTML = '<p style="text-align: center;">トマト収穫データがありません。</p>';
}