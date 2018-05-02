<?php

namespace app\common\model;

/**
 * 订单
 * User: Wei Zeng
 */
class Orders extends BaseModel
{
    /**
     * 与 OrdersSnapShot model 的关联
     *
     * @return \think\model\relation\HasMany
     */
    public function ordersSnapshots()
    {
        return $this->hasMany(OrdersSnapshot::class, 'orders_id', $this->pk);
    }
}
