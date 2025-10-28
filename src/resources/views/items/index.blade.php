@extends('layouts.app')

@section('title', '商品一覧')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endpush

@section('content')

<div class="tabs">

    <input type="radio" id="tab-osusume" name="tab" checked>
    <input type="radio" id="tab-mylst" name="tab">

    <nav class="tab-nav">
        <label for="tab-osusume">おすすめ</label>
        <label for="tab-mylst">マイリスト</label>
    </nav>

    <div class="tab-panels">
        <section id="panel-osusume" class="tab-panel">
            {{-- おすすめ（通常一覧） --}}
            <div class="items-grid">
                @foreach ($items as $item)
                <a class="item-card" href="{{ route('items.show', $item->id) }}">
                    <div class="item-thumb">
                        @if($item->is_sold)
                        <span class="badge-sold">SOLD</span>
                        @endif
                        <img src="{{ asset('storage/'.$item->item_images) }}" alt="{{ $item->name }}">
                    </div>
                    <div class="item-name">{{ $item->name }}</div>
                </a>
                @endforeach
            </div>

            {{-- おすすめのページネーション --}}
            {{ $items->appends(request()->except('page'))->links() }}
        </section>

        <section id="panel-mylst" class="tab-panel">
            {{-- マイリスト（いいね一覧） --}}
            <div class="items-grid">
                @forelse ($likedItems as $item)
                <a class="item-card" href="{{ route('items.show', $item) }}">
                    <div class="item-thumb">
                        @if($item->is_sold)
                        <span class="badge-sold">SOLD</span>
                        @endif
                        <img src="{{ $item->item_images ? asset('storage/'.$item->item_images)
                                            : asset('images/noimage.png') }}"
                            alt="{{ $item->name }}">
                    </div>
                    <div class="item-name">{{ $item->name }}</div>
                </a>
                @empty
                <p class="text-muted">まだいいねした商品はありません。</p>
                @endforelse
            </div>

        </section>
    </div>
</div>

@endsection