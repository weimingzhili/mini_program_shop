<?php

namespace app\common\model;

use app\common\exception\NotFoundException;
use think\Config;

/**
 * topic 表模型
 */
class Topic extends BaseModel
{
    /**
     * 隐藏字段
     *
     * @var array
     */
    protected $hidden = ['update_time', 'delete_time'];

    /**
     * 定义与 Goods 模型的多对多关联
     *
     * @return \think\model\relation\BelongsToMany
     */
    public function goods()
    {
        return $this->belongsToMany(Goods::class, TopicGoods::class);
    }

    /**
     * 定义与 Image 模型的多对多关联
     *
     * @return \think\model\relation\BelongsToMany
     */
    public function images()
    {
        return $this->belongsToMany(Image::class, TopicImage::class);
    }

    /**
     * 获取精选主题
     *
     * @return false|static[]
     * @throws NotFoundException
     * @throws \think\exception\DbException
     */
    public static function getFeaturedTopics()
    {
        // 查询
        $topics = self::all(function ($query)
        {
            $query->with('images')
                ->order([
                    'list_order'  => 'desc',
                    'create_time' => 'desc',
                ])
                ->limit(3);
        });
        if ($topics->isEmpty())
        {
            throw new NotFoundException('Topics Not Found', Config::get('api.error_code')['not_found']);
        }

        return $topics;
    }

    /**
     * 获取专题（包含产品）
     *
     * @param int $id 主键
     * @return null|static
     * @throws NotFoundException
     * @throws \think\exception\DbException
     */
    public static function getThemeWithProducts($id)
    {
        // 查询
        $topics = self::get(function($query) use ($id)
        {
            $query->with(['images', 'goods'])
                ->where(['id' => $id]);
        });
        if (empty($topics))
        {
            throw new NotFoundException('Topics Not Found', Config::get('api.error_code')['not_found']);
        }

        // 追加完整主图完整路径
        $topics->goods->each(function($item)
        {
            $item->append(['mainImageFullUrl']);
        });

        return $topics;
    }
}
