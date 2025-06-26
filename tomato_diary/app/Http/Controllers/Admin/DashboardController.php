<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Diary; // TomatoDiaryモデルを作成していると仮定します
use Illuminate\Support\Facades\DB; // DBファサードを使用する場合
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 管理者認証ミドルウェアなどがあればここに記述
        // $this->middleware('auth:admin'); // 例
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // データベースにあるすべての日記エントリを取得
        $diaryEntries = Diary::orderBy('date', 'asc')->get();

        $events = [];
        foreach ($diaryEntries as $entry) {
            $events[] = [
                'id'    => $entry->id,
                'title' => mb_substr($entry->note, 0, 10) . (mb_strlen($entry->note) > 10 ? '...' : ''),
                'start' => $entry->date,
                'allDay' => true,
                // 'url'   => route('diary.show', $entry->id), // <--- この行を削除するか、コメントアウトしてください
                'color' => '#FF6347',
            ];
        }
        // var_dump($events);
        // die();
        // --- 天気データ集計 ---

        // 'weather'カラムでグループ化し、それぞれの件数をカウント
        $weatherCounts = Diary::select('weather', DB::raw('count(*) as count'))
            ->groupBy('weather')
            ->pluck('count', 'weather') // ['晴れ' => 10, '曇り' => 5, ...] の形式にする
            ->toArray();



        $weatherLabels = array_keys($weatherCounts);
        $weatherValues = array_values($weatherCounts);

        // ここを追加！
        $totalWeatherCount = array_sum($weatherCounts); // 天気の総件数を計算

        // --- トマトの個数データ集計 ---
        // 例1: トマトの総収穫数（シンプルに合計するだけ）
        $totalTomatoCount = Diary::sum('tomato_count');

        // 例2: トマトの個数をカテゴリ分けして集計する
        // 例えば、「少なかった日」「普通だった日」「多かった日」など
        // これはビジネスロジックによって変わりますが、一例として示します。
        $smallCount = Diary::where('tomato_count', '<', 5)->count();
        $mediumCount = Diary::whereBetween('tomato_count', [5, 10])->count();
        $largeCount = Diary::where('tomato_count', '>', 10)->count();

        // カテゴリ分けしたデータをドーナツグラフ用に整形
        $harvestLabels = ['少なかった日 (1-4個)', '普通の日 (5-10個)', '多かった日 (11個以上)'];
        $harvestValues = [$smallCount, $mediumCount, $largeCount];

        // 総収穫数を示す場合は、ラベルと値を1つずつ用意する
        // $harvestLabels = ['総収穫数'];
        // $harvestValues = [$totalTomatoCount];


        return view('admin.dashboard', compact(
            'events',
            'weatherLabels',
            'weatherValues',
            'harvestLabels',
            'harvestValues', // カテゴリ分けしたデータを使用
            'totalWeatherCount', // 天気の総件数を渡す場合は、ここで計算して渡す
            'totalTomatoCount' // もし総収穫数を使うなら、こちらを渡す: 'harvestLabels', 'harvestValues'
        ));
    }
}
