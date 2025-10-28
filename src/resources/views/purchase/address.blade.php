@extends('layouts.app')

@section('title', '送付先住所変更')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endpush

@section('content')
<main>
    <div class="address-wrap">
        <h1 class="address-title">住所変更</h1>

        <div class="edit-container">
            <form method="post" action="{{ route('purchase.address.update', $item) }}">
                @csrf
                @method('PUT')

                <div class="form-list">
                    <div class="form-group">
                        <label for="postcode">郵便番号</label>
                        <input type="text" id="postcode" name="postcode"
                            value="{{ old('postcode', $defaults['postcode']) }}">
                        @error('postcode')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">住所</label>
                        <input type="text" id="address" name="address"
                            value="{{ old('address', $defaults['address']) }}">
                        @error('address')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="building">建物名</label>
                        <input type="text" id="building" name="building"
                            value="{{ old('building', $defaults['building']) }}">
                        @error('building')
                        <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="update-button">
                        <button type="submit">更新する</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection