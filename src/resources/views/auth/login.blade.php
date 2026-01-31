@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{asset('css/auth/login.css')}}">
@endsection

@section('content')
    <div class="login-form">
        <h2 class="content__heading">ログイン</h2>
        <div class="login-form__inner">
            <form method="POST" action="/login" class="login-form__form">
                @csrf
                <div class="login-form__group">
                    <label class="login-form__label label" for="email">メールアドレス</label>
                    <input class="login-form__input" type="email" name="email" id="email" >
                    @error('email')
                        <p class="error-message">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div class="login-form__group">
                    <label class="login-form__label label" for="password">パスワード</label>
                    <input class="login-form__input" type="password" name="password" id="password">
                    @error('password')
                        <p class="error-message">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <input class="login-form__btn btn" type="submit" value="ログインする">
            </form>
        </div>
    </div>
    <div class="content__link">
        <a href="/register">会員登録はこちら</a>
    </div>

@endsection