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