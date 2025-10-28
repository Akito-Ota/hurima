<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\ItemsLikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\PurchaseAddressController;
/*
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
//ログインページ用
Route::get('/login',  [LoginController::class, 'create'])->name('login.form'); //画面表示
Route::post('/login', [LoginController::class, 'store'])->name('login'); //ログイン処理

//ログアウト用
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout'); //ログアウト処理(ヘッダー)

//商品一覧
Route::get('/items', [ItemsController::class, 'index'])->name('items.index'); // 一覧ページ
//商品詳細
Route::get('/items/{id}', [ItemsController::class, 'show'])->name('items.show')->whereNumber('id');//詳細ページ

//検索機能
Route::get('/items/search', [ItemsController::class, 'search'])->name('items.search'); 


//会員登録ページ用
Route::get('/register',[RegisterController::class,'create'])->name('register.form'); //画面表示
Route::post('/register',[RegisterController::class,'store'])->name('register'); //会員登録

Route::middleware('auth')->group(
    function () {
//プロフィール編集ページ用
Route::get('/mypage/profile/create', [ProfilesController::class, 'create'])->name('mypage.profile.form'); //初回画面表示
Route::post('/mypage/profile', [ProfilesController::class, 'store'])->name('mypage.profile.store'); //初回プロフィール保存機能
Route::get('/mypage/profile', [ProfilesController::class, 'edit'])->name('mypage.profile.edit');//2回目以降の画面表示
Route::put('/mypage/profile',  [ProfilesController::class, 'update'])->name('mypage.profile.update');   // 2回目以降の更新

//いいね機能
Route::post('/items/{item}/like',  [ItemsLikeController::class, 'store'])->name('items.like');
Route::delete('/items/{item}/like', [ItemsLikeController::class, 'destroy'])->name('items.unlike');//いいね取り消し機能


//コメント機能
Route::post('/items/{item}/comments', [CommentController::class, 'store'])->name('comments.store'); //コメント投稿機能
Route::delete('/items/{item}/comments/{comment}', [CommentController::class, 'destroy'])
->name('comments.destroy');//コメント削除機能

//購入画面
Route::get('/purchase/{item}', [PurchaseController::class, 'show'])->name('purchase.show');//画面表示
Route::post('/purchase/{item}', [PurchaseController::class, 'store'])->name('purchase.store'); //購入処理

//商品送付先変更用
Route::get('/purchase/{item}/address',[PurchaseAddressController::class,'edit']) -> name('purchase.address'); //商品送付先変更画面
Route::put('/purchase/{item}/address', [PurchaseAddressController::class, 'update'])->name('purchase.address.update'); //商品送付先変更処理


//商品出品用
Route::get('/items/create', [ItemsController::class, 'create'])->name('items.sell');//画面表示
Route::post('/items',[ItemsController::class, 'store'])->name('items.store'); //出品機能

//マイページ表示画面
Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage.index');//マイページ画面
});
