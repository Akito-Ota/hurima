<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Item;
use App\Models\User;
use App\Models\Message;
use App\Models\Review;

class Transaction extends Model
{
    protected $fillable = [
        'item_id',
        'seller_id',
        'buyer_id',
        'status',
        'last_message_at',
        'buyer_completed_at',
        'seller_completed_at',
    ];

    public const STATUS_IN_PROGRESS = 0;
    public const STATUS_COMPLETED   = 1;


    public function isFullyCompleted(): bool
    {
        return !is_null($this->buyer_completed_at) && !is_null($this->seller_completed_at);
    }


    public function syncStatus(): void
    {
        if ($this->isFullyCompleted() && (int)$this->status !== self::STATUS_COMPLETED) {
            $this->update(['status' => self::STATUS_COMPLETED]);
        }
    }

    public function markBuyerCompleted(): void
    {
        if (is_null($this->buyer_completed_at)) {
            $this->buyer_completed_at = now();
            $this->save();
        }

        $this->syncStatus();
    }


    public function markSellerCompleted(): void
    {
        if (is_null($this->seller_completed_at)) {
            $this->seller_completed_at = now();
            $this->save();
        }

        $this->syncStatus();
    }

    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class,'buyer_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function unreadMessagesCount()
    {
        return $this->messages()
            ->where('user_id', '!=', auth()->id()) 
            ->whereNull('read_at')                 
            ->count();
    }
}
