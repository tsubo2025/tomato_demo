@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>仕様書一覧</h1>

        <h2>PDF仕様書</h2>
        <ul>
            
            <li>
                <a href="{{ asset('pdfs/spec_tomato.pdf') }}" target="_blank" id="tomato-spec-link">
                    トマト観察日記仕様書 (PDF) - 新しいタブで開く
                </a>
            </li>
        </ul>

        <hr>

        <h2>トマト観察日記仕様書</h2>
        <div class="pdf-container mb-4">
            <iframe src="{{ asset('pdfs/spec_tomato.pdf') }}" 
                    width="100%" 
                    height="800px" 
                    style="border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            </iframe>
        </div>

        <hr>

        <h2>使用部品</h2>
        <div class="row">
            <div class="col-md-6">
                <h3>水周り</h3>
                <p>:</p>
                <img src="{{ asset('images/feature-a-screenshot-1.png') }}" alt="水回り部品" style="max-width: 100%; height: auto;">
                <p>機能Aの概念図:</p>
                <img src="{{ asset('images/feature-a-diagram.jpg') }}" alt="機能A 概念図" style="max-width: 100%; height: auto;">
            </div>
            <div class="col-md-6">
                <h3>ポンプ・電装部品</h3>
                <p>機能Bのスクリーンショット:</p>
                <img src="{{ asset('images/feature-b-screenshot.png') }}" alt="機能B スクリーンショット" style="max-width: 100%; height: auto;">
            </div>
        </div>
    </div>

<style>
.pdf-container {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}
.pdf-container iframe {
    background: white;
}
</style>

@endsection