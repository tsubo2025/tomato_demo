<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ThemeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // セッションからテーマを取得
        $theme = session('app_theme', 'default');

        // ビューにテーマ情報を渡す
        view()->share('current_theme', $theme);

        return $next($request);
    }
}
