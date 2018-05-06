<?php

namespace app\api\controller\v1;
use app\common\exception\ParameterException;
use app\common\model\Orders;
use app\common\service\OrdersService;
use app\common\service\TokenService;
use think\Config;
use think\Request;

/**
 * 订单
 * User: Wei Zeng
 */
class OrdersController extends Base
{
    /**
     * 前置操作
     *
     * @var array
     */
    protected $beforeActionList = [
        'checkOnlyUserScope' => ['only' => ['create', 'index']],
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

    /**
     * 列表
     *
     * @url /orders 访问 url
     * @http get 请求方式
     * @param Request $request Request 实例
     * @return \think\response\Json
     * @throws ParameterException
     * @throws \app\common\exception\TokenException
     * @throws \think\exception\DbException
     */
    public function index(Request $request)
    {
        // 获取参数
        $param = [];
        $param['page'] = $request->param('page', 1);
        $param['pageSize'] = $request->param('pageSize', Config::get('paginate.list_rows'));

        // 验证参数
        $checkRet = $this->validate($param, 'Orders.index');
        if ($checkRet !== true)
        {
            throw new ParameterException($checkRet);
        }

        // 获取用户 id
        $user_id = TokenService::getSessionUserId();

        // 获取分页数据
        $paginates = Orders::getPaginateByUserId($user_id, $param['page'], $param['pageSize']);
        $result = [
            'current_page' => $paginates->getCurrentPage(),
            'list' => []
        ];
        if (!$paginates->isEmpty())
        {
            $result['list'] = $paginates->toArray()['data'];
        }

        return $this->restResponse($result);
    }
}
