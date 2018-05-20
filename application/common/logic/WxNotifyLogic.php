<?php

namespace app\common\logic;

use app\common\exception\OrdersException;
use app\common\model\Orders;
use app\common\model\OrdersSnapshot;
use think\Config;
use think\Db;
use think\Exception;
use think\Log;

require_once "../extend/WxPay/WxPay.Api.php";
require_once "../extend/WxPay/WxPay.Notify.php";

/**
 * 微信支付通知处理
 * User: Wei Zeng
 */
class WxNotifyLogic extends \WxPayNotify
{
    /**
     * 回调处理
     *
     * @param array $data 通知参数
     * @param string $msg 通知消息
     * @return bool|\true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
     */
    public function NotifyProcess($data, &$msg)
    {
        // 判断支付结果
        if ($data['result_code'] != 'SUCCESS')
        {
            // 开启事务
            Db::startTrans();

            try
            {
                // 查询订单
                $order = Orders::get(['orders_number' => $data['out_trade_no']]);
                if (empty($order))
                {
                    Log::write('Order Not Found');
                    return true;
                }
                if ($order->orders_state != 1)
                {
                    Log::write('Order State Exception');
                    return true;
                }

                // 读取订单状态配置
                $orderState = Config::get('orders.state');

                try
                {
                    // 检测库存量
                    (new OrdersLogic())->checkGoodsStockByOrdersId($order->id);
                    // 更新订单
                    $this->updateOrderState($order->id, $orderState['paid']);
                } catch(OrdersException $ordersException)
                {
                    $errorMessage = $ordersException->getMessage();
                    Log::write($errorMessage, 'debug');

                    // 更新订单
                    $this->updateOrderState($order->id, $orderState['paid_but_stock_shortage']);

                    throw new OrdersException($ordersException->state, $errorMessage);
                }

                // 扣减库存
                $this->deductInventory($order->id);

                // 提交
                Db::commit();

                return true;
            } catch (Exception $exception)
            {
                // 回滚
                Db::rollback();

                Log::write('Notify Failed: ' . $exception->getMessage(), 'debug');

                return false;
            }
        }

        return true;
    }

    /**
     * 更新订单状态
     *
     * @param Orders $order 订单
     * @param int $orders_state 订单状态
     * @return bool
     * @throws Exception
     */
    protected function updateOrderState($order, $orders_state)
    {
        $order->orders_state = $orders_state;
        $result = $order->save();
        if ($result === false)
        {
            throw new Exception('Order State Updated Failed');
        }

        return true;
    }

    /**
     * 扣减库存
     *
     * @param int $orders_id 订单id
     * @throws \think\exception\DbException
     */
    protected function deductInventory($orders_id)
    {
        // 获取订单快照
        $ordersSnapshot = OrdersSnapshot::all(function ($query) use ($orders_id)
        {
            $query->with('goods')->where(['orders_id' => $orders_id]);
        });
        if (empty($ordersSnapshot))
        {
            Log::write('Order Snapshot Not Found', 'debug');
        }

        // 遍历扣减
        $ordersSnapshot->each(function($item)
        {
            $item->goods->setDec('goods_stock', $item->snapshot_goods_quantity);
        });
    }
}
