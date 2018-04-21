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

use think\Route;

// banner
Route::resource(':version/bannerItems', 'api/:version.Banner', ['only' => ['read']]);

// 专题
Route::resource(':version/topics', 'api/:version.Topic', ['only' => ['index', 'read']]);

// 商品
Route::group(':version/goods', function() {
    // 最近商品
    Route::get('/latestGoods', 'api/:version.Goods/latestGoods');
    // 分类商品
    Route::get('/categoryGoods', 'api/:version.Goods/categoryGoods');
    // 商品详情
    Route::get('/:id', 'api/:version.Goods/read');
});

// 分类
Route::resource(':version/categories', 'api/:version.Category', ['only' => ['index']]);

// token
Route::post(':version/token/users', 'api/:version.Token/create');
