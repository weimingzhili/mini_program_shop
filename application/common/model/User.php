<?php

namespace app\common\model;

/**
 * 用户
 * User: Wei Zeng
 */
class User extends BaseModel
{
    /**
     * 与 ShippingAddress model 的关联
     * @return \think\model\relation\HasMany
     */
    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class, 'user_id', $this->pk);
    }

    /**
     * 根据 openid 获取用户
     *
     * @param string $openid 小程序 openid
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function getUserByOpenid($openid)
    {
        return self::get(function($query) use ($openid) {
            $query->where(['openid' => $openid]);
        });
    }
}
