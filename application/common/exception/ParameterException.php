<?php

namespace app\common\exception;

/**
 * 参数错误
 * User: Wei Zeng
 */
class ParameterException extends BaseException
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
}
