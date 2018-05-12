<?php

namespace app\common\model;

use app\common\exception\NotFoundException;

/**
 * category 表模型
 * User: Wei Zeng
 */
class Category extends BaseModel
{
    /**
     * 隐藏字段
     *
     * @var array
     */
    protected $hidden = ['image_id', 'delete_time'];

    /**
     * 与 Image 模型的反向关联
     *
     * @return \think\model\relation\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id', $this->pk);
    }

    /**
     * 获取所有的分类
     *
     * @return Category[]|false
     * @throws \think\exception\DbException
     */
    public static function getAllCategories()
    {
        // 查询
        return self::all(function($query) {
            $query->with(['image'])->order(['list_order' => 'desc']);
        });
    }
}
