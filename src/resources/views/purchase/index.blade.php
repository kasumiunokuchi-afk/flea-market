@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{asset('css/purchase/index.css')}}">
@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('payment_method');
            const text = document.getElementById('payment-description');

            select.addEventListener('change', () => {
                const selected = select.options[select.selectedIndex];
                text.textContent = selected.dataset.label;
            });
        });
    </script>

@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <div class="page">
        <form action="/purchase" method="post" class="form">
            @csrf
            <div class="content-info">
                <div class="content-left">
                    <div class="product-info">
                        <img src="{{ asset('storage/' . $product->image_path) }}">
                        <div class="product-info__txt">
                            <h2>{{ $product->name }}</h2>
                            ¥<span>{{ number_format($product->price) }}</span>(税込)
                        </div>
                    </div>
                </div>
                <div class="content-right price-box">
                    <div class="row">
                        <div class="label">商品代金</div>
                        <div class="value">¥{{ number_format($product->price) }}(税込)</div>
                    </div>
                    <div class="row">
                        <div class="label">支払い方法</div>
                        <div class="value">
                            <p id="payment-description">{{ $purchase['payment_method']->label() }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-info">
                <div class="content-left">
                    <div class="purchase-info payment-method">
                        <div class="purchase-info__header">
                            <h3>支払い方法</h3>
                        </div>
                        <div class="purchase-info__body select-wrapper">
                            <select name="payment_method" id="payment_method">
                                <option disabled>選択してください</option>
                                @foreach ($payment_methods as $payment_method)
                                    <option value="{{ $payment_method['value'] }}"
                                        {{$payment_method['value'] == $purchase['payment_method']->value ? 'selected' : ''}}
                                        data-label="{{ $payment_method['label'] }}">
                                        {{ $payment_method['label'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_method')
                                <p class="error-message">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="content-right">
                    <button class="btn" type="submit">購入する</button>
                </div>
            </div>
            <input type="hidden" value="{{ $product->id }}" name="product_id" />
            <input type="hidden" name="shipping_postcode" value="{{$purchase['shipping_postcode']}}" />
            <input type="hidden" name="shipping_address" value="{{$purchase['shipping_address']}}" />
            <input type="hidden" name="shipping_building" value="{{$purchase['shipping_building']}}" />
        </form>
        <div class="content-info">
            <div class="content-left">
                <div class="purchase-info">
                    <div class="purchase-info__header">
                        <h3>配送先</h3>
                        <a href="/purchase/address/{{$product->id}}">変更する</a>
                    </div>
                    <div class="purchase-info__body">
                        <div class="address">
                            @if(
                                    $errors->has('shipping_postcode') ||
                                    $errors->has('shipping_address')
                                )
                                <p class="error-message">
                                    配送先は必ず指定してください。
                                </p>
                            @endif
                            <div>
                                @if($purchase['shipping_postcode'])
                                    〒
                                @endif
                                {{$purchase['shipping_postcode']}}
                            </div>
                            <div>{{$purchase['shipping_address']}}</div>
                            <div>{{$purchase['shipping_building']}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-right"></div>
        </div>
    </div>
@endsection