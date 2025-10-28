<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
class Item extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $fillable = [
        'name',
        'price',
        'description',
        'brand',
        'category_id',
        'status',
        'item_images',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item')->withTimestamps();
    }
    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function is_liked_by_auth_user()
    {
        $user = auth()->user();

        if (!$user) {
            return false; 
        }
        return $this->likes()->where('user_id', $user->id)->exists();
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}