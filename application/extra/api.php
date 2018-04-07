<?php

/**
 * api 配置
 * User: Wei Zeng
 */
return [
    // HTTP 状态码
    'http_code' => [
        // 客户端通用错误
        'client_common_error' => 400,
        // 服务器通用错误
        'server_common_error' => 500,
    ],
    // 错误状态码
    'error_code' => [
        // 通用性错误
        'common_error' => 1000,
        // 签名错误
        'sign_error' => 2000,
        // 鉴权错误
        'access_error' => 3000,
        // 未知错误
        'unknown_error' => 4000,
    ],
    // 错误信息
    'error_msg' => [
        // 客户端通用错误信息
        'client_common_msg' => 'Request Invalid',
        // 服务器通用错误信息
        'server_common_msg' => 'Unknown Error',
    ],
    // 内部错误接管开关
    'exception_handle_switch' => true,
];
