<?php

namespace app\common\service;

use think\Config;
use think\Request;
use app\common\traits\ToolTrait;

/**
 * 基类
 * User: Wei Zeng
 */
class BaseService
{
    use ToolTrait;

    /**
     * 生成 token
     *
     * @return string
     */
    public static function generateToken()
    {
        // 获取随机字符串
        $randString = self::randomStringGenerator(16);

        // 获取请求时间戳
        $request = Request::instance();
        $requestTimestamp = $request->server('REQUEST_TIME_FLOAT');

        // 读取 token salt
        $tokenSalt = Config::get('secure.token_salt');

        return md5($randString . $requestTimestamp . $tokenSalt);
    }
}
