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
Route::group(':version/token', function()
{
    // 生成用户 token
    Route::post('/userTokens', 'api/:version.Token/createUserToken');
    // 生成管理员 token
    Route::post('/adminTokens', 'api/:version.Token/createAdminToken');
    // 获取 token 状态
    Route::get('/tokenStates', 'api/:version.Token/userTokenStates');
});

// 收货地址
Route::group(':version/shippingAddresses', function()
{
    // 获取
    Route::get('/', 'api/:version.ShippingAddress/index');
    // 创建
    Route::post('/', 'api/:version.ShippingAddress/create');
    // 更新
    Route::put('/', 'api/:version.ShippingAddress/update');
});

// 订单
Route::group(':version/orders', function()
{
    // 创建订单
    Route::post('/', 'api/:version.Orders/create');
    // 订单列表
    Route::get('/', 'api/:version.Orders/index');
    // 详情
    Route::get('/:id', 'api/:version.Orders/read');
});

// 支付
Route::group(':version/pay', function()
{
    // 统一下单
    Route::post('/unifiedOrders', 'api/:version.Pay/unifiedOrder');
    // 支付通知
    Route::post('/notifies', 'api/:version.Pay/notifies');
});
