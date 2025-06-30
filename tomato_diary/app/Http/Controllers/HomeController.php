<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diary; 
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
                'url'   => route('diary.show', $entry->id),
                'color' => '#FF6347',
            ];
        }

        // dashboard.blade.php にイベントデータを渡す
        return view('dashboard', compact('events'));
    }
}
