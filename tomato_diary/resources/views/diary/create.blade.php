@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">新規日記作成</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('diary.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label for="date" class="form-label">日付</label>
                            <input type="date" 
                                   class="form-control @error('date') is-invalid @enderror" 
                                   id="date" 
                                   name="date" 
                                   value="{{ old('date', date('Y-m-d')) }}" 
                                   required>
                            @error('date')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="weather" class="form-label">天気</label>
                            <select class="form-select @error('weather') is-invalid @enderror" 
                                    id="weather" 
                                    name="weather" 
                                    required>
                                <option value="" {{ old('weather') == '' ? 'selected' : '' }}>選択してください</option>
                                @foreach(['晴れ', '曇り', '雨'] as $weather)
                                    <option value="{{ $weather }}" {{ old('weather') == $weather ? 'selected' : '' }}>
                                        {{ $weather }}
                                    </option>
                                @endforeach
                            </select>
                            @error('weather')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">メモ</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" 
                                      id="note" 
                                      name="note" 
                                      rows="3" 
                                      placeholder="トマトの様子や気づいたことを記録してください">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="photos" class="form-label">写真</label>
                            <input type="file" 
                                   class="form-control @error('photos.*') is-invalid @enderror" 
                                   id="photos" 
                                   name="photos[]" 
                                   multiple 
                                   accept="image/*">
                            <div class="form-text">複数の写真を選択できます（JPG, JPEG, PNG形式、最大2MB）</div>
                            @error('photos.*')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tomato_count" class="form-label">トマトの数</label>
                            <input type="number" 
                                   class="form-control @error('tomato_count') is-invalid @enderror" 
                                   id="tomato_count" 
                                   name="tomato_count" 
                                   value="{{ old('tomato_count', 0) }}" 
                                   min="0" 
                                   required>
                            @error('tomato_count')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('diary.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> 戻る
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 保存
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
    .form-label {
        font-weight: 600;
        color: #333;
    }
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }
    .btn {
        padding: 0.5rem 1.5rem;
    }
    .invalid-feedback {
        font-size: 0.875rem;
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