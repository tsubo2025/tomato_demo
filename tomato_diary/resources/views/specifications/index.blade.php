@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>仕様書一覧</h1>

        <h2>システム仕様書</h2>
        <ul>
            
            <li>
                <a href="{{ Storage::url('pdfs/spec_tomato.pdf') }}" target="_blank" id="tomato-spec-link">
                    トマト栽培日記仕様書 (PDF) - 新しいタブで開く
                </a>
            </li>
        </ul>

        <hr>

        <h2>トマト観察日記仕様書</h2>
        <div class="pdf-container mb-4">
            <iframe src="{{ Storage::url('pdfs/spec_tomato.pdf') }}" 
                    width="100%" 
                    height="800px" 
                    style="border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            </iframe>
        </div>

        <hr>

        <h2>苗・使用部品</h2>
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 mb-4 d-flex justify-content-center">
                <div class="card h-100 shadow-sm" style="max-width: 400px; width: 100%; background-color: #ffe4ec;">
                    <div class="card-body text-start">
                        <h3 class="card-title">苗/液体肥料</h3>
                        <p>カゴメトマト・ぷるるん</p>
                        <img src="{{ asset('image/parts/tomato_san.png') }}" alt="水回り部品" class="img-fluid float-start mb-2" style="max-height: 200px; max-width: 100%;">
                        <div class="clearfix"></div>
                        <p class="mt-2 mb-1">液体肥料</p>
                        <img src="{{ asset('image/parts/hyponica.png') }}" alt="機能A 概念図" class="img-fluid float-start" style="max-height: 200px; max-width: 100%;">
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-4 d-flex justify-content-center">
                <div class="card h-100 shadow-sm" style="max-width: 400px; width: 100%; background-color: #ffe4ec;">
                    <div class="card-body text-start">
                        <h3 class="card-title">ポンプ・電装部品</h3>
                        <p>スイッチング</p>
                        <img src="{{ asset('image/parts/swiching.png') }}" alt="機能B スクリーンショット" class="img-fluid float-start mb-2" style="max-height: 200px; max-width: 100%;">
                        <div class="clearfix"></div>
                        <p>エアポンプ</p>
                        <img src="{{ asset('image/parts/pump.png') }}" alt="機能B スクリーンショット" class="img-fluid float-start" style="max-height: 200px; max-width: 100%;">
                        <div class="clearfix"></div>
                    </div>
                </div>
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