<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diary;
use App\Models\DiaryPhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DiaryController extends Controller
{
    // 一覧表示
    public function index()
    {
        try {
            $diaries = Diary::with('photos')->orderBy('date', 'desc')->get();
            Log::info('Diaries loaded successfully', ['count' => $diaries->count()]);
            return view('diary.index', compact('diaries'));
        } catch (\Exception $e) {
            Log::error('Error in index method', ['error' => $e->getMessage()]);
            return view('diary.index', ['diaries' => collect()]);
        }
    }

    // 入力フォーム表示
    public function create()
    {
        return view('diary.create');
    }

    // データ保存処理
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'weather' => 'required|string',
            'note' => 'nullable|string',
            'photos.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'tomato_count' => 'required|integer|min:0',
        ]);

        try {
            Log::info('Storing diary entry', [
                'date' => $request->date,
                'weather' => $request->weather,
                'note' => $request->note,
                'tomato_count' => $request->tomato_count
            ]);

            // 観察日記を保存
            $diary = Diary::create([
                'date' => $request->date,
                'weather' => $request->weather,
                'note' => $request->note,
                'tomato_count' => $request->tomato_count,
            ]);

            Log::info('Diary created successfully', ['diary_id' => $diary->id]);

            // 写真を保存
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('diary_photos', 'public');
                    DiaryPhoto::create([
                        'diary_id' => $diary->id,
                        'photo_path' => $path,
                    ]);
                }
            }

            return redirect()->route('diary.index')->with('success', '日記を保存しました');
        } catch (\Exception $e) {
            Log::error('Error in store method', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with('error', '日記の保存に失敗しました。もう一度お試しください。');
        }
    }

    // 編集フォーム表示
    public function edit($id)
    {
        try {
            Log::info('Attempting to edit diary', ['id' => $id]);

            $diary = Diary::with('photos')->findOrFail($id);

            Log::info('Diary found for editing', [
                'id' => $diary->id,
                'date' => $diary->date,
                'has_photos' => $diary->photos->count()
            ]);

            return view('diary.edit', compact('diary'));
        } catch (\Exception $e) {
            Log::error('Error in edit method', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('diary.index')
                ->with('error', '日記の編集画面を開けませんでした。もう一度お試しください。');
        }
    }

    // 更新処理
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'weather' => 'required|string',
            'note' => 'nullable|string',
            'photos.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'tomato_count' => 'required|integer|min:0',
        ]);

        try {
            $diary = Diary::findOrFail($id);
            $diary->update([
                'date' => $request->date,
                'weather' => $request->weather,
                'note' => $request->note,
                'tomato_count' => $request->tomato_count,
            ]);

            // 新しく写真がある場合は追加保存
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('diary_photos', 'public');
                    DiaryPhoto::create([
                        'diary_id' => $diary->id,
                        'photo_path' => $path,
                    ]);
                }
            }

            return redirect()->route('diary.index')->with('success', '日記を更新しました');
        } catch (\Exception $e) {
            Log::error('Error in update method', ['error' => $e->getMessage()]);
            return back()->withInput()->with('error', '日記の更新に失敗しました。もう一度お試しください。');
        }
    }
}
