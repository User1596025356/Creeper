<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});


Route::get('api/:version/getProductsInfo',':version.Products/getProductsInfo');
Route::get('api/:version/banner',':version.Banner/getBanner');
Route::get('api/:version/getRecentProduct',':version.Product/getRecent');
Route::rule('webhook','Webhook/githook');
Route::post('api/:version/token/user',':version.Token/getToken');
Route::get('api/:version/testToken',':version.Test/testToken');
Route::get('api/:version/productdetail','api/:version.Product/getOne');
Route::post('api/:version/addProduct','api/:version.Product/addOne');
Route::post('api/:version/upload','api/:version.Product/upload');
Route::get('api/:version/loadcomment','api/:version.Comment/getComments');
Route::post('api/:version/addcomment','api/:version.Comment/addComment');