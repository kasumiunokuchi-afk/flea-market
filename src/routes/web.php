<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get(
    '/',
    [ProductController::class, 'index']
)->name('home');

Route::get(
    '/item/{item_id}',
    [ProductController::class, 'detail']
)->name('detail');

Route::middleware('auth')->group(function () {

    Route::get(
        '/mypage',
        [ProfileController::class, "index"]
    )->name('mypage.index');
    Route::get(
        '/mypage/profile',
        [ProfileController::class, "profile"]
    )->name('mypage.profile');
    Route::post(
        '/mypage/edit',
        [ProfileController::class, "update"]
    )->name('mypage.edit');

    Route::post(
        '/item/{product}/like',
        [LikeController::class, 'toggle']
    )->name('item.toggle');
    Route::post(
        '/item/{product}/comment',
        [CommentController::class, 'store']
    )->name('item.comment');

    Route::get(
        '/purchase/{item_id}',
        [PurchaseController::class, 'index']
    )->name('purchase');
    Route::post(
        '/purchase',
        [PurchaseController::class, 'store']
    )->name('buy');
    Route::get(
        '/purchase/address/{item_id}',
        [PurchaseController::class, 'address']
    )->name('address');
    Route::post(
        '/purchase/address',
        [PurchaseController::class, 'update']
    )->name('update');

    Route::get(
        '/sell',
        [ExhibitionController::class, 'index']
    )->name('sell.index');
    Route::post(
        '/sell',
        [ExhibitionController::class, 'store']
    )->name('sell.create');
});

Route::post(
    '/register',
    [RegisterController::class, 'store']
)
    ->middleware('guest')
    ->name('register');