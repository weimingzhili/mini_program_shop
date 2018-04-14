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
Route::resource(':version/goods', 'api/:version.Goods', ['only' => ['index']]);
