<?php

namespace app\common\service;

use app\common\exception\OrdersException;
use app\common\exception\TokenException;
use app\common\model\Orders;
use app\common\traits\ToolTrait;
use think\Config;
use think\Exception;
use think\Log;

require_once "../extend/WxPay/WxPay.Api.php";

/**
 * 支付
 * User: Wei Zeng
 */
class PayService extends BaseService
{
    Use ToolTrait;

    /**
     * 订单 id
     *
     * @var int
     */
    protected $orders_id;

    /**
     * 订单号码
     *
     * @var string
     */
    protected $orders_number;

    /**
     * 订单
     *
     * @var object
     */
    protected $order;

    /**
     * 支付
     *
     * @param int $orders_id 订单 id
     * @return array
     * @throws Exception
     * @throws OrdersException
     * @throws TokenException
     * @throws \WxPayException
     * @throws \think\exception\DbException
     */
    public function pay($orders_id)
    {
        // 检测订单
        $this->checkOrder($orders_id);

        // 检测商品库存
        (new OrdersService())->checkGoodsStockByOrdersId($orders_id);

        // 获取 openid
        $openid = TokenService::getCachedSessionByToken('openid');
        if (empty($openid))
        {
            throw new TokenException();
        }

        // 统一下单
        $unifiedOrder = $this->createUnifiedOrder($openid);

        // 保存 prepay_id
        $this->savePrepayId($unifiedOrder['prepay_id']);

        // 生成签名
        return $this->signatureGenerator($unifiedOrder);
    }

    /**
     * 校验订单
     *
     * @param int $orders_id 订单id
     * @return bool
     * @throws OrdersException
     * @throws TokenException
     * @throws \think\exception\DbException
     */
    protected function checkOrder($orders_id)
    {
        // 获取订单
        $this->order = Orders::get($orders_id);

        // 检测订单是否存在
        if (empty($this->order))
        {
            $config = Config::get('api');
            throw new OrdersException(
                $config['response_message']['order_not_found'],
                $config['response_code']['order_not_found']
            );
        }

        // 检测订单的所属是否匹配
        if (!TokenService::checkUserMatches($this->order->user_id))
        {
            $config = Config::get('api');
            throw new OrdersException(
                $config['response_message']['order_does_not_match'],
                $config['response_code']['order_does_not_match']
            );
        }

        // 检测订单状态
        if ($this->order->orders_state != Config::get('orders.state')['unpaid'])
        {
            $config = Config::get('api');
            throw new OrdersException(
                $config['response_message']['order_paid_error'],
                $config['response_code']['order_paid_error']
            );
        }

        return true;
    }

    /**
     * 统一下单
     *
     * @param $openid
     * @return \成功时返回，其他抛异常
     * @throws \WxPayException
     */
    protected function createUnifiedOrder($openid)
    {
        // 加载配置
        $config = Config::get('payment.wx');

        // 配置
        $wxPayUnifiedOrder = new \WxPayUnifiedOrder();
        // 设置订单号
        $wxPayUnifiedOrder->SetOut_trade_no($this->order->orders_number);
        // 设置交易类型
        $wxPayUnifiedOrder->SetTrade_type('JSAPI');
        // 设置总价格
        $wxPayUnifiedOrder->SetTotal_fee($this->order->orders_total_price);
        // 设置商品描述
        $wxPayUnifiedOrder->SetBody('指尖上的零食');
        // 设置 openid
        $wxPayUnifiedOrder->SetOpenid($openid);
        // 设置支付通知 url
        $wxPayUnifiedOrder->SetNotify_url($config['pay_notify_url']);

        // 统一下单
        $unifiedOrder = \WxPayApi::unifiedOrder($wxPayUnifiedOrder);
        if ($unifiedOrder['return_code'] != 'SUCCESS' || $unifiedOrder['result_code'] != 'SUCCESS')
        {
            Log::write('Unified Order Failed', 'debug');
        }

        return $unifiedOrder;
    }

    /**
     * 保存 prepay_id
     *
     * @param string $prepay_id 预支付交易会话标识
     * @return bool
     * @throws Exception
     */
    protected function savePrepayId($prepay_id)
    {
        $this->order->prepay_id = $prepay_id;
        $result = $this->order->save();
        if (!$result)
        {
            throw new Exception('Save Prepay Id Failed');
        }

        return true;
    }

    // 签名生成器

    /**
     * 签名生成器
     * @param array $unifiedOrder 统一下单
     * @return array
     */
    protected function signatureGenerator($unifiedOrder)
    {
        // 设置
        $config = Config::get('wx.mini_program');
        $wxPayJsPayApi = new \WxPayJsApiPay();
        $wxPayJsPayApi->SetAppid($config['app_id']);
        $wxPayJsPayApi->SetTimeStamp(strval(time()));
        $wxPayJsPayApi->SetNonceStr(self::randomStringGenerator());
        $wxPayJsPayApi->SetPackage(http_build_query(['prepay_id' => $unifiedOrder['prepay_id']]));
        $wxPayJsPayApi->SetSignType($config['sign_type']);

        // 获取设置的数据
        $result = $wxPayJsPayApi->GetValues();

        // 获取签名
        $result['paySign'] = $wxPayJsPayApi->MakeSign();

        // 去掉 app_id
        unset($result['appId']);

        return $result;
    }
}
