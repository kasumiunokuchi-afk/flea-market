<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use App\Enums\PaymentMethod;

class PurchaseController extends Controller
{

    public function index($item_id)
    {
        // 製品情報
        $product = Product::findOrFail($item_id);

        // 購入情報
        $purchase = session('purchase');
        if (
            !$purchase ||
            !isset($purchase['product_id']) ||
            $purchase['product_id'] != $item_id
        ) {
            $user = auth()->user();
            // セッション情報にない場合はUser情報から取得
            $purchase['product_id'] = $item_id;
            $purchase['payment_method'] = PaymentMethod::CONVENIENCE_STORE;
            $purchase['shipping_postcode'] = $user->postcode;
            $purchase['shipping_address'] = $user->address;
            $purchase['shipping_building'] = $user->building;

            session(['purchase' => $purchase]);
        }

        // 支払い方法
        $payment_methods = collect(PaymentMethod::cases())->map(function ($case) {
            return [
                'value' => $case->value,
                'label' => $case->label(),
            ];
        });

        return view(
            "purchase/index",
            compact("product", "purchase", "payment_methods")
        );
    }

    public function store(PurchaseRequest $request)
    {
        $purchase = $request->only([
            'product_id',
            'payment_method',
            'shipping_postcode',
            'shipping_address',
            'shipping_building',
        ]);
        $purchase['user_id'] = auth()->id();

        Purchase::create($purchase);
        session()->forget('purchase');
        return redirect('/');
    }

    public function address($item_id)
    {
        $purchase = session('purchase');
        return view(
            "purchase/address",
            compact('purchase')
        );
    }

    public function update(AddressRequest $request)
    {
        // 購入情報
        $purchase = session('purchase');

        $purchase['shipping_postcode'] = $request->postcode;
        $purchase['shipping_address'] = $request->address;
        $purchase['shipping_building'] = $request->building;

        session(['purchase' => $purchase]);

        return redirect('/purchase/' . $purchase['product_id']);
    }

}
