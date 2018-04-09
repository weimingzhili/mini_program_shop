<?php

namespace app\common\model;

use think\Config;
use think\Model;
use traits\model\SoftDelete;

/**
 * 基础模型
 */
class BaseModel extends Model
{
    // 引入软删除
    use SoftDelete;

    /**
     * 开启时间戳自动写入
     * @var bool
     */
    protected $autoWriteTimestamp = true;

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
