@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">トマト観察日記</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        @forelse($diaries as $diary)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $diary->date->format('Y年m月d日') }}</h5>
                        <div class="d-flex flex-row">
                            <div class="flex-grow-1 pe-3">
                                <p class="card-text">
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
                    </div>
                    {{-- @if($diary->photos->count() > 0)
                        <div class="card-footer">
                            <div class="row">
                                @foreach($diary->photos as $photo)
                                    <div class="col-4 mb-2">
                                        <img src="{{ Storage::url($photo->photo_path) }}" 
                                             class="img-thumbnail photo-thumbnail" 
                                             alt="日記の写真"
                                             data-bs-toggle="modal"
                                             data-bs-target="#photoModal{{ $photo->id }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">まだ日記がありません。</p>
            </div>
        @endforelse
    </div>
</div>

<!-- 写真モーダル -->
@foreach($diaries as $diary)
    @foreach($diary->photos as $photo)
        <div class="modal fade" id="photoModal{{ $photo->id }}" tabindex="-1" aria-labelledby="photoModalLabel{{ $photo->id }}" aria-hidden="true" data-bs-backdrop="false">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="photoModalLabel{{ $photo->id }}">{{ $diary->date->format('Y年m月d日') }}の写真</h5>
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
});
</script>
@endpush

@endsection 