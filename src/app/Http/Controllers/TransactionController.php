<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Message;
use App\Models\Review;
use App\Notifications\SellerTransactionCompleted;
use Illuminate\Support\Facades\Notification;

class TransactionController extends Controller
{
    public function show(Transaction $transaction)
    {
        $user = auth()->id();

        $isBuyer  = $transaction->buyer_id === $user;
        $isSeller = $transaction->seller_id === $user;
        abort_unless($isBuyer || $isSeller, 403);
        $transaction->messages()
            ->where('user_id', '!=', $user)
            ->whereNull('read_at')
            ->update(['read_at' => \Carbon\Carbon::now()]);
        $transaction->load(['seller', 'buyer', 'item', 'messages.user.profile']);
        $othertransactions = Transaction::with(['item', 'seller', 'buyer'])
            ->where(function ($q) use ($user) {
                $q->where('seller_id', $user)
                    ->orWhere('buyer_id', $user);
            })
            ->where('status', 0)
            ->where('id', '!=', $transaction->id)
            ->orderByDesc('last_message_at')
            ->get();
        $buyerHasReviewed = Review::where('transaction_id', $transaction->id)
            ->where('reviewer_id', $transaction->buyer_id)
            ->exists();

        $sellerHasReviewed = Review::where('transaction_id', $transaction->id)
            ->where('reviewer_id', $transaction->seller_id)
            ->exists();
        $partner = $isSeller ? $transaction->buyer : $transaction->seller;
        $canBuyerReview  = $isBuyer  && !$buyerHasReviewed  && !is_null($transaction->buyer_completed_at);
        $canSellerReview = $isSeller && !$sellerHasReviewed && !is_null($transaction->buyer_completed_at);

        $shouldOpenReviewModal = $canBuyerReview || $canSellerReview;

        return view('mypage.transaction', compact(
            'transaction',
            'isBuyer',
            'isSeller',
            'canBuyerReview',
            'canSellerReview',
            'shouldOpenReviewModal',
            'partner',
            'othertransactions'
        ));
    }

    public function complete(Transaction $transaction)
    {
        $userId = auth()->id();

        abort_unless($transaction->buyer_id === $userId, 403);

        if (!is_null($transaction->buyer_completed_at)) {
            return back()->with('info', 'すでに取引完了済みです。');
        }

        $transaction->markBuyerCompleted();

        $seller = $transaction->seller;
        $seller->notify(new SellerTransactionCompleted($transaction));

        return back()->with('success', '取引を完了しました。');
    }
}
