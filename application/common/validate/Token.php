<?php

namespace app\common\validate;

/**
 * token
 * User: Wei Zeng
 */
class Token extends BaseValidate
{
    /**
     * 验证规则
     * @var array
     */
    protected $rule = [
        // table field
        'code' => 'require',
    ];

    /**
     * 场景
     * @var array
     */
    protected $scene = [
        // 生成
        'create' => ['code'],
    ];
}
