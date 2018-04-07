<?php

namespace app\api\model;

/**
 * image 表模型
 */
class Image extends BaseModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = ['image_source', 'delete_time'];
}
