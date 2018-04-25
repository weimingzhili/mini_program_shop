<?php

namespace app\common\exception;
use think\Config;
use Throwable;

/**
 * 拒绝访问
 * User: Wei Zeng
 */
class ForbiddenException extends BaseException
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
        $this->httpCode  = $config['http_code']['forbidden'];
        $this->message   = !empty($message) ? $message : $config['response_message']['forbidden'];
        $this->state     = !empty($code) ? $code : $config['response_code']['forbidden'];
    }
}
