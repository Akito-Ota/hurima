<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use App\Models\User;
use App\Models\Message;
use App\Models\Transaction;

class MessageController extends Controller
{
    // MessageController.php

    public function store(MessageRequest $request, Transaction $transaction)
    {

        abort_unless(
            $transaction->seller_id === auth()->id() || $transaction->buyer_id === auth()->id(),
            403
        );

        $data = $request->validated();

        if ($request->hasFile('message_images')) {
            $data['message_images'] = $request->file('message_images')->store('messages', 'public');
        }

        $transaction->messages()->create([
            'user_id' => auth()->id(),
            'comment' => $data['comment'],
            'message_images' => $data['message_images'] ?? null,
        ]);

        $transaction->update(['last_message_at' => now()]);

        return back()->with('success', 'メッセージを投稿しました。');
    }

    public function update(MessageRequest $request, Transaction $transaction, Message $message)
    {
        abort_unless(
            $transaction->seller_id === auth()->id() || $transaction->buyer_id === auth()->id(),
            403
        );

        abort_unless($message->transaction_id === $transaction->id, 404);

        abort_unless($message->user_id === auth()->id(), 403);

        $data = $request->validated();

        if ($request->hasFile('message_images')) {
            $data['message_images'] = $request->file('message_images')->store('messages', 'public');
        }

        $message->update([
            'comment' => $data['comment'],
            'message_images' => $data['message_images'] ?? $message->message_images,
        ]);

        $transaction->update(['last_message_at' => now()]);

        return back()->with('success', 'メッセージを更新しました。');
    }

    public function delete(Transaction $transaction, Message $message)
    {
        abort_unless($message->transaction_id === $transaction->id, 404);
        abort_unless($message->user_id === auth()->id(), 403);

        $message->delete();

        return back()->with('success', 'メッセージを削除しました。');
    }
}
