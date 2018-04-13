<?php

namespace app\common\model;

use think\model\Pivot;

/**
 * Topic Image 关联
 * User: Wei Zeng
 */
class TopicImage extends Pivot
{
    /**
     * 主键
     * @var array
     */
    protected $pk = ['topic_id', 'image_id', 'create_time'];

    protected $hidden = ['topic_id', 'image_id', 'create_time', 'delete_time'];
}
