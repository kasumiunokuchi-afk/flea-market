<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    //
    public function index(Request $request)
    {
        $tab = request()->query('tab') ?? 'sell';

        // 取得情報
        // 1. プロフィール画像
        $imgPath = auth()->user()->image_path;
        // 2. ユーザー名
        $userName = auth()->user()->name;
        $products = [];
        if ($tab === "sell") {
            // 3. 出品した商品一覧
            $products = Product::where(
                'user_id',
                '=',
                auth()->id()
            )->get();
        } else {
            // 4. 購入した商品一覧
            $products = Product::whereHas('purchase', function ($q) {
                $q->where('user_id', auth()->id());
            })->get();
        }

        return view(
            "mypage/index",
            compact(
                "imgPath",
                "userName",
                "products",
                "tab"
            )
        );
    }

    public function profile()
    {
        $user = auth()->user();
        return view(
            "mypage/profile",
            compact('user')
        );
    }

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();
        $form = $request->all();

        if ($request->file('image_path')) {
            $path = $request->file('image_path')->store('users', 'public');

            $form['image_path'] = $path;

            if ($user->image_path && Storage::disk('public')->exists($user->image_path)) {
                Storage::disk('public')->delete($user->image_path);
            }
        }

        unset($form['_token']);
        $user->update($form);

        return redirect('/mypage');
    }
}
