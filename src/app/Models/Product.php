<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ProductCondition;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'condition' => ProductCondition::class,
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product')
            ->withTimestamps();
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'likes')
            ->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
