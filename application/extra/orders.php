<?php

/**
 * 订单
 * User: Wei Zeng
 */
return [
    // 业务类型
    'business_type' => [
        // 商城订单
        'shop_orders' => 1,
    ],
    // 下单渠道
    'orders_channel' => [
        // 小程序
        'mini_program' => 1,
    ],
    // 支付方式
    'payment_method' => [
        // 微信支付
        'wechat_payment' => 1
    ],
    // 状态
    'state' => [
        // 未支付
        'unpaid' => 1,
        // 已支付
        'paid' => 2,
        // 已发货
        'shipped' => 3,
        // 已支付但库存不足
        'paid_but_stock_shortage' => 4
    ],
];
