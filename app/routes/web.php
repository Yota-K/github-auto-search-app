<?php

use Illuminate\Support\Facades\Route;

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

// トップページ
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

// 管理画面
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
  Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin');

  // 検索キーワードの編集関連
  Route::resource('/keyword', \App\Http\Controllers\Admin\KeywordGroupController::class)->except(['index', 'show']);
});
