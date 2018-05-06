<?php

namespace app\common\service;

use app\common\exception\OrdersException;
use app\common\model\Goods;
use app\common\model\Orders;
use app\common\model\OrdersSnapshot;
use app\common\model\ShippingAddress;
use think\Config;
use think\Db;
use think\Log;

/**
 * 订单
 * User: Wei Zeng
 */
class OrdersService extends BaseService
{
    /**
     * 用户 id
     *
     * @var int
     */
    protected $user_id;

    /**
     * 订单商品总数
     *
     * @var int
     */
    protected $ordersGoodsTotal = 0;

    /**
     * 订单总价
     *
     * @var int
     */
    protected $ordersTotalPrice = 0;

    /**
     * 下单
     *
     * @param int $user_id 用户id
     * @param int $shipping_address_id 收货地址id
     * @param array $orderData 订单数据
     * @return Orders
     * @throws OrdersException
     * @throws \think\exception\DbException
     */
    public function order($user_id, $shipping_address_id, $orderData)
    {
        // 赋值
        $this->user_id = $user_id;

        // 生成订单快照
        $goodsSnapshot = $this->ordersSnapshotGenerator($orderData);

        // 获取收货地址快照
        $shippingAddressSnapshot = $this->getShippingAddressSnapshot($shipping_address_id);

        // 生成订单号码
        $orders_number = $this->ordersNumberGenerator();

        // 创建订单
        return $this->createOrders($goodsSnapshot, $shippingAddressSnapshot, $orders_number);
    }

    /**
     * 根据订单获取商品
     *
     * @param array $orderData 订单数据
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function getGoodsByOrders($orderData)
    {
        // 获取订单中的商品 id
        $orderGoodsIds = [];
        foreach ($orderData as $data)
        {
            $orderGoodsIds[] = $data['goods_id'];
        }

        // 查询
        $goods = Goods::all(function($query) use ($orderGoodsIds)
        {
            $query->whereIn('id', $orderGoodsIds)
                ->field(['id', 'goods_price', 'goods_stock','goods_title', 'main_image_url', 'image_source']);
        });

        // 追加主图完整路径
        $goods->each(function($item)
        {
            $item->append(['mainImageFullUrl']);
        });

        return $goods->toArray();
    }

    /**
     * 订单快照生成器
     *
     * @param array $orderData 订单数据
     * @return array
     * @throws OrdersException
     * @throws \think\exception\DbException
     */
    protected function ordersSnapshotGenerator($orderData)
    {
        // 查询商品信息
        $goods = $this->getGoodsByOrders($orderData);

        // 遍历处理
        $ordersSnapShot = [];
        foreach ($orderData as $key => $value)
        {
            // 判断商品是否存在
            if (empty($goods[$key]))
            {
                $config = Config::get('api');
                throw new OrdersException(
                    $config['response_message']['order_goods_not_found'],
                    $config['response_code']['order_goods_not_found']
                );
            }

            // 获取商品快照
            $ordersSnapShot[] = $this->getGoodsSnapshot($value, $goods[$key]);
            // 累计订单数量、金额
            $this->ordersGoodsTotal += $value['quantity'];
            $this->ordersTotalPrice += $ordersSnapShot[$key]['snapshot_total_price'];
        }

        return $ordersSnapShot;
    }

    /**
     * 获取商品快照
     *
     * @param array $orderGoods 订单商品数据
     * @param array $goods 数据库商品数据
     * @return array
     * @throws OrdersException
     */
    protected function getGoodsSnapshot($orderGoods, $goods)
    {
        // 检测商品库存
        $this->checkGoodsStock($orderGoods, $goods);

        return [
            'goods_id' => $orderGoods['goods_id'],
            'snapshot_goods_title' => $goods['goods_title'],
            'snapshot_goods_price' => $goods['goods_price'],
            'snapshot_main_image' => $goods['mainImageFullUrl'],
            'snapshot_goods_quantity' => $orderGoods['quantity'],
            'snapshot_total_price' => $orderGoods['quantity'] * $goods['goods_price']
        ];
    }

    /**
     * 检测商品库存
     *
     * @param $orderGoods
     * @param $goods
     * @return bool
     * @throws OrdersException
     */
    public function checkGoodsStock($orderGoods, $goods)
    {
        if ($goods['goods_stock'] < $orderGoods['quantity'])
        {
            $config = Config::get('api');
            throw new OrdersException(
                $config['response_message']['order_insufficient_inventory'],
                $config['response_code']['order_insufficient_inventory']
            );
        }

        return true;
    }

