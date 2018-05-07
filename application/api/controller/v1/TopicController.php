<?php

namespace app\api\controller\v1;

use app\common\exception\NotFoundException;
use app\common\exception\ParameterException;
use app\common\model\Topic as TopicModel;
use think\Request;

/**
 * 专题
 * User: Wei Zeng
 */
class TopicController extends Base
{
    /**
     * 主题列表
     * @url /topics 访问 url
     * @http Get 访问方式
     * @return \think\response\Json
     * @throws NotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 获取
        $topics = TopicModel::getFeaturedTopics();

        return $this->restResponse($topics);
    }

    /**
     * 获取专题详情
     * @url /topics/:id 访问 url
     * @http Get 访问方式
     * @param Request $request Request 实例
     * @return \think\response\Json
     * @throws NotFoundException
     * @throws ParameterException
     * @throws \think\exception\DbException
     */
    public function read(Request $request)
    {
        // 获取参数
        $param = [];
        $param['id'] = $request->param('id');

        // 校验参数
        $checkRet = $this->validate($param, 'Topic.read');
        if ($checkRet !== true)
        {
            throw new ParameterException($checkRet);
        }

        // 获取
        $topics = TopicModel::getThemeWithProducts($param['id']);

        return $this->restResponse($topics);
    }
}
