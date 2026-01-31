<?php

namespace App\Http\Controllers;

use App\Models\Product;

class LikeController extends Controller
{

    public function toggle(Product $product)
    {
        $user = auth()->user();
        // すでにいいねしているか
        $liked = $product->likedUsers()
            ->where('user_id', $user->id)
            ->exists();

        if ($liked) {
            // 解除
            $product->likedUsers()->detach($user->id);
        } else {
            // 登録
            $product->likedUsers()->attach($user->id);
        }

        return response()->json([
            'liked' => !$liked,
            'likes_count' => $product->likedUsers()->count(),
        ]);
    }

}
