<?php

namespace app\api\controller\v1;

use app\common\exception\ParameterException;
use app\common\model\Goods as GoodsModel;
use think\Request;

/**
 * 商品
 * User: Wei Zeng
 */
class Goods extends BaseController
{
    /**
     * 最新商品
     * @url /goods 访问 url
     * @http get 请求方式
     * @param Request $request Request 实例
     * @return \think\response\Json
     * @throws ParameterException
     * @throws \app\common\exception\NotFoundException
     * @throws \think\exception\DbException
     */
    public function latestGoods(Request $request)
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

        $goods = GoodsModel::getLatestGoods($param['limit']);

        return $this->restResponse(['goods' => $goods]);
    }

    /**
     * 获取分类商品
     * @url /categoryGoods 访问 url
     * @http get 请求方式
     * @param Request $request
     * @return \think\response\Json
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

        $goods = GoodsModel::getAllGoodsByCategoryId($param['category_id']);

        return $this->restResponse(['goods' => $goods]);
    }

    /**
     * 获取商品详情
     * @url /goods/:id 请求 url
     * @http get 请求方式
     * @param Request $request
     * @return \think\response\Json
     * @throws ParameterException
     * @throws \app\common\exception\NotFoundException
     * @throws \think\exception\DbException
     */
    public function read(Request $request)
    {
        // 获取参数
        $param       = [];
        $param['id'] = $request->param('id');

        // 校验参数
        $checkRet = $this->validate($param, 'Goods.goodsDetails');
        if ($checkRet !== true)
        {
            throw new ParameterException($checkRet);
        }

        $goods = GoodsModel::getGoodsDetailById($param['id']);

        return $this->restResponse(['goods' => $goods]);
    }
}
