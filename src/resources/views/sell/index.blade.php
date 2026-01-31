@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{asset('css/sell/index.css')}}">
@endsection
@section('js')
    <script>

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('image-select-btn').addEventListener('click', () => {
                document.getElementById('image-input').click();
            });

            document.getElementById('image-input').addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (!file) return;

                const div = document.getElementById('preview');
                // ① 中身を空にする
                div.innerHTML = '';

                // ② img 要素を作る
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.alt = 'プレビュー画像';
                img.style.maxWidth = '100%';

                // ③ div の中に追加
                div.appendChild(img);

                // URL.revokeObjectURL(img.src);
            });
        });
    </script>

@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <h2 class="content__heading">商品の出品</h2>
    <div class="form__inner">
        <form method="POST" action="/sell" class="form" enctype="multipart/form-data">
            @csrf
            <div class="product-image">
                <div class="form__label">商品画像</div>
                <div class="product-image-area">
                    <div id="preview" class="preview-image">
                    </div>
                    <input type="file" name="image_path" id="image-input" accept="image/*" style="display: none;">

                    <!-- 表示用ボタン -->
                    <button type="button" id="image-select-btn" class="btn-image">
                        画像を選択する
                    </button>
                </div>
            </div>
            <div class="subheading">
                <h3>商品の詳細</h3>
            </div>
            <div class="form__group">
                <div class="form__label">カテゴリー</div>
                <div class="category-select">
                    @foreach($categories as $category)
                        <label class="category-checkbox">
                            <input type="checkbox" name="category_ids[]" value="{{ $category->id }}">
                            <span>{{ $category->content }}</span>
                        </label>
                    @endforeach
                </div>
                @error('category')
                    <p class="error-message">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="form__group">
                <div class="form__label" for="product_condition">商品の状態</div>
                <div class="form__input select-wrapper">
                    <select name="condition">
                        <option disabled>選択してください</option>
                        @foreach ($product_conditions as $product_condition)
                            <option value="{{ $product_condition['value'] }}">
                                {{ $product_condition['label'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_condition')
                        <p class="error-message">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="subheading">
                <h3>商品名と説明</h3>
            </div>
            <div class="form__group">
                <div class="form__label">商品名</div>
                <div class="form__input">
                    <input type="text" name="name" />
                    @error('name')
                        <p class="error-message">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <div class="form__label">ブランド名</div>
                <div class="form__input">
                    <input type="text" name="brand_name" />
                    @error('brand_name')
                        <p class="error-message">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <div class="form__label">商品の説明</div>
                <div class="form__input">
                    <textarea name="explanation"></textarea>
                    @error('explanation')
                        <p class="error-message">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="form__group">
                <div class="form__label">販売価格</div>
                <div class="form__input">
                    <div class="price-field">
                        <input type="numeric" name="price" class="price-input" />
                    </div>
                    @error('price')
                        <p class="error-message">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <input class="form__btn btn" type="submit" value="出品する">
        </form>
    </div>
    </div>
@endsection