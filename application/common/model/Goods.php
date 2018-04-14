<?php

namespace app\common\model;

use app\common\exception\NotFoundException;

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
    protected $hidden = ['category_id', 'main_image_id', 'image_source', 'delete_time', 'pivot'];

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

    /**
     * 获取最近的商品
     * @param int $limit 商品数量
     * @return false|static[]
     * @throws NotFoundException
     * @throws \think\exception\DbException
     */
    public static function getLatestGoods($limit)
    {
        // 查询
        $goods = self::all(function($query) use ($limit) {
            $query->order(['create_time' => 'desc'])->limit($limit);
        });
        if ($goods->isEmpty())
        {
            throw new NotFoundException('Latest Goods Not Found');
        }

        // 去掉无关字段
        $goods = $goods->hidden(['goods_summary', 'create_time', 'update_time']);

        return $goods;
    }
}
