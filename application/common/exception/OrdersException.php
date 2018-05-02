<?php

namespace app\common\exception;
use think\Config;
use Throwable;

/**
 * 订单异常
 * User: Wei Zeng
 */
class OrdersException extends BaseException
{
    /**
     * 初始化
     * @param string $message 错误信息
     * @param int $code 响应状态码
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        // 父类初始化
        parent::__construct($message, $code, $previous);

        // 加载配置
        $config          = Config::get('api');
        $this->httpCode = $config['http_code']['client_common_error'];
        $this->message = !empty($message) ? $message : $config['response_message']['order_common_error'];
        $this->state = !empty($code) ? $code : $config['response_code']['order_common_error'];
    }
}
