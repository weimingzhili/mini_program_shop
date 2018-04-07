<?php

namespace app\common\exception;

use think\Config;
use think\exception\Handle;

/**
 * 异常处理
 * User: Wei Zeng
 */
class ExceptionHandle extends Handle
{
    /**
     * HTTP 状态码
     * @access protected
     * @var int
     */
    protected $httpCode;

    /**
     * 提示信息
     * @access protected
     * @var string
     */
    protected $msg;

    /**
     * 错误状态码
     * @access protected
     * @var int
     */
    protected $errorCode;

    /**
     * 异常接管
     * @access public
     * @param \Exception $exception
     * @return \think\Response|\think\response\Json
     */
    public function render(\Exception $exception)
    {
        // 若属于基础错误
        if ($exception instanceof BaseException)
        {
            $this->httpCode  = $exception->httpCode;
            $this->msg       = $exception->msg;
            $this->errorCode = $exception->errorCode;
        } else {
            // 加载配置
            $config = Config::get('api');

            // 若异常接管开启
            if ($config['exception_handle_switch'])
            {
                $this->httpCode  = $config['http_code']['server_common_error'];
                $this->msg       = $config['error_msg']['server_common_msg'];
                $this->errorCode = $config['error_code']['unknown_error'];
            } else {
                // 还原框架默认异常接管
                return parent::render($exception);
            }
        }

        return json(['msg' => $this->msg, 'errorCode' => $this->errorCode], $this->httpCode);
    }
}
