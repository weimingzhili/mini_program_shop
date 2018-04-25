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
        'token_error' => 401,
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
        // 通用性成功
        'common_success' => 0,
        // 客户端通用错误
        'client_common_error' => 1000,
        // 参数校验错误
        'parameter_error' => 1001,
        // 资源不存在
        'resource_not_found' => 1002,
        // token 错误
        'token_error' => 2000,
        // 鉴权错误
        'forbidden' => 3000,
        // 服务器通用错误
        'server_common_error' => 4000,
    ],
    // 响应信息
    'response_message' => [
        // 通用成功
        'common_success' => 'Success',
        // 客户端通用错误信息
        'client_common_error' => 'Bad Request',
        // 参数错误
        'parameter_error' => 'Parameter Error',
        // 资源不存在
        'resource_not_found' => 'Resource Not Found',
        // token 错误
        'token_error' => 'Token Invalid',
        // 拒绝访问
        'forbidden' => 'Forbidden',
        // 服务器通用错误信息
        'server_common_error' => 'Unknown Error',
    ],
];
