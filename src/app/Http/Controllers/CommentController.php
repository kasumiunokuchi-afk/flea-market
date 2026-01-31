<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Product;

class CommentController extends Controller
{

    public function store(CommentRequest $request, Product $product)
    {
        $comment = $product->comments()->create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'content' => $request['content'],
        ]);

        // user 情報も一緒に返す
        $comment->load('user');

        return response()->json([
            'comment' => $comment,
            'comments_count' => $product->comments()->count(),
        ]);
    }

}
