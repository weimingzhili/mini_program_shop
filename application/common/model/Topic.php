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
     * @var array
     */
    protected $hidden = ['delete_time'];

    /**
     * 定义与 Goods 模型的多对多关联
     * @return \think\model\relation\BelongsToMany
     */
    public function goods()
    {
        return $this->belongsToMany(Goods::class, 'topic_goods', 'topic_id');
    }

    /**
     * 定义与 Image 模型的多对多关联
     * @return \think\model\relation\BelongsToMany
     */
    public function images()
    {
        return $this->belongsToMany(Image::class, 'topic_image', 'topic_id');
    }

    /**
     * 获取精选主题
     * @return false|static[]
     * @throws NotFoundException
     * @throws \think\exception\DbException
     */
    public static function getFeaturedTopics()
    {
        // 查询
        $topics = self::all(function ($query)
        {
            $query->with(['goods', 'images'])
                ->order([
                    'list_order' => 'desc',
                    'create_time' => 'desc',
                ])
                ->limit(3);
        });
        if (empty($topics))
        {
            throw new NotFoundException('Topics Not Found', Config::get('api.error_code')['not_found']);
        }

        return $topics;
    }
}
