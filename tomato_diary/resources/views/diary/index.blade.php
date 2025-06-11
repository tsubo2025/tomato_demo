@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">トマト日記一覧</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    

                    @foreach($diaries as $diary)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ optional($diary->date)->format('Y年m月d日') }} - {{ $diary->weather }}</h5>
                                <p class="card-text">{{ $diary->note }}</p>
                                <p class="card-text">トマトの数: {{ $diary->tomato_count }}</p>
                                
                                @if($diary->photos->count() > 0)
                                    <div class="row">
                                        @foreach($diary->photos as $photo)
                                            <div class="col-md-4 mb-2">
                                                <img src="{{ Storage::url($photo->photo_path) }}" class="img-fluid" alt="トマトの写真">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <a href="{{ route('diary.edit', $diary->id) }}" class="btn btn-sm btn-primary">編集</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 