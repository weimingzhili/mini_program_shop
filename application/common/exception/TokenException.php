<?php

namespace app\common\exception;

use think\Config;
use Throwable;

/**
 * token 错误
 * User: Wei Zeng
 */
class TokenException extends BaseException
{
    /**
     * 初始化
     * @param string $message 错误信息
     * @param int $code 错误状态码
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        // 父类初始化
        parent::__construct($message, $code, $previous);

        // 加载配置
        $config         = Config::get('api');
        $this->httpCode = $config['http_code']['token_error'];
        $this->message  = $message ? : $config['response_message']['token_error'];
        $this->state = $code ? : $config['response_code']['token_error'];
    }
}
