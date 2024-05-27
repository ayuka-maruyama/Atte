<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User; // Userモデルを利用するためのuseステートメント
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    // 新規登録画面の表示
    public function create()
    {
        return view('auth/register');
    }

    // 新規登録後ログインページへ遷移
    public function store(RegisterRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect('/login');
    }
}
