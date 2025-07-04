@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">日記を編集</h4>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm ms-2">
                        <i class="fas fa-arrow-left"></i> ダッシュボードへ戻る
                    </a>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('diary.update', $diary->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="date" class="form-label">日付 <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('date') is-invalid @enderror" 
                                   id="date" 
                                   name="date" 
                                   value="{{ old('date', optional($diary->date)->format('Y-m-d')) }}" 
                                   required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="weather" class="form-label">天気 <span class="text-danger">*</span></label>
                            <select class="form-select @error('weather') is-invalid @enderror" 
                                    id="weather" name="weather" required>
                                <option value="">選択してください</option>
                                @foreach(['晴れ', '曇り', '雨', '雪'] as $weather)
                                    <option value="{{ $weather }}" {{ old('weather', $diary->weather ?? '') == $weather ? 'selected' : '' }}>
                                        {{ $weather }}
                                    </option>
                                @endforeach
                            </select>
                            @error('weather')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">メモ</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" 
                                      id="note" name="note" rows="3" 
                                      placeholder="今日の様子を記録しましょう">{{ old('note', $diary->note ?? '') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="photos" class="form-label">写真</label>
                            <input type="file" class="form-control @error('photos.*') is-invalid @enderror" 
                                   id="photos" name="photos[]" multiple accept="image/*">
                            <div class="form-text">複数の写真を選択できます（JPG, JPEG, PNG形式、2MB以下）</div>
                            @error('photos.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($diary->photos->count() > 0)
                            <div class="mb-3">
                                <label class="form-label">現在の写真</label>
                                <div class="row">
                                    @foreach($diary->photos as $photo)
                                        <div class="col-md-4 mb-2">
                                            <img src="{{ Storage::url($photo->photo_path) }}" 
                                                 class="img-thumbnail" alt="日記の写真">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="tomato_count" class="form-label">収穫したトマトの数 <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('tomato_count') is-invalid @enderror" 
                                   id="tomato_count" name="tomato_count" 
                                   value="{{ old('tomato_count', $diary->tomato_count ?? 0) }}" 
                                   min="0" required>
                            @error('tomato_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('diary.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> 戻る
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 更新
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .invalid-feedback {
        display: block;
    }
    .card {
        background-color: #e8f5e9;
    }
    .card-header h4 {
        font-family: 'Rounded Mplus 1c', 'Noto Sans JP', 'Hiragino Maru Gothic ProN', 'Yu Gothic Rounded', 'sans-serif';
        color: #388e3c;
    }
</style>
@endpush

@push('scripts')
<script>
    // フォームのバリデーション
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endpush
@endsection 