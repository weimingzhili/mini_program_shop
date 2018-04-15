<?php

namespace app\api\controller\v1;

use app\common\exception\ParameterException;
use think\Controller;
use think\Request;
use app\common\model\Goods as GoodsModel;

/**
 * 商品
 * User: Wei Zeng
 */
class Goods extends Controller
{
    /**
     * 列表
     * @url /goods
     * @http get
     * @param Request $request Request 实例
     * @return false|static[]
     * @throws ParameterException
     * @throws \app\common\exception\NotFoundException
     * @throws \think\exception\DbException
     */
    public function index(Request $request)
    {
        // 获取参数
        $param          = [];
        $param['limit'] = $request->param('limit', 10);

        // 校验参数
        $checkRet = $this->validate($param, 'Goods.index');
        if ($checkRet !== true)
        {
            throw new ParameterException($checkRet);
        }

        return GoodsModel::getLatestGoods($param['limit']);
    }

    /**
     * 获取分类商品
     * @url /categoryGoods
     * @http get
     * @param Request $request
     * @return false|static[]
     * @throws ParameterException
     * @throws \app\common\exception\NotFoundException
     * @throws \think\exception\DbException
     */
    public function categoryGoods(Request $request)
    {
        // 获取参数
        $param                = [];
        $param['category_id'] = $request->param('category_id');

        // 校验参数
        $checkRet = $this->validate($param, 'Goods.categoryGoods');
        if ($checkRet !== true)
        {
            throw new ParameterException($checkRet);
        }

        return GoodsModel::getAllGoodsByCategoryId($param['category_id']);
    }
}
