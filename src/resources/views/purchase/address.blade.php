@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{asset('css/purchase/address.css')}}">
@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <div class="address-form">
        <h2 class="content__heading">住所の変更</h2>
        <div class="address-form__inner">

            <form method="POST" action="/purchase/address" class="address-form__form">
                @csrf
                <div class="address-form__group">
                    <label class="address-form__label label" for="postcode">郵便番号</label>
                    <input type="text" name="postcode" value="{{ $purchase['shipping_postcode'] }}"
                        class="address-form__input" />
                    @error('postcode')
                        <p class="error-message">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="address-form__group">
                    <label class="address-form__label label" for="address">住所</label>
                    <input type="text" name="address" value="{{$purchase['shipping_address']}}"
                        class="address-form__input" />
                    @error('address')
                        <p class="error-message">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="address-form__group">
                    <label class="address-form__label label" for="building">建物名</label>
                    <input type="text" name="building" value="{{ $purchase['shipping_building'] }}"
                        class="address-form__input" />
                </div>
                <input class="address-form__btn btn" type="submit" value="更新する">
            </form>
        </div>
    </div>
@endsection