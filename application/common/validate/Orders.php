<?php

namespace app\common\validate;

/**
 * 订单
 * User: Wei Zeng
 */
class Orders extends BaseValidate
{
    /**
     * 验证规则
     * @var array
     */
    protected $rule = [
        'orders' => 'checkOrder',
        'shipping_address_id' => 'require|positiveInteger',
    ];

    /**
     * 场景
     * @var
     */
    protected $scene = [
        // 下单
        'create' => ['orders', 'shipping_address_id'],
    ];

    protected $message = [
        // 下单
        'orders.checkOrder' => 'Orders Data Invalid',
    ];

    // 校验订单数据
    protected function checkOrder($value)
    {
        // 校验整体
        if (empty($value) || !is_array($value))
        {
            return false;
        }

        // 校验各项下单数据
        $rule = [
            'goods_id' => 'require|positiveInteger',
            'quantity' => 'require|positiveInteger',
        ];
        $this->rule($rule);
        $validator = new BaseValidate($rule);
        foreach ($value as $item)
        {
            // 校验子项整体
            if (empty($item) || !is_array($item))
            {
                return false;
            }

            // 校验子项具体数据
            $checkRet = $validator->check($item);
            if ($checkRet !== true)
            {
                return false;
            }
        }

        return true;
    }
}
