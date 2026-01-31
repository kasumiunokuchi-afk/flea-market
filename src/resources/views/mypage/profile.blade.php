@extends('layouts/app')
@section('css')
    <link rel="stylesheet" href="{{asset('css/mypage/profile.css')}}">
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
    <h2 class="content__heading">プロフィール設定</h2>
    <div class="form__inner">
        <form action="/mypage/edit" method="post" class="form" enctype="multipart/form-data">
            @csrf
            <div class="profile-image">
                <div id="preview" class="preview-image">
                    @if($user->image_path)
                        <img src="{{ asset('storage/' . $user->image_path) }}">
                    @else
                        <div class="no-image">No Image</div>
                    @endif
                </div>
                <input type="file" name="image_path" id="image-input" accept="image/*" style="display: none;">

                <!-- 表示用ボタン -->
                <button type="button" id="image-select-btn" class="btn-image">
                    画像を選択する
                </button>
                @error('image_path')
                    <p class="error-message">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="form__group ">
                <label class="form__label">ユーザー名</label>
                <input type="text" value="{{ $user->name }}" name="name" class="form__input" />
                @error('name')
                    <p class="error-message">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="form__group ">
                <label class="form__label">郵便番号</label>
                <input type="text" value="{{ $user->postcode }}" name="postcode" class="form__input" />
                @error('postcode')
                    <p class="error-message">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="form__group ">
                <label class="form__label">住所</label>
                <input type="text" value="{{ $user->address }}" name="address" class="form__input" />
                @error('address')
                    <p class="error-message">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="form__group ">
                <label class="form__label">建物名</label>
                <input type="text" value="{{ $user->building }}" name="building" class="form__input" />
            </div>
            <button type="submit" class="btn">更新する</button>
        </form>
    </div>
@endsection