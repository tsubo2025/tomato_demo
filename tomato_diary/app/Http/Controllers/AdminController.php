<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // 管理者認証（実際の環境では.envファイルで設定）
        if (
            $credentials['username'] === config('admin.username') &&
            $credentials['password'] === config('admin.password')
        ) {

            // セッションに管理者フラグを設定
            session(['is_admin' => true]);

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'username' => 'ユーザーIDまたはパスワードが正しくありません。',
        ]);
    }

    public function dashboard()
    {
        // 管理者認証チェック
        if (!session('is_admin')) {
            return redirect()->route('admin.login');
        }

        return view('admin.dashboard');
    }

    public function logout()
    {
        session()->forget('is_admin');
        return redirect()->route('welcome');
    }
}
