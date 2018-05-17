<?php

namespace app\common\model;

/**
 * 订单
 * User: Wei Zeng
 */
class Orders extends BaseModel
{
    /**
     * 隐藏字段
     *
     * @var array
     */
    protected $hidden = ['update_time', 'delete_time'];

    /**
     * 与 OrdersSnapShot model 的关联
     *
     * @return \think\model\relation\HasMany
     */
    public function ordersSnapshots()
    {
        return $this->hasMany(OrdersSnapshot::class, 'orders_id', $this->pk);
    }

    /**
     * 根据用户 id 获取分页列表
     *
     * @param int $user_id 用户 id
     * @param int $page 页数
     * @param int $pageSize 每页记录数
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function getPaginateByUserId($user_id, $page, $pageSize)
    {
        return self::with(['ordersSnapshots' => function($query)
        {
            $query->field(['orders_id', 'snapshot_goods_title', 'snapshot_goods_price', 'snapshot_main_image', 'snapshot_goods_quantity', 'snapshot_total_price']);
        }])
            ->where(['user_id' => $user_id])
            ->order(['create_time' => 'desc'])
            ->field(['id', 'orders_number', 'orders_goods_total', 'orders_total_price', 'orders_state', 'create_time'])
            ->paginate($pageSize, true, ['page' => $page]);
    }

    /**
     * 根据订单 id 获取订单详情
     *
     * @param int $id 订单id
     * @return Orders|null
     * @throws \think\exception\DbException
     */
    public static function getOrderById($id)
    {
        return self::get(function($query) use ($id)
        {
            $query->with('ordersSnapshots')->where(['id' => $id]);
        });
    }

    /**
     * 获取分页列表
     *
     * @param int $page 页码
     * @param int $pageSize 页面大小
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function getPaginates($page, $pageSize)
    {
        return self::order(['create_time' => 'desc'])
            ->field(['id', 'orders_number', 'orders_goods_total', 'orders_total_price', 'orders_state', 'create_time'])
            ->paginate($pageSize, true, ['page' => $page]);
    }
}
