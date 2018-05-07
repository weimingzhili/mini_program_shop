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
    protected $hidden = [
        'category_id', 'main_image_id', 'image_source',
        'update_time', 'delete_time', 'pivot'
    ];

    public function goodsImages()
    {
        return $this->hasMany(GoodsImage::class, 'goods_id', $this->pk);
    }

    public function goodsAttributes()
    {
        return $this->hasMany(GoodsAttribute::class, 'goods_id', $this->pk);
    }

    /**
     * 完整的 main_image_url 获取器
     * @param string $value main_image_url
     * @param array $data 所在记录
     * @return string
     */
    public function getMainImageFullUrlAttr($value, $data)
    {
        return $this->convertImageUrl($data['main_image_url'], $data);
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

        // 追加完整主图完整路径
        $goods->each(function($item)
        {
            $item->append(['mainImageFullUrl']);
        });

        // 去掉无关字段
        $goods = $goods->hidden(['goods_summary', 'create_time', 'update_time']);

        return $goods;
    }

    /**
     *  根据分类 id 获取商品
     * @param int $category_id 分类 id
     * @return false|static[]
     * @throws NotFoundException
     * @throws \think\exception\DbException
     */
    public static function getAllGoodsByCategoryId($category_id)
    {
        // 查询
        $goods = self::all(function($query) use ($category_id) {
            $query->where(['category_id' => $category_id])->order(['list_order' => 'desc']);
        });
        if ($goods->isEmpty())
        {
            throw new NotFoundException('Category Goods Not Found');
        }

        // 去掉无关字段
        $goods = $goods->hidden(['goods_summary', 'create_time', 'update_time']);

        return $goods;
    }

    /**
     * 根据 id 获取商品详情
     * @param int $id 商品 id
     * @return null|static
     * @throws NotFoundException
     * @throws \think\exception\DbException
     */
    public static function getGoodsDetailById($id)
    {
        // 查询
        $goods = self::get(function($query) use ($id)
        {
            $query->with(['goodsImages' => function($query) {
                $query->with('image')
                    ->order(['list_order' => 'asc']);
            }])
                ->with('goodsAttributes')
                ->where(['id' => $id]);
        });
        if (empty($goods))
        {
            throw new NotFoundException('Goods Detail Not Found');
        }

        return $goods;
    }
}
