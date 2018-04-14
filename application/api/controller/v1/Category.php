<?php

namespace app\api\controller\v1;

use think\Controller;
use app\common\model\Category as CategoryModel;

/**
 * 分类
 * User: Wei Zeng
 */
class Category extends Controller
{
    /**
     * 列表
     * @return false|static[]
     * @throws \app\common\exception\NotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        return CategoryModel::getAllCategories();
    }
}
