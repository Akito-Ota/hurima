<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    protected $table = 'likes'; 

    protected $fillable = [
        'user_id','item_id',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
