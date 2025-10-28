<?php

namespace App\Http\Controllers;  //いいね機能用

use Illuminate\Http\Request;
use App\Models\Item;

class ItemsLikeController extends Controller
{
    public function store(Item $item)
    {
        $item->likes()->firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        return back();
    }

    public function destroy(Item $item)
    {
        $item->likes()->where('user_id', auth()->id())->delete();
        return back();
    }
}