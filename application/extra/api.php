<?php

/**
 * api 配置
 * User: Wei Zeng
 */
return [
    // 异常接管开关
    'exception_handle_switch' => true,

    // HTTP 状态码
    'http_code' => [
        // 获取成功
        'get_success' => 200,
        // 创建成功
        'create_success' => 201,
        // 更新成功
        'update_success' => 202,
        // 删除成功
        'delete_success' => 204,
        // 客户端通用错误
        'client_common_error' => 400,
        // token 错误
        'token_common_error' => 401,
        // 拒绝访问
        'forbidden' => 403,
        // 资源不存在
        'resource_not_found' => 404,
        // 校验错误
        'unprocessable_entity' => 422,
        // 服务器通用错误
        'server_common_error' => 500,
    ],
    // 响应状态码
    'response_code' => [
        // ------- 非业务 -------

        // 通用性成功
        'common_success' => 0,
        // 客户端通用错误
        'client_common_error' => 1000,
        // 参数校验错误
        'parameter_error' => 1001,
        // 资源不存在
        'resource_not_found' => 1002,
        // token 通用错误
        'token_common_error' => 1100,
        // token 不能为空
        'token_cannot_be_empty' => 1101,
        // 鉴权错误
        'forbidden' => 1200,
        // 服务器通用错误
        'server_common_error' => 2000,
        // 系统繁忙
        'system_busy_error' => 2001,

        // ------- 业务 -------

        // 订单通用错误
        'order_common_error' => 3100,
        // 订单商品不存在
        'order_goods_not_found' => 3101,
        // 订单库存不足
        'order_insufficient_inventory' => 3102,
        // 订单收货地址不存在
        'order_shipping_address_not_found' => 3103,
        // 订单收货地址拥有者错误
        'order_shipping_address_owner_error' => 3104,
        // 订单创建失败
        'order_creation_failed' => 3105,
        // 订单不存在
        'order_not_found' => 3106,
        // 订单不匹配
        'order_does_not_match' => 3107,
        // 订单已支付
        'order_paid_error' => 3108,
    ],
    // 响应信息
    'response_message' => [
        // ------- 非业务 -------

        // 通用成功
        'common_success' => 'Success',
        // 客户端通用错误信息
        'client_common_error' => 'Bad Request',
        // 参数错误
        'parameter_error' => 'Parameter Error',
        // 资源不存在
        'resource_not_found' => 'Resource Not Found',
        // token 通用错误
        'token_common_error' => 'Token Invalid',
        // token 不能为空
        'token_cannot_be_empty' => 'Token Cannot Be Empty',
        // 拒绝访问
        'forbidden' => 'Forbidden',
        // 服务器通用错误信息
        'server_common_error' => 'Unknown Error',
        // 系统繁忙
        'system_busy_error' => 'System Is Busy',

        // ------- 业务 -------

        // 订单通用错误
        'order_common_error' => 'Order Error',
        // 订单商品不存在
        'order_goods_not_found' => 'Order Goods Not Found',
        // 订单库存不足
        'order_insufficient_inventory' => 'Order Insufficient Inventory',
        // 订单收货地址不存在
        'order_shipping_address_not_found' => 'Order Shipping Address Not Found',
        // 订单收货地址拥有者错误
        'order_shipping_address_owner_error' => 'Order Shipping Address Owner Error',
        // 订单创建失败
        'order_creation_failed' => 'Order Creation Failed',
        // 订单不存在
        'order_not_found' => 'Order Not Found',
        // 订单不匹配
        'order_does_not_match' => 'Order Does Not Match',
        // 订单已支付
        'order_paid_error' => 'Order Paid',
    ],
];
