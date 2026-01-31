<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Product;
use App\Enums\ProductCondition;

class ExhibitionController extends Controller
{
    public function index()
    {

        $categories = Category::all();

        // 支払い方法
        $product_conditions = collect(ProductCondition::cases())->map(function ($case) {
            return [
                'value' => $case->value,
                'label' => $case->label(),
            ];
        });

        return view("sell/index", compact('categories', 'product_conditions'));
    }

    public function store(ExhibitionRequest $request)
    {

        $param = [
            'name' => $request->name,
            'brand_name' => $request->brand_name,
            'explanation' => $request->explanation,
            'condition' => $request->condition,
            'price' => $request->price,
            'user_id' => auth()->id(),
        ];

        if ($request->file('image_path')) {
            $path = $request->file('image_path')->store('products', 'public');
            $param['image_path'] = $path;
        }

        $product = Product::create($param);
        $product->categories()->sync(
            $request->category_ids
        );

        return redirect('/');
    }
}
