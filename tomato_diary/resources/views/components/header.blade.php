<div>
    <!-- Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant -->
{{-- resources/views/components/header.blade.php --}}

<header>
    {{-- resources/views/components/header.blade.php --}}
<nav class="navbar navbar-expand-md navbar-light shadow-sm fixed-top custom-header-bg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('diary.index') }}">
            <i class="fas fa-seedling text-success"></i> {{ config('app.name', '本日のトマトさん') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('diary.index') ? 'active' : '' }}" href="{{ route('diary.index') }}">
                        <i class="fas fa-list"></i> 一覧
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('diary.create') ? 'active' : '' }}" href="{{ route('diary.create') }}">
                        <i class="fas fa-plus"></i> 新規作成
                    </a>
                </li>
            </ul>
            {{-- 管理者ログインボタンをここに追加 --}}
            <div class="d-flex">
               <a href="{{ route('diary.create') }}" class="btn btn-outline-success ms-md-3">管理者ログイン</a>
            </div>
        </div>
    </div>
</nav>
</header>
</div>