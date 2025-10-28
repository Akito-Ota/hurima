<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'postcode', 'address', 'building','image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? Storage::url($this->image)
            : asset('images/avatar-placeholder.png'); // デフォルト画像
    }
}
