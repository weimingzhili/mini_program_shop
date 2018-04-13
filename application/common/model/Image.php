<?php

namespace app\common\model;

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

    /**
     * image url 获取器
     * @param string $image_url image_url
     * @param array $data 所在记录
     * @return string
     */
    public function getImageUrlAttr($image_url, $data)
    {
        return $this->convertImageUrl($image_url, $data);
    }
}
