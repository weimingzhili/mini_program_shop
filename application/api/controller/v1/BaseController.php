<?php

namespace app\api\controller\v1;
use think\Controller;
use app\common\traits\ResponseTrait;
use think\Response;

/**
 * 基类
 * User: Wei Zeng
 */
class BaseController extends Controller
{
    use ResponseTrait;

    protected function responses($data, $message, $httpCode)
    {
        return Response::create();
    }

    /**
     * 输出返回数据
     * @access protected
     * @param mixed     $data 要返回的数据
     * @param String    $type 返回类型 JSON XML
     * @param integer   $code HTTP状态码
     * @return Response
     */
    protected function response($data, $type = 'json', $code = 200)
    {
        return Response::create($data, $type)->code($code);
    }
}
