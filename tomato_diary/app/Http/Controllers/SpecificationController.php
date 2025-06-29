<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class SpecificationController extends Controller // ここを SpecificationController に変更
{
    /**
     * 仕様書一覧ページを表示する
     * （PDFへのリンクを含む）
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // ビューの名前を specifications.index に変更
        return view('specifications.index');
    }

    /**
     * 指定されたPDFファイルを表示する
     *
     * @param string $filename PDFファイル名（拡張子なし）
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\Response
     */
    public function showPdf($filename) // メソッド名を showPdf など、より具体的な名前にすることも検討
    {
        $filePath = storage_path('app/public/pdfs/' . $filename . '.pdf');

        if (!file_exists($filePath)) {
            abort(404, '指定されたPDFファイルが見つかりません。');
        }

        return Response::file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '.pdf"',
        ]);
    }
}
