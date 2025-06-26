<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Helpers\ThemeHelper;

class SettingController extends Controller
{
    public function index()
    {
        // 現在の設定を取得
        $settings = [
            'current_pdf' => config('app.current_pdf', 'spec_tomato.pdf'),
            'current_wallpaper' => config('app.current_wallpaper', 'default.jpg'),
            'current_theme' => ThemeHelper::getCurrentTheme(),
        ];

        // 利用可能なPDFファイル一覧
        $pdfFiles = $this->getPdfFiles();

        // 利用可能な壁紙ファイル一覧
        $wallpaperFiles = $this->getWallpaperFiles();

        // 利用可能なテーマ一覧
        $themes = [
            'default' => 'デフォルト',
            'dark' => 'ダーク',
            'light' => 'ライト',
            'green' => 'グリーン',
            'blue' => 'ブルー',
        ];

        return view('admin.settings.index', compact('settings', 'pdfFiles', 'wallpaperFiles', 'themes'));
    }

    public function updatePdf(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:10240', // 10MB制限
        ]);

        $file = $request->file('pdf_file');
        $filename = 'spec_tomato.pdf'; // 固定名で保存

        // 古いファイルを削除
        if (Storage::disk('public')->exists('pdfs/' . $filename)) {
            Storage::disk('public')->delete('pdfs/' . $filename);
        }

        // 新しいファイルを保存
        $file->storeAs('pdfs', $filename, 'public');

        return redirect()->route('admin.settings.index')->with('success', 'PDFファイルを更新しました。');
    }

    public function updateWallpaper(Request $request)
    {
        $request->validate([
            'wallpaper_file' => 'required|file|mimes:jpg,jpeg,png|max:5120', // 5MB制限
        ]);

        $file = $request->file('wallpaper_file');
        $filename = 'wallpaper.' . $file->getClientOriginalExtension();

        // 古いファイルを削除
        $oldFiles = Storage::disk('public')->files('wallpapers');
        foreach ($oldFiles as $oldFile) {
            if (str_contains($oldFile, 'wallpaper.')) {
                Storage::disk('public')->delete($oldFile);
            }
        }

        // 新しいファイルを保存
        $file->storeAs('wallpapers', $filename, 'public');

        return redirect()->route('admin.settings.index')->with('success', '壁紙を更新しました。');
    }

    public function updateTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:default,dark,light,green,blue',
        ]);

        // テーマ設定をセッションに保存
        $theme = $request->input('theme');
        session(['app_theme' => $theme]);

        return redirect()->route('admin.settings.index')->with('success', 'テーマを更新しました。');
    }

    private function getPdfFiles()
    {
        $pdfPath = storage_path('app/public/pdfs');
        $files = [];

        if (File::exists($pdfPath)) {
            $pdfFiles = File::files($pdfPath);
            foreach ($pdfFiles as $file) {
                if ($file->getExtension() === 'pdf') {
                    $files[] = $file->getFilename();
                }
            }
        }

        return $files;
    }

    private function getWallpaperFiles()
    {
        $wallpaperPath = storage_path('app/public/wallpapers');
        $files = [];

        if (File::exists($wallpaperPath)) {
            $wallpaperFiles = File::files($wallpaperPath);
            foreach ($wallpaperFiles as $file) {
                $extension = strtolower($file->getExtension());
                if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                    $files[] = $file->getFilename();
                }
            }
        }

        return $files;
    }
}
