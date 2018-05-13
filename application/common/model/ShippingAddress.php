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
     *
     * @var array
     */
    protected $hidden = ['banner', 'delete_time'];

    /**
     * 根据用户 id 获取单条记录
     *
     * @param int $user_id 用户 id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws NotFoundException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getByUserId($user_id)
    {
        // 查询用户
        $user = User::get($user_id);
        if (empty($user))
        {
            throw new NotFoundException('User Not Found');
        }

        return $user->shippingAddresses()->find();
    }

    /**
     * 保存
     *
     * @param int $user_id 用户 id
     * @param array $data 收货地址数据
     * @return false|\think\Model
     * @throws NotFoundException
     * @throws \think\exception\DbException
     */
    public function saveByUserId($user_id, array $data)
    {
        // 查询用户
        $user = User::get($user_id);
        if (empty($user))
        {
            throw new NotFoundException('User Not Found');
        }

        // 保存
        return $user->shippingAddresses()->save($data);
    }

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
