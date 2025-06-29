@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/settings.css') }}">

<div class="min-h-screen bg-gray-100">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">システム設定</h2>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                            ダッシュボードに戻る
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-error">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- PDF設定セクションと壁紙設定セクションを横並びにするコンテナ -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- PDF設定セクション -->
                        <div class="setting-item">
                            <div class="bg-blue-50 border-l-8 border-blue-400 p-4 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        
                                    </div>
                                    <div class="ml-3"></div>
                                        <h3 class="text-lg font-medium text-blue-800">PDF仕様書の変更</h3>
                                        <p class="text-blue-700">現在の仕様書PDFを新しいファイルに変更できます。</p>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('admin.settings.pdf') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        現在のPDF: {{ $settings['current_pdf'] }}
                                    </label>
                                </div>
                                <div class="file-upload-area" id="pdf-upload-area">
                                    <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" class="file-input">
                                    <label for="pdf_file" class="file-label">
                                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <span>PDFファイルを選択またはドラッグ&ドロップ</span>
                                    </label>
                                    <p class="text-sm text-gray-600 mt-2">対応形式: PDF (最大10MB)</p>
                                </div>
                                <div class="preview-area" id="pdf-preview" style="display: none;">
                                    <h4 class="font-semibold text-gray-800 mb-2">選択されたファイル:</h4>
                                    <p id="pdf-filename" class="text-sm text-gray-600"></p>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4">
                                    PDFを更新
                                </button>
                                <button type="button" id="previewPdfButton" class="btn btn-info mt-4 ml-2">
                                    PDFプレビュー
                                </button>
                            </form>
                        </div>

                        <!-- 壁紙設定セクション -->
                        <div class="setting-item">
                            <div class="bg-green-50 border-l-8 border-green-400 p-4 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-lg font-medium text-green-800">壁紙の変更</h3>
                                        <p class="text-green-700">アプリケーションの背景壁紙を変更できます。</p>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('admin.settings.wallpaper') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">
                                        現在の壁紙: {{ $settings['current_wallpaper'] }}
                                    </label>
                                </div>
                                <div class="file-upload-area" id="wallpaper-upload-area">
                                    <input type="file" name="wallpaper_file" id="wallpaper_file" accept=".jpg,.jpeg,.png" class="file-input">
                                    <label for="wallpaper_file" class="file-label">
                                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>画像ファイルを選択またはドラッグ&ドロップ</span>
                                    </label>
                                    <p class="text-sm text-gray-600 mt-2">対応形式: JPG, JPEG, PNG (最大5MB)</p>
                                </div>
                                <div class="preview-area" id="wallpaper-preview" style="display: none;">
                                    <h4 class="font-semibold text-gray-800 mb-2">選択されたファイル:</h4>
                                    <p id="wallpaper-filename" class="text-sm text-gray-600 mb-2"></p>
                                    <img id="wallpaper-preview-img" class="preview-image" alt="プレビュー">
                                </div>
                                <button type="submit" class="btn btn-success mt-4">
                                    壁紙を更新
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- 配色設定セクション -->
                    <div class="setting-item">
                        <div class="bg-purple-50 border-l-8 border-purple-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-purple-800">配色テーマの変更</h3>
                                    <p class="text-purple-700">アプリケーションの配色テーマを変更できます。</p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('admin.settings.theme') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="theme">
                                    テーマを選択
                                </label>
                            </div>
                            <div class="theme-selector">
                                @foreach($themes as $key => $name)
                                    <div class="theme-option {{ $settings['current_theme'] == $key ? 'selected' : '' }}" 
                                         data-theme="{{ $key }}">
                                        <div class="theme-preview bg-{{ $key == 'default' ? 'gray' : $key }}-500"></div>
                                        <div class="theme-name">{{ $name }}</div>
                                        <input type="radio" name="theme" value="{{ $key }}" 
                                               {{ $settings['current_theme'] == $key ? 'checked' : '' }} 
                                               class="hidden">
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-purple mt-4">
                                テーマを更新
                            </button>
                        </form>
                    </div>

                    <!-- PDFプレビューコンテナ -->
                    <div class="setting-item mt-6" id="pdf-preview-container" style="display: none;">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">PDFプレビュー</h3>
                        <div class="pdf-container mb-4">
                            <iframe id="pdf-preview-iframe" width="100%" height="800px" style="border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"></iframe>
                        </div>
                    </div>

                    <!-- プレビューセクション -->
                    <div class="setting-item">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">設定プレビュー</h3>
                        <div class="preview-grid">
                            <div class="preview-card">
                                <h4 class="font-semibold text-gray-800 mb-2">PDF仕様書</h4>
                                <p class="text-sm text-gray-600">{{ $settings['current_pdf'] }}</p>
                                <a href="{{ route('specifications.showPdf', $settings['current_pdf']) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm" target="_blank">
                                    プレビューを見る
                                </a>
                            </div>
                            <div class="preview-card">
                                <h4 class="font-semibold text-gray-800 mb-2">壁紙</h4>
                                <p class="text-sm text-gray-600">{{ $settings['current_wallpaper'] }}</p>
                                @if($settings['current_wallpaper'] !== 'default.jpg')
                                    <img src="{{ asset('image/wallpaper/' . $settings['current_wallpaper']) }}" 
                                         alt="現在の壁紙" class="preview-image">
                                @else
                                    <div class="preview-image bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500 text-sm">デフォルト壁紙</span>
                                    </div>
                                @endif
                            </div>
                            <div class="preview-card">
                                <h4 class="font-semibold text-gray-800 mb-2">テーマ</h4>
                                <p class="text-sm text-gray-600">{{ $themes[$settings['current_theme']] }}</p>
                                <div class="mt-2">
                                    <span class="inline-block w-8 h-8 rounded-full bg-{{ $settings['current_theme'] == 'default' ? 'gray' : $settings['current_theme'] }}-500"></span>
                                    <span class="text-xs text-gray-500 ml-2">プレビュー</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // ファイル選択時のプレビュー表示
    document.getElementById('pdf_file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('pdf-preview');
        const filename = document.getElementById('pdf-filename');
        
        if (file) {
            filename.textContent = file.name;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    });

    document.getElementById('wallpaper_file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('wallpaper-preview');
        const filename = document.getElementById('wallpaper-filename');
        const previewImg = document.getElementById('wallpaper-preview-img');
        
        if (file) {
            filename.textContent = file.name;
            preview.style.display = 'block';
            
            // 画像プレビュー
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });

    // テーマ選択のUI
    document.querySelectorAll('.theme-option').forEach(option => {
        option.addEventListener('click', function() {
            // 他の選択を解除
            document.querySelectorAll('.theme-option').forEach(opt => opt.classList.remove('selected'));
            // このオプションを選択
            this.classList.add('selected');
            // ラジオボタンを選択
            this.querySelector('input[type="radio"]').checked = true;
        });
    });

    // ドラッグ&ドロップ機能
    function setupDragAndDrop(uploadAreaId, fileInputId) {
        const uploadArea = document.getElementById(uploadAreaId);
        const fileInput = document.getElementById(fileInputId);

        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                fileInput.dispatchEvent(new Event('change'));
            }
        });
    }

    setupDragAndDrop('pdf-upload-area', 'pdf_file');
    setupDragAndDrop('wallpaper-upload-area', 'wallpaper_file');

    // PDFプレビュー機能
    document.getElementById('previewPdfButton').addEventListener('click', function() {
        const pdfPreviewContainer = document.getElementById('pdf-preview-container');
        const pdfPreviewIframe = document.getElementById('pdf-preview-iframe');
        const pdfUrl = "{{ Storage::url('pdfs/spec_tomato.pdf') }}";

        pdfPreviewIframe.src = pdfUrl;
        pdfPreviewContainer.style.display = 'block';
    });
</script>
@endsection