<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = [];
        $tab = request()->query('tab') ?? '';
        $search_keyword = request()->query('keyword') ?? $request->search_keyword;

        if ($tab === 'mylist') {
            // パラメータ設定ありの場合
            // （tab=mylistが設定されている）

            if (auth()->check()) {
                // ログインしている場合のみ表示
                // いいねした商品だけ表示
                // 購入した商品はSoldを表示
                $products = auth()->user()
                    ->likedProducts()
                    ->with([
                        'purchase' => function ($query) {
                            $query->where('user_id', auth()->id());
                        }
                    ])
                    ->when($request->keyword, function ($q) use ($request) {
                        $q->where('name', 'like', "%{$request->keyword}%");
                    })
                    ->get();
            }
        } else {
            // パラメータ設定なしの場合
            // 全ての商品情報を取得
            // 購入した商品はSoldを表示
            $query = Product::query()->with('purchase')
                ->when($request->keyword, function ($q) use ($request) {
                    $q->where('name', 'like', "%{$request->keyword}%");
                });

            if (auth()->check()) {
                // ログインしていたら自分が出品した商品は除外する
                $query->where('user_id', '!=', auth()->id());
            }

            $products = $query->get();
        }

        return view("index", compact('products', 'tab', 'search_keyword'));
    }

    public function detail($item_id)
    {
        $product = Product::with([
            'categories',
            'comments.user',
            'likedUsers',
        ])
            ->withCount(['comments', 'likedUsers', 'purchase'])
            ->withExists([
                'likedUsers as is_liked_by_me' => function ($q) {
                    if (auth()->check()) {
                        $q->where('user_id', auth()->id());
                    }
                }
            ])
            ->findOrFail($item_id);

        return view("item", compact("product"));
    }

}
