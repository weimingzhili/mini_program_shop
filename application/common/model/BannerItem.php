<?php

namespace app\common\model;

use app\common\exception\NotFoundException;

/**
 * banner_item 表模型
 */
class BannerItem extends BaseModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = ['banner', 'delete_time'];

    /**
     * 与 Image 模型的反向关联
     * @return \think\model\relation\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id', $this->pk);
    }

    /**
     * 与 Banner 模型的反向关联
     * @return \think\model\relation\BelongsTo
     */
    public function banner()
    {
        return $this->belongsTo(Banner::class, 'banner_id', $this->pk);
    }

    /**
     * 根据 banner id 获取 banner item
     * @param int $banner_id banner id
     * @return false|static[]
     * @throws \think\exception\DbException
     */
    public static function getBannerItemByBannerId($banner_id)
    {
        // 查询
        $bannerItems = self::all(function($query) use ($banner_id) {
            $query->with(['banner', 'image'])
                ->where(['banner_id' => $banner_id])
                ->order(['list_order' => 'desc']);
        });

        return $bannerItems;
    }
}
