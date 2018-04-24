<?php

namespace app\common\model;

use app\common\exception\NotFoundException;

/**
 * shipping_address 表模型
 * User: Wei Zeng
 */
class ShippingAddress extends BaseModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = ['banner', 'delete_time'];

    /**
     * 根据 id 和用户 id 更新数据
     *
     * @param int $id 收货地址id
     * @param int $user_id 用户id
     * @param array $data 更新数据
     * @return false|int|null|static
     * @throws NotFoundException
     * @throws \think\exception\DbException
     */
    public function updateByIdAndUserId($id, $user_id, array $data)
    {
        // 查询
        $shippingAddress = self::get(function($query) use ($id, $user_id) {
            $query->where(['id' => $id])->where(['user_id' => $user_id]);
        });
        if (empty($shippingAddress))
        {
            throw new NotFoundException('Shipping Address Not Found');
        }

        // 更新
        $result = $shippingAddress->save($data);

        return $result ? $shippingAddress : $result;
    }
}
