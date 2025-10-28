@extends('layouts.app')

@section('title', 'マイページ画面')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endpush
@section('content')

<div class="form-group profile-image-area">
    <img src="{{ optional($profile)->image_url ?? asset('images/avatar-placeholder.png') }}"
        alt="プロフィール画像" class="profile-image">
    <p class="username">{{ $user->name }}</p>
    <a class="mypage-profile-link" href="{{ route('mypage.profile.edit') }}">プロフィール編集</a>
</div>


<div class="tab-container">
    <div class="tabs">
        {{-- ラジオ：出品 / 購入 --}}
        <input type="radio" id="tab-sell" name="mypage-tab" class="tab-input" checked>
        <input type="radio" id="tab-buy" name="mypage-tab" class="tab-input">

        {{-- タブメニュー --}}
        <nav class="tab-links">
            <label for="tab-sell">出品した商品</label>
            <label for="tab-buy">購入した商品</label>
        </nav>

        {{-- タブ1（出品） --}}
        <div class="tab-panels">
            <section class="tab-panel" data-tab="sell">
                <h3>出品した商品</h3>
                <div class="items-grid">
                    @forelse ($items as $item)
                    <a href="{{ route('items.show', $item) }}" class="card">
                        <img src="{{ $item->item_images ? asset('storage/' . $item->item_images) : asset('images/noimage.png') }}" alt="{{ $item->name }}">
                        <p>{{ $item->name }}</p>
                    </a>
                    @empty
                    <p>まだ出品はありません。</p>
                    @endforelse
                </div>
            </section>
                {{-- タブ2（購入） --}}
                <section class="tab-panel" data-tab="buy">
                    <h3>購入した商品</h3>
                    <div class="items-grid">
                        @forelse ($purchasedItems as $p)
                        <a href="{{ route('items.show', $p->item) }}" class="card">
                            <img src="{{ $p->item->item_images ? asset('storage/' . $p->item->item_images) : asset('images/noimage.png') }}" alt="{{ $p->item->name }}">
                            <p>{{ $p->item->name }}</p>
                        </a>
                        @empty
                        <p>まだ購入商品はありません。</p>
                        @endforelse
                    </div>
                </section>
        </div>
    </div>
</div>
@endsection