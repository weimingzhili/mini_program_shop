<?php

namespace app\common\model;

/**
 * goods 表模型
 * User: Wei Zeng
 */
class Goods extends BaseModel
{
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = ['category_id', 'main_image_id', 'delete_time', 'pivot'];

    /**
     * main_image_url 获取器
     * @param string $value main_image_url
     * @param array $data 所在记录
     * @return string
     */
    public function getMainImageUrlAttr($value, $data)
    {
        return $this->convertImageUrl($value, $data);
    }
}
