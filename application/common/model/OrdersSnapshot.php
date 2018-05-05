<?php

namespace app\common\model;

/**
 * 订单快照
 * User: Wei Zeng
 */
class OrdersSnapshot extends BaseModel
{
    /**
     * 与 Goods model 的关联
     *
     * @return \think\model\relation\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class, 'goods_id', 'id');
    }
}
