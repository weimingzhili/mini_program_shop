<?php

namespace app\api\controller\v1;
use app\common\exception\ParameterException;
use app\common\service\OrdersService;
use app\common\service\TokenService;
use think\Request;

/**
 * 订单
 * User: Wei Zeng
 */
class Orders extends BaseController
{
    /**
     * 前置操作
     *
     * @var array
     */
    protected $beforeActionList = [
        'checkOnlyUserScope' => ['only' => ['create']],
    ];

    /**
     * 创建
     *
     * @url /orders 访问 url
     * @http post 请求方式
     * @param Request $request
     * @return \think\response\Json
     * @throws ParameterException
     * @throws \app\common\exception\OrdersException
     * @throws \app\common\exception\TokenException
     * @throws \think\exception\DbException
     */
    public function create(Request $request)
    {
        // 获取参数
        $param = [];
        $param['orders'] = $request->param('orders/a');
        $param['shipping_address_id'] = $request->param('shipping_address_id');

        // 校验参数
        $checkRet = $this->validate($param, 'Orders.create');
        if ($checkRet !== true)
        {
            throw new ParameterException($checkRet);
        }

        // 获取 user_id
        $user_id = TokenService::getCachedSessionByToken('user_id');

        // 创建订单
        $ordersService = new OrdersService();
        $order = $ordersService->order($user_id, $param['shipping_address_id'], $param['orders']);

        return $this->restResponse($order);
    }
}
