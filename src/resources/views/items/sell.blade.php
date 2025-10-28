@extends('layouts.app')

@section('title', isset($item) ? ($item->name . ' | 商品出品') : '商品出品')


@push('styles')
<link rel="stylesheet" href="{{ asset('css/item-sell.css') }}">
@endpush

@section('content')
<h1 class="page-title">商品の出品</h1>

<form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="form">
    @csrf
    <div class="form-row form-row-image">
        <label>商品画像</label>
        <div class="image-drop-zone">
            <label for="item_images_input" class="image-select-button">画像を選択する</label>
            <input type="file" name="item_images" id="item_images_input" class="image-input" accept="image/*">
        </div>
        @error('item_images') <p class="error">{{ $message }}</p> @enderror
    </div>

    <h2>商品詳細</h2>
    <div class="form-row">
        <label>商品の状態</label>
        <select name="status">
            <option value="良好">良好</option>
            <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
            <option value="やや傷や汚れあり">やや傷や汚れあり</option>
            <option value="状態が悪い">状態が悪い</option>
        </select>
        @error('status') <p class="error">{{ $message }}</p> @enderror
    </div>

    <label>カテゴリー</label>
    <div class="category-list">
        @php
        $selected = (array) old('category_ids', isset($item) ? $item->categories->pluck('id')->all() : []);
        @endphp

        @foreach($categories as $category)
        <label class="category-item" for="cat-{{ $category->id }}">
            <input
                id="cat-{{ $category->id }}"
                type="checkbox"
                name="category_ids[]"
                value="{{ $category->id }}"
                {{ in_array($category->id, $selected ?? []) ? 'checked' : '' }}>
            <span>{{ $category->name }}</span>
        </label>
        @endforeach

        @error('category_ids')
        <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <h2>商品名と説明</h2>
    <div class="form-row">
        <label>商品名</label>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name') <p class="error">{{ $message }}</p> @enderror
    </div>
    <div class="form-row">
        <label>ブランド</label>
        <input type="text" name="brand" value="{{ old('brand') }}">
        @error('brand') <p class="error">{{ $message }}</p> @enderror
    </div>
    <div class="form-row">
        <label>商品説明</label>
        <textarea name="description" rows="6">{{ old('description') }}</textarea>
        @error('description') <p class="error">{{ $message }}</p> @enderror
    </div>
    <div class="form-row form-row-price">
        <label>価格</label>
        <div class="price-input-wrapper">
            <span class="price-yen-symbol">¥</span>
            <input type="number" name="price" value="{{ old('price') }}" min="1" step="1">
        </div>
        @error('price') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">出品する</button>
    </div>
</form>
@endsection