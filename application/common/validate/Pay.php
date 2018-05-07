<?php

namespace app\common\validate;

/**
 * 支付
 * User: Wei Zeng
 */
class Pay extends BaseValidate
{
    /**
     * 验证规则
     *
     * @var array
     */
    protected $rule = [
        // table fields
        'orders_id' => 'require|positiveInteger',
    ];

    /**
     * 场景
     *
     * @var array
     */
    protected $scene = [
        // 统一下单
        'unifiedOrder' => 'orders_id'
    ];
}
