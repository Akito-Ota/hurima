<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'score' => ['required', 'integer', 'between:1,5'],
        ]);

        $userId = auth()->id();

        $isSeller = ($transaction->seller_id === $userId);
        $isBuyer  = ($transaction->buyer_id === $userId);
        abort_unless($isSeller || $isBuyer, 403);

        $revieweeId = $isBuyer ? $transaction->seller_id : $transaction->buyer_id;

        Review::updateOrCreate(
            [
                'transaction_id' => $transaction->id,
                'reviewer_id'    => $userId,
            ],
            [
                'reviewee_id' => $revieweeId,
                'score'       => $data['score'],
            ]
        );
        if ($isBuyer) {
            $transaction->markBuyerCompleted();
        } else {
            $transaction->markSellerCompleted();
        }

        return redirect()->route('items.index')->with('success', '評価を送信しました。');
    }
}
