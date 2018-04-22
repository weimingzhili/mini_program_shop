<?php

namespace app\common\traits;

use think\Config;
use think\Response;

/**
 * 响应
 * User: Wei Zeng
 */
trait ResponseTrait
{
    /**
     * RESTful Api 响应
     * @param mixed $data 数据
     * @param string $message 消息提示
     * @param int $httpCode http 状态码
     * @param array $header header 设置
     * @return \think\response\Json
     */
    public function restResponse($data, $message = '', $httpCode = 200, array $header = [])
    {
        // 合并
        $message = !empty($message) ? $message : (Config::get('api.response_message'))['common_success'];

        return Response::create(
            ['message' => $message, 'data' => $data],
            'json', $httpCode, $header
        );
    }
}
