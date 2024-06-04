<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        // バリデーションを追加
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 認証を試みる
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // ログイン成功後にリダイレクト
            return redirect()->intended('/');
        }

        // 認証失敗時の処理
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
