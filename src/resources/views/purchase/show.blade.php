@extends('layouts.app')

@section('title', '購入手続き')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endpush

@section('content')
<form method="POST" action="{{ route('purchase.store', $item) }}">
    @csrf
    <div class="purchase-container">
        <!-- 左部分 -->
        <div class="purchase-left">
            <!-- 商品情報 -->
            <div class="purchase-item">
                <img src="{{ asset('storage/' . $item->item_images) }}" alt="{{ $item->name }}">
                <div class="purchase-item-info">
                    <h1 class="item-title">{{ $item->name }}</h1>
                    <p class="item-price">¥{{ number_format($item->price) }}</p>
                </div>
            </div>

            <!-- 支払い方法 -->
            <div class="payment-section">
                <h2 class="section-title">支払い方法</h2>
                <select name="payment_method" id="payment_method">
                    <option value="">選択してください</option>
                    <option value=" conbini">コンビニ払い</option>
                    <option value="card">カード払い</option>
                </select>
            </div>

            <!-- 配送先 -->
            <div class="address-section">
                <h2 class="section-title">配送先</h2>
                <a href="{{ route('purchase.address', $item) }}" class="change-link">変更する</a>
                <p class="address-text">
                    〒{{ $address['postcode'] ?? '' }}<br>
                    {{ $address['address'] ?? '' }}<br>
                    {{ $address['building'] ?? '' }}
                </p>
            </div>
        </div>

        <!-- 右部分 -->
        <div class="purchase-right">
            <table class="summary">
                <tr>
                    <th>商品代金</th>
                    <td id="payment-price-display">¥{{ number_format($item->price) }}</td>
                </tr>
                <tr>
                    <th>支払い方法</th>
                    <td id="payment-method-display">コンビニ払い</td>
                </tr>
            </table>
            <button type="submit" class="btn btn-red">購入する</button>
        </div>
    </div>
</form>


    <!--スクリプト-->
    <script>
        const select = document.getElementById('payment_method');
        const display = document.getElementById('payment-method-display');

        function update() {
            const selectedText = select.options[select.selectedIndex].text;
            display.textContent = selectedText;
        }

        select.addEventListener('change', update);
        document.addEventListener('DOMContentLoaded', update);
    </script>
    @endsection