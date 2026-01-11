<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Transaction;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'comment',
        'transaction_id',
        'message_images',
        'read_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    protected $casts = [
        'read_at' => 'datetime',
    ];
}
