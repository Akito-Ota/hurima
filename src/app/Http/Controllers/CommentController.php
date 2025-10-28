<?php

namespace App\Http\Controllers; //コメント機能用

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Comment;
class CommentController extends Controller
{
    public function store(Request $request, Item $item)
    {
        $data = $request->validate([
            'comment' => ['required', 'string', 'max:500'],
        ]);

        $item->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $data['comment'],
        ]);

        return back()->with('success', 'コメントを投稿しました');
    }


    public function destroy(\App\Models\Item $item, \App\Models\Comment $comment)
    {
        $this->authorize('delete', $comment); 
        abort_unless($comment->item_id === $item->id, 404);
        $comment->delete();

        return back()->with('success', 'コメントを削除しました');
    }
}
