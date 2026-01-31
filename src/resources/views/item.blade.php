@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{asset('css/item.css')}}">
@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // ===== いいね =====
            document.querySelectorAll('.like-button').forEach(button => {
                button.addEventListener('click', async (e) => {
                    e.preventDefault();

                    const countEl = document.getElementById('likes-count');
                    const productId = button.dataset.productId;
                    if (!productId) return;

                    const response = await fetch(`/item/${productId}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                    });

                    if (!response.ok) return;

                    const data = await response.json();

                    button.dataset.liked = data.liked ? '1' : '0';
                    button.querySelector('img').src = data.liked
                        ? '/img/ハートロゴ_ピンク.png'
                        : '/img/ハートロゴ_デフォルト.png';

                    if (countEl) {
                        countEl.textContent = data.likes_count;
                    }
                });
            });

            // ===== コメント =====
            const form = document.getElementById('comment-form');
            if (!form) return;

            const commentsList = document.getElementById('comments-list');
            const textarea = document.getElementById('comment-body');

            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const countImg = document.getElementById('comments-count__img');
                const countList = document.getElementById('comments-count__list');
                const content = textarea.value.trim();

                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ content }),
                });

                if (!res.ok) {
                    const errorMessage = document.getElementById('form-error');
                    const error = await res.json();
                    errorMessage.textContent = error.errors.content;
                    return;
                }

                const data = await res.json();

                const div = document.createElement('div');
                div.classList.add('comment-item');

                const divInner = document.createElement('div');
                divInner.classList.add('comment-user-info');

                const divUserInfo = document.createElement('div');
                divUserInfo.classList.add('comment-user-image');
                divUserInfo.classList.add('image-wrap');

                var imgStr;
                if (data.comment.user.image_path) {
                    imagePath = "/storage/" + data.comment.user.image_path;
                    //testImgPath = URL.createObjectURL(data.comment.user.image_path);
                    imgStr = `<img src="${imagePath}">`;
                } else {
                    imgStr = `<div class="no-image">No Image</div>`;
                }
                divUserInfo.innerHTML = imgStr;

                var userNameStr = `<div div class="comment-user-name" > ${data.comment.user.name}</div >`
                divInner.innerHTML = userNameStr;
                divInner.prepend(divUserInfo);

                var commentStr = `<div class="comment-comment">${data.comment.content}</div>`;
                div.innerHTML = commentStr;
                div.prepend(divInner);

                commentsList.appendChild(div); // 後ろに挿入
                textarea.value = '';

                if (countImg) {
                    countImg.textContent = data.comments_count;
                }
                if (countList) {
                    countList.textContent = data.comments_count;
                }
            });
        });
    </script>


@endsection


@section('header')
    @include('partials.header')
@endsection

@section('content')
    <div class="page">
        <div class="content-left">
            <img src="{{ asset('storage/' . $product->image_path) }}">
        </div>
        <div class="content-right">
            <div class="content-title">
                <h2>{{ $product->name }}</h2>
            </div>
            <div class="bland-name">
                <span>{{ $product->brand_name }}</span>
            </div>
            <div class="price">
                ¥<span>{{ number_format($product->price) }}</span>(税込)
            </div>
            <div class="icons">
                <div class="icon_heart">
                    <span class="icon">
                        <button class="like-button" data-product-id="{{ $product->id }}"
                            data-liked="{{ $product->is_liked_by_me ? '1' : '0' }}">
                            <img src="{{ asset($product->is_liked_by_me ? 'img/ハートロゴ_ピンク.png' : 'img/ハートロゴ_デフォルト.png') }}"
                                class="like-icon">
                        </button>
                    </span>
                    <span id="likes-count">
                        {{ $product->liked_users_count }}
                    </span>
                </div>
                <div class="icon_comment">
                    <img src="{{ asset('img/ふきだしロゴ.png') }}" class="comment-icon">
                    <span id="comments-count__img">{{ $product->comments_count }}</span>
                </div>
                <div>

                </div>
            </div>
            <div>
                @if($product->purchase_count > 0)
                    <a class="btn-disabled" type="submit">購入手続きへ</a>
                @else
                    <a class="btn" type="submit" href="/purchase/{{ $product->id }}">購入手続きへ</a>
                @endif
            </div>
            <div class="product-explanation">
                <h3>商品説明</h3>
                <div>{{ $product->explanation }}</div>
            </div>
            <div class="product-info">
                <h3>商品情報</h3>
                <div class="product-info__grid">
                    <div class="product-info__label-category">カテゴリー</div>
                    <div class="product-info__body-category">
                        @foreach($product->categories as $category)
                            <div class="item-category">{{ $category->content }}</div>
                        @endforeach
                    </div>
                    <div class="product-info__label-condition">商品の状態</div>
                    <div class="product-body-condition">{{ $product->condition->label() }}</div>
                </div>
            </div>
            <div class="product-comment">
                <h3>コメント(<span id="comments-count__list">{{ $product->comments_count }}</span>)</h3>
                <div id="comments-list">
                    @foreach($product->comments as $comment)
                        <div class="comment-item">
                            <div class="comment-user-info">
                                <div class="comment-user-image image-wrap">
                                    @if($comment->user->image_path)
                                        <img src="{{ asset('storage/' . $comment->user->image_path) }}">
                                    @else
                                        <div class="no-image">No Image</div>
                                    @endif
                                </div>
                                <div class="comment-user-name">{{ $comment->user->name }}</div>
                            </div>
                            <div class="comment-comment">
                                {{ $comment->content }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="add-comment">
                    <h4>商品へのコメント</h4>
                    <span class="error-message" id="form-error">
                    </span>
                    <form id="comment-form" data-product-id="{{ $product->id }}" action="/item/{{ $product->id }}/comment">
                        @csrf
                        <textarea name="body" id="comment-body" class="comment-textarea"></textarea>
                        <button type="submit" class="btn">コメントを送信する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection