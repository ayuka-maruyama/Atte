<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

class RegisteredUserController extends Controller
{
    // 新規登録画面の表示
    public function create() {
        return view('auth/register');
    }

    // 新規登録後ログインページへ遷移
    public function store(Request $request) {
        User::create([
            $request->only([
                'name',
                'email',
                'password'
            ])
        ]);
        return view('login');
    }
}
