<?php

namespace app\api\controller\v1;

use app\common\model\Category as CategoryModel;

/**
 * 分类
 * User: Wei Zeng
 */
class CategoryController extends Controller
{
    /**
     * 列表
     * @url /categories 访问 url
     * @http get 请求方式
     * @return \think\response\Json
     * @throws \app\common\exception\NotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 获取
        $categories = CategoryModel::getAllCategories();

        return $this->restResponse(['categories' => $categories]);
    }
}
