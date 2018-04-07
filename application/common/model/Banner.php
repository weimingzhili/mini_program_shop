<?php

namespace app\common\model;

use app\common\exception\NotFoundException;

/**
 * Banner
 * User: Wei Zeng
 */
class Banner extends BaseModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = ['delete_time'];

    /**
     * 与 BannerItem 模型的关联
     * @return \think\model\relation\HasMany
     */
    public function bannerItems()
    {
        return $this->hasMany(BannerItem::class, 'banner_id', $this->pk);
    }

    /**
     * 根据 id 获取 banner
     * @param $banner_id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws NotFoundException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getBannerById($banner_id)
    {
        // 查询
        $banner = self::with(['bannerItems', 'bannerItems.image'])->find($banner_id);
        // 若 banner 不存在
        if (empty($banner))
        {
            throw new NotFoundException('Banner Not Found');
        }

        return $banner;
    }
}
