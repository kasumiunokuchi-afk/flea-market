@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{asset('css/mypage/index.css')}}">
@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <div class="content_body">
        <div class="profile-heading">
            <div class="profile-image">
                @if($imgPath)
                    <img src="{{ asset('storage/' . $imgPath) }}">
                @else
                    <div class="no-image">No Image</div>
                @endif
            </div>
            <div class="profile-name">
                <h2>{{ $userName }}</h2>
            </div>
            <div class="profile-link">
                <a href="{{ route('mypage.profile') }}">プロフィールを編集</a>
            </div>
        </div>
        <div class="tabs">
            <a href="{{ route('mypage.index', ['tab' => 'sell']) }}"
                class="tab {{ ($tab ?? '') === 'sell' ? 'active' : '' }}">
                出品した商品
            </a>
            <a href="{{ route('mypage.index', ['tab' => 'buy']) }}"
                class="tab {{ ($tab ?? '') === 'buy' ? 'active' : '' }}">
                購入した商品
            </a>

        </div>
        <div class="scroll-content">
            <div class="list__cards">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </div>
@endsection