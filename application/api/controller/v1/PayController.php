<?php

namespace app\api\controller\v1;
use app\common\exception\ParameterException;
use app\common\logic\PayLogic;
use app\common\logic\WxNotifyLogic;
use think\Request;

/**
 * 支付
 * User: Wei Zeng
 */
class PayController extends Base
{
    /**
     * 前置操作
     *
     * @var array
     */
    protected $beforeActionList = [
        'checkOnlyUserScope' => ['only' => ['unifiedOrder']],
    ];

    /**
     * 统一下单
     *
     * @url /pay/unifiedOrders 访问 url
     * @http post 请求方式
     * @param Request $request Request 实例
     * @return \think\response\Json
     * @throws ParameterException
     * @throws \WxPayException
     * @throws \app\common\exception\OrdersException
     * @throws \app\common\exception\TokenException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function unifiedOrder(Request $request)
    {
        // 获取参数
        $param = [];
        $param['orders_id'] = $request->param('orders_id');

        // 验证
        $checkRet = $this->validate($param, 'Pay.unifiedOrder');
        if ($checkRet !== true)
        {
            throw new ParameterException($checkRet);
        }

        // 统一下单
        $payLogic = new PayLogic();
        $unifiedOrder = $payLogic->pay($param['orders_id']);

        return $this->restResponse($unifiedOrder);
    }

    /**
     * 支付通知
     */
    public function notifies()
    {
        (new WxNotifyLogic())->Handle();
    }
}
