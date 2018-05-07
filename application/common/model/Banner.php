<?php

namespace app\common\model;

/**
 * Banner
 * User: Wei Zeng
 */
class Banner extends BaseModel
{
    /**
     * 隐藏字段
     *
     * @var array
     */
    protected $hidden = ['delete_time'];

    /**
     * 与 BannerItem 模型的关联
     *
     * @return \think\model\relation\HasMany
     */
    public function bannerItems()
    {
        return $this->hasMany(BannerItem::class, 'banner_id', $this->pk);
    }
}
