@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>仕様書一覧</h1>

        <h2>PDF仕様書</h2>
        <ul>
            <li>
                <a href="{{ route('specifications.showPdf', ['filename' => 'feature-spec']) }}" target="_blank">
                    機能Aの仕様書 (PDF)
                </a>
            </li>
        </ul>

        <hr>

        <h2>機能ごとのスクリーンショット・図</h2>
        <div class="row">
            <div class="col-md-6">
                <h3>機能A</h3>
                <p>機能Aのスクリーンショット1:</p>
                <img src="{{ asset('images/feature-a-screenshot-1.png') }}" alt="機能A スクリーンショット1" style="max-width: 100%; height: auto;">
                <p>機能Aの概念図:</p>
                <img src="{{ asset('images/feature-a-diagram.jpg') }}" alt="機能A 概念図" style="max-width: 100%; height: auto;">
            </div>
            <div class="col-md-6">
                <h3>機能B</h3>
                <p>機能Bのスクリーンショット:</p>
                <img src="{{ asset('images/feature-b-screenshot.png') }}" alt="機能B スクリーンショット" style="max-width: 100%; height: auto;">
            </div>
        </div>
    </div>
@endsection