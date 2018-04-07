<?php

namespace app\api\model;

use think\Config;
use think\Model;

/**
 * 基础模型
 */
class BaseModel extends Model
{
    /**
     * image url 获取器
     * @param string $image_url
     * @param array $data
     * @return string
     */
    public function getImageUrlAttr($image_url, $data)
    {
        return $data['image_source'] == 1 ? Config::get('image.image_prefix') . $image_url : $image_url;
    }
}
