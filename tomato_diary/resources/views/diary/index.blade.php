@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-2">
                    <h4 class="mb-0">トマト日記一覧管理者ページ</h4>
                </div>

                <div class="card-body p-1">
                    @if (session('success'))
                        <div class="alert alert-success py-2" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @foreach($diaries as $diary)
                        <div class="card mb-1 shadow-sm">
                            <div class="card-body p-1">
                                <h5 class="card-title mb-1" id="date-{{ \Carbon\Carbon::parse($diary->date)->format('Y-m-d') }}" style="font-size: 1.5rem;">{{ $diary->date ? \Carbon\Carbon::parse($diary->date)->format('Y年m月d日') : '日付なし' }}</h5>
                                <div class="d-flex flex-row">
                                    <div class="flex-grow-1 pe-3">
                                        <p class="card-text mb-1" style="font-size: 1.2rem;">
                                            <strong>天気:</strong> {{ $diary->weather }}<br>
                                            <strong>トマトの数:</strong> {{ $diary->tomato_count }}個<br>
                                            @if($diary->note)
                                                <strong>メモ:</strong><br>
                                                {{ $diary->note }}
                                            @endif
                                        </p>
                                    </div>
                                    
                                    @if($diary->photos->count() > 0)
                                        <div class="flex-shrink-0" style="width: 50%;">
                                            <div class="row g-2">
                                                @foreach($diary->photos as $photo)
                                                    <div class="col-6">
                                                        <img src="{{ Storage::url($photo->photo_path) }}" 
                                                             class="img-thumbnail photo-thumbnail w-100" 
                                                             alt="日記の写真"
                                                             data-bs-toggle="modal"
                                                             data-bs-target="#photoModal{{ $photo->id }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-1">
                                    <a href="{{ route('diary.edit', $diary->id) }}" class="btn btn-primary btn-sm py-1 px-1" style="font-size: 1rem;">
                                        <i class="fas fa-edit"></i> 編集する
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 写真モーダル -->
@foreach($diaries as $diary)
    @foreach($diary->photos as $photo)
        <div class="modal fade" id="photoModal{{ $photo->id }}" tabindex="-1" aria-labelledby="photoModalLabel{{ $photo->id }}" aria-hidden="true" data-bs-backdrop="false">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="photoModalLabel{{ $photo->id }}">{{ $diary->date ? \Carbon\Carbon::parse($diary->date)->format('Y年m月d日') : '日付なし' }}の写真</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ Storage::url($photo->photo_path) }}" 
                             class="img-fluid modal-photo" 
                             alt="日記の写真"
                             data-photo-id="{{ $photo->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endforeach

<style>
.photo-thumbnail {
    cursor: pointer;
    transition: transform 0.2s;
}
.photo-thumbnail:hover {
    transform: scale(1.05);
}
.modal-body img {
    max-height: 80vh;
    object-fit: contain;
    cursor: zoom-in;
    transition: transform 0.3s ease;
}
.modal-body img.zoomed {
    transform: scale(1.5);
    cursor: zoom-out;
}
.modal-backdrop {
    display: none !important;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 写真の拡大・縮小切り替え
    document.querySelectorAll('.modal-photo').forEach(function(photo) {
        photo.addEventListener('click', function(e) {
            e.stopPropagation();
            this.classList.toggle('zoomed');
        });
    });

    // モーダルの初期化
    document.querySelectorAll('.modal').forEach(function(modalElement) {
        const modal = new bootstrap.Modal(modalElement, {
            backdrop: false,
            keyboard: true
        });

        // 閉じるボタンのイベントリスナー
        const closeButtons = modalElement.querySelectorAll('[data-bs-dismiss="modal"]');
        closeButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const photo = modalElement.querySelector('.modal-photo');
                if (photo) {
                    photo.classList.remove('zoomed');
                }
                modal.hide();
            });
        });

        // ESCキーでモーダルを閉じる
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const photo = modalElement.querySelector('.modal-photo');
                if (photo) {
                    photo.classList.remove('zoomed');
                }
                modal.hide();
            }
        });
    });

    // URLのハッシュに基づいてスクロール
    if (window.location.hash) {
        const targetId = window.location.hash.substring(1); // '#' を除去
        const targetElement = document.getElementById(targetId);
        if (targetElement) {
            // スムーズスクロール
            targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            // URLからハッシュを削除（任意）
            // history.replaceState(null, null, ' ');
        }
    }
});
</script>
@endpush

@endsection 