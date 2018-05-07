<?php

namespace app\common\validate;

/**
 * 商品
 * User: Wei Zeng
 */
class Goods extends BaseValidate
{
    /**
     * 验证规则
     *
     * @var array
     */
    protected $rule = [
        // table fields
        'id' => 'require|positiveInteger',
        'category_id' => 'require|positiveInteger',

        // other fields
        'limit' => 'positiveInteger|elt:50',
    ];

    /**
     * 场景
     *
     * @var array
     */
    protected $scene = [
        // 列表
        'index' => ['limit'],
        // 分类商品
        'categoryGoods' => ['category_id'],
        // 获取商品详情
        'goodsDetails' => ['id'],
    ];
}
