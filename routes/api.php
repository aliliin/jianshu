<?php

use Illuminate\Http\Request;

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
/*
 * 尽量不要用匿名函数来写路由，这样子生成路由缓存文件会报错。
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
 */