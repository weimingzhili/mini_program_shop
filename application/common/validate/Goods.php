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
     * @var array
     */
    protected $rule = [
        // table field
        'category_id' => 'positiveInteger',

        // other field
        'limit' => 'positiveInteger|elt:50',
    ];

    /**
     * 场景
     * @var
     */
    protected $scene = [
        // 列表
        'index' => ['limit'],
        // 分类商品
        'categoryGoods' => ['category_id'],
    ];
}
