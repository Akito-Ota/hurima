@extends('layouts.app')

@section('logo-only-header')
@endsection

@section('title', '取引チャット')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/transaction.css') }}">
@endpush

@section('content')
{{-- ===================== 名前・完了ボタン ===================== --}}
@php
$isBuyer = ((int)$transaction->buyer_id === (int)auth()->id());
@endphp
<div class="whole-layout">

    {{-- ===================== 左側：サイドバー（その他の取引） ===================== --}}
    <aside class="sidebar-container">
        <h3 class="sidebar-title">その他の取引</h3>
        <div class="sidebar-list">
            @foreach ($othertransactions as $t)
            @if($t->item)
            <a href="{{ route('transaction.show', $t) }}" class="sidebar-item">
                <div class="sidebar-item-icon">
                    <img
                        src="{{ $t->item->item_images ? asset('storage/' . $t->item->item_images) : asset('images/noimage.png') }}"
                        alt="{{ $t->item->name }}">
                </div>
                <span class="sidebar-item-text">{{ $t->item->name }}</span>
            </a>
            @endif
            @endforeach
        </div>
    </aside>

    {{-- ===================== 右側：メインコンテンツ ===================== --}}
    <main class="main-content">

        {{-- 1. ヘッダーエリア（ユーザー名 + 取引完了ボタン） --}}
        <header class="chat-header">
            <div class="header-user-info">
                {{-- ユーザーアイコン（円形） --}}
                <img src="{{ optional($partner)->image_url ?? asset('images/avatar-placeholder.png') }}"
                    alt="プロフィール画像"
                    class="profile-image">
                <h2>「{{ $partner->name }}」さんとの取引画面</h2>
            </div>

            {{--モーダル制御エリア --}}
            <div x-data="{ open: @js($shouldOpenReviewModal), rating: 0 }">
                {{-- 取引完了ボタン --}}
                @if ($isBuyer && is_null($transaction->buyer_completed_at))
                <form action="{{ route('transaction.complete', $transaction) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-complete">取引を完了する</button>
                </form>
                @endif

                {{-- 評価モーダル   --}}
                <div x-show="open" x-cloak class="modal-overlay">
                    <div class="modal-container">
                        <div class="modal-header">
                            <h3>取引が完了しました。</h3>
                        </div>
                        <form method="POST" action="{{ route('review.store', $transaction) }}">
                            @csrf
                            <div class="modal-body">
                                <p class="modal-subtext">今回の取引相手はどうでしたか？</p>
                                <div class="star-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <input type="radio" id="star{{ $i }}" name="score" value="{{ $i }}" x-model="rating" required>
                                        <label for="star{{ $i }}" :class="rating >= {{ $i }} ? 'star-yellow' : 'star-grey'">★</label>
                                        @endfor
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="submit-btn">送信する</button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- 評価モーダル終了  --}}
            </div>
        </header>

        {{-- 2. 商品情報エリア --}}
        <section class="item-info-section">
            <div class="item-info-box">
                <div class="item-image-wrapper">
                    <img src="{{ asset('storage/' . $transaction->item->item_images) }}" alt="{{ $transaction->item->name }}">
                </div>
                <div class="item-text-details">
                    <h3 class="item-name">{{ $transaction->item->name }}</h3>
                    <p class="item-price">{{ number_format($transaction->item->price) }}円</p>
                </div>
            </div>
        </section>

        {{-- 3. チャット（メッセージ）エリア --}}
        <section class="chat-messages-area" id="scroll-target">
            @forelse ($transaction->messages as $message)
            {{-- 自分のメッセージか判定してクラスを切り替える --}}
            @php
            $isMe = $message->user_id === auth()->id();
            @endphp

            <div class="message-row {{ $isMe ? 'message-right' : 'message-left' }}">

                {{-- 相手のアイコンを表示 --}}
                @if(!$isMe)
                <div class="message-avatar">
                    <img src="{{ optional($message->user->profile)->image_url ?? asset('images/avatar-placeholder.png') }}" alt="">
                </div>
                @endif

                <div class="message-content-group">
                    <p class="message-user-name">{{ $message->user->name }}</p>
                    <div class="message-bubble">
                        <p class="message-text">{!! nl2br(e($message->comment)) !!}</p>
                        @if (!empty($message->message_images))
                        <div class="message-image-attachment">
                            <img src="{{ asset('storage/' . $message->message_images) }}" alt="添付画像">
                        </div>
                        @endif
                    </div>
                    {{-- 編集・削除ボタン（自分のみ） --}}
                    @if($isMe)
                    <div class="message-meta-actions">
                        <form action="{{ route('message.delete', [$transaction, $message]) }}" method="POST" onsubmit="return confirm('削除しますか？')" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-text-delete">削除</button>
                        </form>
                        <button type="button" class="btn-text-edit" onclick="toggleEdit({{ $message->id }})">編集</button>
                    </div>
                    {{-- 編集フォーム --}}
                    <div id="edit-form-{{ $message->id }}" class="edit-form-container" style="display:none;">
                        <form action="{{ route('message.update', [$transaction, $message]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <textarea name="comment" class="edit-textarea">{{ $message->comment }}</textarea>
                            <div class="edit-buttons">
                                <button type="submit" class="btn-sm-primary">更新</button>
                                <button type="button" class="btn-sm-cancel" onclick="toggleEdit({{ $message->id }})">キャンセル</button>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>

                {{-- アイコンを表示--}}
                @if($isMe)
                <div class="message-avatar">
                    <img src="{{ optional($message->user->profile)->image_url ?? asset('images/avatar-placeholder.png') }}" alt="">
                </div>
                @endif
            </div>
            @empty
            @endforelse
        </section>

        {{-- 4. 入力フッターエリア --}}
        <footer class="chat-input-footer">
            <form action="{{ route('message.store', $transaction) }}" method="POST" enctype="multipart/form-data" class="input-form-layout">
                @csrf

                {{-- エラー表示 --}}
                @if($errors->any())
                <div class="input-errors">
                    @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span>
                    @endforeach
                </div>
                @endif

                <div class="input-row">
                    {{-- テキスト入力 --}}
                    <input type="text" name="comment" class="chat-input-field" placeholder="取引メッセージを記入してください" value="{{ old('comment') }}" autocomplete="off"
                        id="chat-comment">

                    {{-- 画像追加ボタン--}}
                    <label class="btn-add-image">
                        <span>画像を追加</span>
                        <input type="file" name="message_images" accept="image/*" style="display: none;">
                    </label>

                    {{-- 送信ボタン（紙飛行機アイコン） --}}
                    <button type="submit" class="btn-send-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 2L11 13" stroke="#888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="#888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </form>
        </footer>
    </main>
</div>

{{-- スクリプト --}}
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('chat-comment');
        if (!input) return;

        const storageKey = 'chat_draft_transaction_{{ $transaction->id }}';

        const savedData = localStorage.getItem(storageKey);
        if (savedData) input.value = savedData;

        input.addEventListener('input', () => {
            localStorage.setItem(storageKey, input.value);
        });

        input.form?.addEventListener('submit', () => {
            localStorage.removeItem(storageKey);
        });

        const target = document.getElementById('scroll-target');
        if (target) target.scrollTop = target.scrollHeight;
    });

    function toggleEdit(id) {
        const el = document.getElementById('edit-form-' + id);
        if (!el) return;
        el.style.display = (el.style.display === 'none') ? 'block' : 'none';
    }
</script>


@endsection