    /**
     * 根据订单 id 检测商品库存
     *
     * @param $orders_id
     * @return bool
     * @throws OrdersException
     * @throws \think\exception\DbException
     */
    public function checkGoodsStockByOrdersId($orders_id)
    {
        // 获取订单商品
        $ordersGoods = OrdersSnapshot::all(function($query) use ($orders_id)
        {
            $query->where('orders_id', $orders_id)
                ->field([
                    'goods_id',
                    'snapshot_goods_quantity' => 'quantity'
                ]);
        })
            ->toArray();

        // 获取数据库商品信息
        $goods = $this->getGoodsByOrders($ordersGoods);

        foreach ($ordersGoods as $key => $value)
        {
            // 判断商品是否存在
            if (empty($goods[$key]))
            {
                $config = Config::get('api');
                throw new OrdersException(
                    $config['response_message']['order_goods_not_found'],
                    $config['response_code']['order_goods_not_found']
                );
            }

            $this->checkGoodsStock($value, $goods[$key]);
        }

        return true;
    }

    /**
     * 获取收货地址快照
     *
     * @param int $shipping_address_id 收货地址 id
     * @return array
     * @throws OrdersException
     * @throws \think\exception\DbException
     */
    protected function getShippingAddressSnapshot($shipping_address_id)
    {
        // 查询
        $shippingAddress = ShippingAddress::get($shipping_address_id);
        if (empty($shippingAddress))
        {
            $config = Config::get('api');
            throw new OrdersException(
                $config['response_message']['order_shipping_address_not_found'],
                $config['response_code']['order_shipping_address_not_found']
            );
        }

        // 校验所属
        if ($shippingAddress->user_id != $this->user_id)
        {
            $config = Config::get('api');
            throw new OrdersException(
                $config['response_message']['order_shipping_address_owner_error'],
                $config['response_code']['order_shipping_address_owner_error']
            );
        }

        return [
            'shipping_address_id' => $shippingAddress->id,
            'snapshot_consignee_name' => $shippingAddress->consignee_name,
            'snapshot_consignee_phone' => $shippingAddress->consignee_phone,
            'snapshot_shipping_address' => $shippingAddress->province_name . $shippingAddress->city_name . $shippingAddress->area_name . $shippingAddress->street_name . $shippingAddress->detailed_address,
        ];
    }

    /**
     * 生成订单号码
     *
     * @return string
     */
    public function ordersNumberGenerator()
    {
        // 加载配置
        $config = Config::get('orders');

        return $config['business_type']['shop_orders'] . $config['orders_channel']['mini_program'] . $config['payment_method']['wechat_payment'] . sprintf('%02s', substr($this->user_id, -1, 2)) . date('ymd') . mt_rand(100, 999);
    }

    /**
     * 创建订单
     *
     * @param array $goodsSnapshot 商品快照
     * @param array $shippingAddressSnapshot 收货地址快照
     * @param string $orders_number 订单号码
     * @return Orders
     * @throws OrdersException
     */
    protected function createOrders($goodsSnapshot, $shippingAddressSnapshot, $orders_number)
    {
        // 开启事务
        Db::startTrans();

        try
        {
            // 创建订单
            $order = Orders::create([
                'orders_number' => $orders_number,
                'user_id' => $this->user_id,
                'orders_goods_total' => $this->ordersGoodsTotal,
                'orders_total_price' => $this->ordersTotalPrice,
                'shipping_address_id' => $shippingAddressSnapshot['shipping_address_id'],
                'snapshot_consignee_name' => $shippingAddressSnapshot['snapshot_consignee_name'],
                'snapshot_consignee_phone' => $shippingAddressSnapshot['snapshot_consignee_phone'],
                'snapshot_shipping_address' => $shippingAddressSnapshot['snapshot_shipping_address']
            ]);
            if (empty($order))
            {
                // 回滚
                Db::rollback();

                $config = Config::get('api');
                throw new OrdersException(
                    $config['response_message']['order_creation_failed'], $config['response_code']['order_creation_failed']
                );
            }

            // 保存商品快照
            $saveRet = $order->ordersSnapshots()->saveAll($goodsSnapshot);
            if ($saveRet === false)
            {
                // 回滚
                Db::rollback();

                $config = Config::get('api');
                throw new OrdersException(
                    $config['response_message']['order_creation_failed'], $config['response_code']['order_creation_failed']
                );
            }

            // 提交
            Db::commit();

            return $order;
        } catch (\Exception $exception)
        {
            // 回滚
            Db::rollback();

            Log::write('Unified Order Created Failed: ' . $exception->getMessage());

            $config = Config::get('api');
            throw new OrdersException(
                $config['response_message']['order_creation_failed'], $config['response_code']['order_creation_failed']
            );
        }
    }
}
