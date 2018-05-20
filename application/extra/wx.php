<?php

/**
 * 微信
 * User: Wei Zeng
 */
return [
    // 接口地址
    'api_url' => [
        // 获取 access_token
        'get_access_token' => 'https://api.weixin.qq.com/cgi-bin/token',
        // 发送模板消息
        'send_template_message' => 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=ACCESS_TOKEN',
    ],

    // 小程序
    'mini_program' => [
        // appId
        'app_id' => 'wx19a786a491302bee',
        // 密钥
        'app_secret' => 'd6d959f6b92022ba184d66e7d3d80588',
        // appKey
        'app_key' => '',
        // 签名类型
        'sign_type' => 'md5',

        // 模板消息
        'template_message' => [
            // 发货
            'ship' => 'sb8k7JNobjBh6Vbo7HD4zEr0CGR8CsYQwzXHxQFxMO8',
        ]
    ]
];
