<?php

namespace app\api\controller\v1;
use app\common\exception\OrdersException;
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
        'checkOnlyUserScope' => ['only' => ['create', 'userOrders']],
        'checkUserScope' => ['only' => ['read', 'index']],
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
        $param['order'] = $request->param('order/a');
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
        $order = $ordersService->order($user_id, $param['shipping_address_id'], $param['order']);

        $apiConfig = Config::get('api');
        return $this->restResponse(
            $order,
            $apiConfig['response_code']['common_success'],
            $apiConfig['response_message']['common_success'],
            $apiConfig['http_code']['create_success']
        );
    }

    /**
     * 用户订单列表
     *
     * @url /orders 访问 url
     * @http get 请求方式
     * @param Request $request Request 实例
     * @return \think\response\Json
     * @throws ParameterException
     * @throws \app\common\exception\TokenException
     * @throws \think\exception\DbException
     */
    public function userOrders(Request $request)
    {
        // 获取参数
        $param = [];
        $param['page'] = $request->param('page', 1);
        $param['pageSize'] = $request->param('pageSize', Config::get('paginate.list_rows'));

        // 验证参数
        $checkRet = $this->validate($param, 'Orders.userOrders');
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

    /**
     * 详情
     *
     * @url /orders/:id 访问 url
     * @http get 请求方式
     * @param Request $request
     * @return \think\response\Json
     * @throws OrdersException
     * @throws ParameterException
     * @throws \think\exception\DbException
     */
    public function read(Request $request)
    {
        // 获取参数
        $param = [];
        $param['id'] = $request->param('id');

        // 校验参数
        $checkRet = $this->validate($param, 'Orders.read');
        if ($checkRet !== true)
        {
            throw new ParameterException($checkRet);
        }

        // 获取
        $order = Orders::getOrderById($param['id']);
        if (empty($order))
        {
            $apiConfig = Config::get('api');
            throw new OrdersException(
                $apiConfig['response_message']['order_not_found'],
                $apiConfig['response_code']['order_not_found']
            );
        }

        return $this->restResponse($order);
    }

    /**
     * 列表
     *
     * @param Request $request Request 实例
     * @return \think\response\Json
     * @throws ParameterException
     * @throws \think\exception\DbException
     */
    public function index(Request $request)
    {
        // 获取参数
        $param = [];
        $param['page'] = $request->param('page', 1);
        $param['pageSize'] = $request->param('pageSize', Config::get('paginate.list_rows'));

        // 校验参数
        $checkRet = $this->validate($param, 'Orders.index');
        if ($checkRet !== true)
        {
            throw new ParameterException($checkRet);
        }

        // 获取
        $paginates = Orders::getPaginates($param['page'], $param['pageSize']);
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
