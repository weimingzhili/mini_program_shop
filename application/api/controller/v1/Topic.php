<?php

namespace app\api\controller\v1;

use app\common\exception\NotFoundException;
use app\common\exception\ParameterException;
use think\Controller;
use app\common\model\Topic as TopicModel;
use think\Request;

/**
 * 专题
 * User: Wei Zeng
 */
class Topic extends Controller
{
    /**
     * 主题列表
     * @url  /topics 访问 url
     * @http Get     访问方式
     * @return false|static[]
     * @throws NotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 获取
        return TopicModel::getFeaturedTopics();
    }

    /**
     * 获取专题详情
     * @url   /topics/:id              访问url
     * @http  Get                      访问方式
     * @param Request $request Request 实例
     * @return null|static
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
        return TopicModel::getThemeWithProducts($param['id']);
    }
}
