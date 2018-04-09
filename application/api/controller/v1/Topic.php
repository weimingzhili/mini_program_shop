<?php

namespace app\api\controller\v1;

use app\common\exception\NotFoundException;
use think\Controller;
use app\common\model\Topic as TopicModel;

/**
 * 专题
 * User: Wei Zeng
 */
class Topic extends Controller
{
    /**
     * 主题列表
     * @return false|static[]
     * @throws NotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 获取
        return TopicModel::getFeaturedTopics();
    }
}
