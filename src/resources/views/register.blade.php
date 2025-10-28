@extends('layouts.app')

@section('title', '会員登録')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush

@section('content')
<div class="register">
    <div class="register__inner">
        <h1 class="register__title">会員登録</h1>

        <form action="{{ route('register') }}" method="post" class="form">
            @csrf
            <!--名前を入力-->
            <div class="form__row">
                <label for="name" class="form__label">ユーザー名</label>
                <input id="name" name="name" type="text" class="form__control" autocomplete="name">
                @error('name') <div class="form__error">{{ $message }}</div> @enderror
            </div>
            <!--メールアドレスを入力-->
            <div class="form__row">
                <label for="email" class="form__label">メールアドレス</label>
                <input id="email" name="email" type="email" class="form__control" autocomplete="email">
                @error('email') <div class="form__error">{{ $message }}</div> @enderror
            </div>
            <!--パスワードを入力-->
            <div class="form__row">
                <label for="password" class="form__label">パスワード</label>
                <input id="password" name="password" type="password" class="form__control" autocomplete="new-password">
                @error('password') <div class="form__error">{{ $message }}</div> @enderror
            </div>
            <!--パスワード入力確認用-->
            <div class="form__row">
                <label for="password_confirmation" class="form__label">確認用パスワード</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form__control" autocomplete="new-password">
                @error('password_confirmation') <div class="form__error">{{ $message }}</div> @enderror
            </div>
            <!--登録用ボタン-->
            <div class="form__actions">
                <button type="submit" class="button button--primary">登録する</button>
            </div>
            <!--ログインページに遷移-->
            <a class="register__login-link" href="{{ route('login.form') }}">ログインはこちら</a>
        </form>
    </div>
</div>


@endsection