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

    public function convertImageUrl($image_url, $data)
    {
        return $data['image_source'] == 1 ? Config::get('image.image_prefix') . $image_url : $image_url;
    }
}
