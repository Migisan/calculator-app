<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * 計算結果ログ
 */
// ログ一覧
Route::get('/logs', 'LogController@index');
// ログ保存
Route::post('/logs/store', 'LogController@store');
// ログ削除
Route::delete('/logs/{id}', 'LogController@delete');

/**
 * その他
 */
// トークンリフレッシュ
Route::get('/reflesh-token', function(Illuminate\Http\Request $request) {
    $request->session()->regenerateToken();
    return response()->json();
});