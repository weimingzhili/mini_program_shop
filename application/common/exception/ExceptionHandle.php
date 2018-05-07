<?php

namespace app\common\exception;

use app\common\traits\ResponseTrait;
use think\Config;
use think\exception\Handle;

/**
 * 异常处理
 * User: Wei Zeng
 */
class ExceptionHandle extends Handle
{
    use ResponseTrait;

    /**
     * HTTP 状态码
     *
     * @var int
     */
    protected $httpCode;

    /**
     * 响应消息
     *
     * @var string
     */
    protected $message;

    /**
     * 响应状态码
     *
     * @var int
     */
    protected $state;

    /**
     * 异常接管
     *
     * @access public
     * @param \Exception $exception
     * @return \think\Response|\think\response\Json
     */
    public function render(\Exception $exception)
    {
        // 若属于基础错误
        if ($exception instanceof BaseException)
        {
            $this->httpCode = $exception->httpCode;
            $this->message  = $exception->message;
            $this->state    = $exception->state;
        } else {
            // 加载配置
            $config = Config::get('api');

            // 若异常接管开启
            if ($config['exception_handle_switch'])
            {
                $this->httpCode  = $config['http_code']['server_common_error'];
                $this->message       = $config['response_message']['server_common_error'];
                $this->state = $config['response_code']['server_common_error'];
            } else {
                // 还原框架默认异常接管
                return parent::render($exception);
            }
        }

        return $this->restResponse(
            new \stdClass(), $this->state,
            $this->message, $this->httpCode
        );
    }
}
