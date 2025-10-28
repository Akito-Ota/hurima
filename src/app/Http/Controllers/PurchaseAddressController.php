<?php

namespace App\Http\Controllers; //送付先変更セッション作成のコントローラー

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;
use App\Models\Purchase;

class PurchaseAddressController extends Controller
{
    public function edit(Item $item) //送付先変更画面表示
    {
        $profile = auth()->user()->profile;
        $defaults = session('checkout.address') ?? [
            'postcode' => $profile->postcode,
            'address'  => $profile->address,
            'building' => $profile->building,
        ];

        return view('purchase.address', compact('item', 'defaults'));
    }

    public function update(Request $request, Item $item)//情報の一時保存機能(セッション)
    {
        $data = $request->validate([
            'postcode' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address'  => ['required', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:255'],
        ]);

        // “購入用配送先”として一時保存
        session(['checkout.address' => $data]);

        // 購入画面へ戻す
        return redirect()
            ->route('purchase.show', $item)
            ->with('success', '配送先を更新しました。');
    }
}
