<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Transaction;
use App\Models\Message;
use App\Models\Review;

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

        $transactions = Transaction::where(function ($q) {
            $q->where('buyer_id', auth()->id())
                ->orWhere('seller_id', auth()->id());
        })
            ->where('status', 0)
            ->with([
                'item',
                'buyer',
                'seller',
            ])
            ->orderByDesc('last_message_at')
            ->get();



        $reviewCount = Review::where('reviewee_id', $user->id)->count();

        $reviewAvgRounded = null;
        if ($reviewCount > 0) {
            $avg = Review::where('reviewee_id', $user->id)->avg('score');
            $reviewAvgRounded = (int) round($avg);
        }


        return view('mypage.mypage', compact(
            'user',
            'items',
            'profile',
            'purchasedItems',
            'transactions',
            'reviewCount',
            'reviewAvgRounded'
        ));
    }
}
