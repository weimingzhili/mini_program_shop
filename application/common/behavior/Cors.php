<?php

namespace app\common\behavior;

use think\Request;

/**
 * 跨域
 * User: Wei Zeng
 */
class Cors
{
    public function appInit(&$params)
    {
        // 设置 header
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: token,Origin, X-Requested-With,Content-Type,Accept');
        header('Access-Control-Allow-Methods: POST,GET');

        // 若是 options 请求
        if (Request::instance()->isOptions())
        {
            exit();
        }
    }
}
