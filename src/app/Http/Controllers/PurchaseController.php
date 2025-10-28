<?php

namespace App\Http\Controllers;  //商品購入画面用

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function show(Item $item) //購入画面表示
    {  
        $profile = auth()->user()->profile;
        $address = session('checkout.address') ?? [
            'postcode' => $profile->postcode ?? '',
            'address'  => $profile->address  ?? '',
            'building' => $profile->building ?? '',
        ];
        return view('purchase.show', compact('address','item'));
    }

    public function store(Request $request, Item $item)
    {
        $request->validate([
            'payment_method' => 'required|in:conbini,card',
        ]);

        // セッションの配送先、なければプロフィールで補完する
        $addr = session('checkout.address') ?: [
            'postcode' => optional(auth()->user()->profile)->postcode,
            'address'  => optional(auth()->user()->profile)->address,
            'building' => optional(auth()->user()->profile)->building,
        ];

        // まだ必須が欠けていれば住所変更へ戻す
        if (blank($addr['postcode']) || blank($addr['address'])) {
            return redirect()
                ->route('purchase.address', $item)
                ->withErrors(['address' => '配送先住所（郵便番号・住所）は必須です。'])
                ->withInput();
        }

        Purchase::create([
            'user_id'           => auth()->id(),
            'item_id'           => $item->id,
            'payment_method'    => $request->input('payment_method'),
            'shipping_postcode' => $addr['postcode'],
            'shipping_address'  => $addr['address'],
            'shipping_building' => $addr['building'],
        ]);

        // 使い終わったら削除する
        session()->forget('checkout.address');

        return redirect()->route('items.index')->with('success', '購入が完了しました。');
    }
}
