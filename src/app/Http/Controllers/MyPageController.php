<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class MyPageController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $items = $user->items()
            ->with('categories')
            ->latest()
            ->paginate(12);

        $purchasedItems = $user->purchases()
            ->with('item.categories')   
            ->latest()
            ->paginate(12);

        $profile = $user->profile;

        return view('mypage.mypage', compact(
            'user',
            'items',
            'profile',
            'purchasedItems'
        ));
    }
}