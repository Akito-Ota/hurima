<?php

namespace App\Http\Controllers; //ログイン用

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('login');
    }


    public function store(LoginRequest $request)
    {
        $credentials = $request->validated();

        // ログイン成功時
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('items.index'); // 商品一覧へ
        }

        // ログイン失敗時
        return back()
            ->withErrors(['email' => 'メールアドレスまたはパスワードが違います。'])
            ->onlyInput('email');
    }
    
    public function destroy(Request $request)
    {
        Auth::logout(); 
        request()->session()->invalidate();
        request()->session()->regenerateToken(); 

        return redirect('/login'); 
    }
}
