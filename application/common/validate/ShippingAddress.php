<?php

namespace app\common\validate;

/**
 * 收货地址
 * User: Wei Zeng
 */
class ShippingAddress extends BaseValidate
{
    /**
     * 验证规则
     *
     * @var array
     */
    protected $rule = [
        // table field
        'id' => 'require|positiveInteger',
        'consignee_name' => 'require|max:60',
        'consignee_phone' => 'require|mobile',
        'province_name' => 'require|max:60',
        'province_code' => 'require|max:10',
        'city_name' => 'require|max:60',
        'city_code' => 'require|max:10',
        'area_name' => 'require|max:60',
        'area_code' => 'require|max:10',
        'street_name' => 'max:60',
        'street_code' => 'max:10',
        'detailed_address' => 'require|max:255',
    ];

    /**
     * 场景
     *
     * @var array
     */
    protected $scene = [
        // 创建
        'create' => [
            'consignee_name', 'consignee_phone', 'province_name',
            'province_code', 'city_name', 'city_code', 'area_name',
            'area_code', 'street_name', 'street_code', 'detailed_address',
        ],
        // 更新
        'update' => [
            'id',
            'consignee_name' => 'max:60',
            'consignee_phone' => 'mobile',
            'province_name' => 'max:60',
            'province_code' => 'max:10',
            'city_name' => 'max:60',
            'city_code' => 'max:10',
            'area_name' => 'max:60',
            'area_code' => 'max:10',
            'street_name',
            'street_code',
            'detailed_address' => 'max:255',
        ]
    ];
}
