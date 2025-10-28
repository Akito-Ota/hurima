<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Item;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function items(): belongsToMany
    {
        return $this->belongsToMany(Item::class, 'category_item')->withTimestamps();
    }
}
