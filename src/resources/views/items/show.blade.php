@extends('layouts.app')

@section('title', $item->name . ' 商品詳細')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/item-show.css') }}">
@endpush

@section('content')
<div class="item-detail">

    {{-- ===================== 左：メイン画像 ===================== --}}
    <div class="item-detail__media">
        <img
            src="{{ asset('storage/' . $item->item_images) }}"
            alt="{{ $item->name }}">
    </div>

    {{-- ===================== 右：情報パネル ===================== --}}
    <div class="item-detail__side">

        {{-- タイトル／ブランド／価格 --}}
        <h1 class="item-title">{{ $item->name }}</h1>

        <div class="item-brand">
            ブランド：<span>{{ $item->brand ?? 'ー' }}</span>
        </div>

        <div class="detail__price">
            <span class="yen">¥{{ number_format($item->price) }}</span>
            <small>（税込）</small>
        </div>

        {{-- --------- リアクション（いいね／コメント） --------- --}}
        <div class="detail_reactions" aria-label="リアクション">
            {{-- いいね（星型） --}}
            <div class="chip chip--icon">
                @auth
                @if($item->is_liked_by_auth_user())
                {{-- いいね解除 --}}
                <form action="{{ route('items.unlike', $item->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="icon-btn" aria-label="お気に入り解除">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.1 6.3 7 1-5 4.9 1.2 7-6.3-3.3L5.7 21l1.2-7-5-4.9 7-1z" />
                        </svg>
                    </button>
                </form>
                @else
                {{-- いいねする --}}
                <form action="{{ route('items.like', $item->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="icon-btn" aria-label="お気に入り">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2l3.1 6.3 7 1-5 4.9 1.2 7-6.3-3.3L5.7 21l1.2-7-5-4.9 7-1z" />
                        </svg>
                    </button>

                </form>
                @endif
                <span class="icon-count">{{ $item->likes->count() }}</span>
                @endauth

                @guest
                {{-- ゲスト表示（押せない） --}}
                <span class="icon-btn is-disabled" title="ログインが必要です">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2l3.1 6.3 7 1-5 4.9 1.2 7-6.3-3.3L5.7 21l1.2-7-5-4.9 7-1z" />
                    </svg>>
                </span>
                <span class="icon-count">{{ $item->likes->count() }}</span>
                @endguest
            </div>
            {{-- コメント --}}
            <div class="chip chip--icon">
                <span class="icon-btn" aria-label="コメント">
                    <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true">
                        <path d="M21 12a8 8 0 0 1-8 8H8l-4 3v-3H5a8 8 0 1 1 16-8z"
                            fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="sr-only">コメント</span>
                </span>
                <span class="icon-count">{{ $item->comments_count ?? $item->comments->count() }}</span>
            </div>
        </div>

        {{-- 購入手続き --}}
        <div class="item-detail__cta">
            @if ($item->purchase)
            <button class="btn btn--disabled" disabled>SOLD OUT</button>
            @else
            <a href="{{ route('purchase.show', $item->id) }}" class="btn btn--primary">購入手続きへ</a>
            @endif
        </div>


        {{-- 商品説明 --}}
        <section class="blk">
            <h2 class="blk__title">商品説明</h2>
            <p class="blk__text">{{ $item->description }}</p>
        </section>

        {{-- 商品の情報（カテゴリ／状態） --}}
        <section class="blk">
            <h2 class="blk__title">商品の情報</h2>
            <dl class="meta">
                <dt>カテゴリー</dt>
                <dd>
                    @foreach ($item->categories ?? [] as $cat)
                    <span class="chip">{{ $cat->name }}</span>
                    @endforeach
                </dd>
                <dt>商品の状態</dt>
                <dd><span class="chip">{{ $item->status }}</span></dd>
            </dl>
        </section>

        {{-- コメント一覧 --}}
        <div id="comments" class="comment-list-area">
            <h2>コメント（{{ $item->comments->count() }}）</h2>
            <div class="comment-list-area__body">
                @forelse ($item->comments as $comment)
                <div class="comment-item">
                    {{-- プロフィール画像 --}}
                    <div class="comment-user-icon">
                        <img
                            src="{{ optional($comment->user->profile)->image_url ?? asset('images/avatar-placeholder.png') }}"
                            alt="プロフィール画像"
                            class="profile-image">
                    </div>
                    {{-- ユーザー名 & コメント本文 --}}
                    <div class="comment-body">
                        <p class="comment-user-name">{{ $comment->user->name }}</p>
                        <p>{{ $comment->comment }}</p>
                    </div>
                </div>
                @empty
                <p class="text-muted">まだコメントはありません。</p>
                @endforelse
            </div>
        </div>


        {{-- ログイン時のみ：コメント投稿フォーム --}}
        @auth
        <div class="chip chip--icon">
            <div class="comment-form-area">
                <form action="{{ route('comments.store', $item) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea name="comment" rows="3">{{ old('comment') }}</textarea>
                        @error('comment')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn--primary">コメントを送信する</button>
                </form>
            </div>
        </div>
        @endauth

        {{-- 未ログイン時 --}}
        @guest
        <p class="text-muted">
            コメントするには <a href="{{ route('login') }}">ログイン</a> が必要です。
        </p>
        @endguest
    </div>
</div>
@endsection