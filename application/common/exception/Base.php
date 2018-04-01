<?php

namespace app\common\exception;
use think\Config;
use Throwable;

/**
 * 基础异常
 * User: Wei Zeng
 */
class Base extends \Exception
{
    /**
     * HTTP 状态码
     * @access public
     * @var int
     */
    public $httpCode;

    /**
     * 提示信息
     * @access public
     * @var string
     */
    public $msg;

    /**
     * 错误状态码
     * @access public
     * @var int
     */
    public $errorCode;

    /**
     * 初始化
     * @access public
     * @param string $message 错误信息
     * @param int $code 错误状态码
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        // 父类初始化
        parent::__construct($message, $code, $previous);

        // 加载配置
        $config          = Config::get('api');
        $this->httpCode  = $config['http_code']['client_common_error'];
        $this->msg       = $message ? : $config['error_msg']['client_common_msg'];
        $this->errorCode = $code ? : $config['error_code']['common_error'];
    }
}
