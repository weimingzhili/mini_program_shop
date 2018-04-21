<?php

/**
 * 微信
 * User: Wei Zeng
 */
return [
    // 小程序
    'mini_program' => [
        // AppID
        'app_id' => 'wx19a786a491302bee',
        // AppSecret
        'app_secret' => 'd6d959f6b92022ba184d66e7d3d80588',
        // 请求主机
        'api_host' => 'api.weixin.qq.com',
        // 接口地址
        'api_urls' => [
            // 登录凭证校验
            'get_session_by_code' => '/sns/jscode2session',
        ],
    ],
];
