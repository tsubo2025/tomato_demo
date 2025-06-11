@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-2">
                    <h4 class="mb-0">トマト日記一覧</h4>
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
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1 pe-1">
                                        <h5 class="card-title mb-1" style="font-size: 1.5rem;">{{ $diary->date ? \Carbon\Carbon::parse($diary->date)->format('Y年m月d日') : '日付なし' }} - {{ $diary->weather }}</h5>
                                        <p class="card-text mb-1" style="font-size: 1.2rem;">{{ $diary->note }}</p>
                                        <p class="card-text mb-0" style="font-size: 1.2rem;">トマトの数: {{ $diary->tomato_count }}</p>
                                    </div>
                                    
                                    @if($diary->photos->count() > 0)
                                        <div class="ms-1">
                                            @foreach($diary->photos as $photo)
                                                <img src="{{ Storage::url($photo->photo_path) }}" 
                                                     class="img-thumbnail mb-1" 
                                                     style="max-width: 120px; height: auto; padding: 0.1rem;"
                                                     alt="トマトの写真">
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-1">
                                    <a href="{{ route('diary.edit', $diary->id) }}" class="btn btn-primary btn-sm py-0 px-1" style="font-size: 1rem;">
                                        <i class="fas fa-edit"></i> 編集
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
@endsection 