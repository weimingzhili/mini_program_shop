<?php

namespace app\api\controller\v1;

use app\common\exception\NotFoundException;
use app\common\exception\ParameterException;
use app\common\exception\TokenException;
use app\common\model\ShippingAddress as ShippingAddressModel;
use app\common\model\ShippingAddress;
use app\common\model\User;
use app\common\logic\TokenLogic;
use think\Config;
use think\Exception;
use think\Request;

/**
 * 收货地址
 * User: Wei Zeng
 */
class ShippingAddressController extends Base
{
    /**
     * 前置操作
     *
     * @var array
     */
    protected $beforeActionList = [
        'checkUserScope' => ['only' => ['index', 'create', 'update']],
    ];

    /**
     * 列表
     *
     * @url /shippingAddress 访问 url
     * @http get 请求方式
     * @return \think\response\Json
     * @throws NotFoundException
     * @throws TokenException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 获取用户 id
        $user_id = TokenLogic::getSessionUserId();
        if (empty($user_id))
        {
            throw new TokenException();
        }

        // 获取
        $shippingAddresses = ShippingAddress::getByUserId($user_id);

        return $this->restResponse($shippingAddresses);
    }

    /**
     * 创建收货地址
     *
     * @url /shippingAddresses 访问 url
     * @http post 请求方式
     * @param Request $request 实例
     * @return \think\response\Json
     * @throws Exception
     * @throws NotFoundException
     * @throws ParameterException
     * @throws TokenException
     * @throws \think\exception\DbException
     */
    public function create(Request $request)
    {
        // 获取参数
        $param = $request->only([
            'consignee_name', 'consignee_phone', 'province_name',
            'province_code', 'city_name', 'city_code', 'area_name',
            'area_code', 'street_name', 'street_code', 'detailed_address',
            'address_type'
        ]);

        // 校验参数
        $checkRet = $this->validate($param, 'ShippingAddress.create');
        if ($checkRet !== true)
        {
            throw new ParameterException($checkRet);
        }

        // 获取用户 id
        $user_id = TokenLogic::getSessionUserId();
        if (empty($user_id))
        {
            throw new TokenException();
        }

        // 保存
        $shippingAddressModel = new ShippingAddress();
        $result = $shippingAddressModel->saveByUserId($user_id, $param);
        if ($result === false)
        {
            throw new Exception('Shipping Address Created Failed');
        }

        $config = Config::get('api');
        return $this->restResponse(
            $result,
            $config['response_code']['common_success'],
            $config['response_message']['common_success'],
            $config['http_code']['create_success']
        );
    }

    /**
     * 更新
     *
     * @url /shippingAddresses 访问 url
     * @http put 请求方式
     * @param Request $request Request 实例
     * @return \think\response\Json
     * @throws Exception
     * @throws NotFoundException
     * @throws ParameterException
     * @throws \app\common\exception\TokenException
     * @throws \think\exception\DbException
     */
    public function update(Request $request)
    {
        // 获取参数
        $param = $request->only([
            'id', 'consignee_name', 'consignee_phone', 'province_name',
            'province_code', 'city_name', 'city_code', 'area_name',
            'area_code', 'street_name', 'street_code', 'detailed_address'
        ]);

        // 校验参数
        $checkRet = $this->validate($param, 'ShippingAddress.update');
        if ($checkRet !== true)
        {
            throw new ParameterException($checkRet);
        }

        // 获取用户
        $user_id = TokenLogic::getSessionUserId();
        $user = User::get($user_id);
        if (empty($user))
        {
            throw new NotFoundException('User Not Found');
        }

        // 更新
        $shippingAddressModel = new ShippingAddressModel();
        $result = $shippingAddressModel->updateByIdAndUserId( $param['id'], $user_id, $param);
        if ($result === false)
        {
            throw new Exception('Shipping Address Updated Failed');
        }

        $config = Config::get('api');
        return $this->restResponse(
            $result,
            $config['response_code']['common_success'],
            $config['response_message']['common_success'],
            $config['http_code']['update_success']
        );
    }
}
