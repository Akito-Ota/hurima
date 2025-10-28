@extends('layouts.app')

@section('title', 'プロフィール変更画面')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
<div class="profile-container">
    <h1 class="profile-title">プロフィール設定</h1>

    <form method="POST" action="{{ route('mypage.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group profile-image-area">
            <div class="image-preview-wrapper">
                <img
                    src="images/avatar-placeholder.png"
                    alt="プロフィール画像"
                    class="profile-image-preview"
                    id="imagePreview">
            </div>
            <label for="image" class="image-select-button">画像を選択する</label>
            <input type="file" name="image" id="image" accept="image/*" class="file-input" value="{{ old('image', $profile->image ?? '') }}">
        </div>

        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}">
            @error('name')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="postcode">郵便番号</label>
            <input type="text" name="postcode" id="postcode" value="{{ old('postcode', $profile->postcode ?? '') }}">
            @error('postcode')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address', $profile ->address ?? '') }}">
            @error('address')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" id="building" value="{{ old('building', $profile ->building ?? '') }}" placeholder="入力してください">
            @error('building')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="submit-button">更新する</button>

    </form>

</div>

<!-- プレビュー表示スクリプト -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('image');
        const preview = document.getElementById('imagePreview');

        input.addEventListener('change', event => {
            const file = event.target.files[0];
            if (!file) return;

            if (file.type.match(/^image\//)) {
                const reader = new FileReader();
                reader.addEventListener('load', e => {
                    preview.src = e.target.result;
                });
                reader.readAsDataURL(file);
            } else {
                alert('画像ファイルを指定してください');
                input.value = '';
            }
        });
    });
</script>

@endsection