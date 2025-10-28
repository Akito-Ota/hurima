@extends('layouts.app')

@section('title', 'ログイン')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
<meta name="viewport" content="width=device-width, initial-scale=1" />

<h1 class="login-title">ログイン</h1>

<div class="login-container">
    <form action="{{ route('login') }}" method="post">
        @csrf
        <!--メールアドレスを入力-->
        <label for="email" class="form-label">メールアドレス</label>
        <input id="email" name="email" type="email" class="form-input" autocomplete="email">
        @error('email') <div class="form_error">{{ $message }}</div> @enderror

        <!--パスワードを入力-->
        <label for="password" class="form-label">パスワード</label>
        <input id="password" name="password" type="password" class="form-input" autocomplete="current-password">
        @error('password') <div class="form_error">{{ $message }}</div> @enderror

        <!--ログイン処理-->
        <button type="submit" class="login-button">ログインする</button>
    </form>

    <!--登録ページに遷移-->
    <div class="register-link">
        <a href="{{ route('register.form') }}">会員登録はこちら</a>
    </div>
</div>
@endsection