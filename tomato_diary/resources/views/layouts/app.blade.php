<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'トマトさん製作委員会') }}</title>

    @stack('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @vite('resources/css/app.css') {{-- <-- mouse_stalker --}}
</head>
<body class="{{ \App\Helpers\ThemeHelper::getThemeClass() }} {{ \App\Helpers\ThemeHelper::getBackgroundClass() }} {{ \App\Helpers\ThemeHelper::getTextClass() }}" style="{{ \App\Helpers\ThemeHelper::getWallpaperStyle() }}">
    <div class="d-flex flex-column min-vh-100">
        <x-header />

        <main class="flex-grow-1" style="margin-top: 30px;">
            <div class="container-fluid px-4">
                <div class="row justify-content-center">
                    <div class="col-xxl-10">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>

        <x-footer />
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    @vite('resources/js/app.js') {{-- <-- mouse_stalker --}}
</body>
</html>
