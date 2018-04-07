<?php

namespace app\common\model;

/**
 * banner_item 表模型
 */
class BannerItem extends BaseModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = ['delete_time'];

    /**
     * 与 Image 模型的反向关联
     * @return \think\model\relation\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }
}
