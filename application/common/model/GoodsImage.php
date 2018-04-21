<?php

namespace app\common\model;

/**
 * goods_image 表模型
 * User: Wei Zeng
 */
class GoodsImage extends BaseModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = ['update_time', 'delete_time'];

    /**
     * 与 Image 模型的反向关联
     * @return \think\model\relation\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id', 'id');
    }
}
