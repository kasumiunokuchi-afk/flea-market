@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <input type="hidden" name="search_keyword" value="{{ $search_keyword }}" />
    <div class="page">
        <div class="tabs">
            <a href="{{ route('home', ['keyword' => $search_keyword]) }}" class="tab {{ $tab === '' ? 'active' : '' }}">
                おすすめ
            </a>

            <a href="{{ route('home', ['tab' => 'mylist', 'keyword' => $search_keyword]) }}"
                class="tab {{ ($tab ?? '') === 'mylist' ? 'active' : '' }}">
                マイリスト
            </a>
        </div>
        <div class="scroll-content">
            <div class="list__cards">
                @foreach ($products as $product)
                    <x-product-card-with-purchase :product="$product" />
                @endforeach
            </div>
        </div>
    </div>
@endsection