<?php

namespace app\common\validate;

/**
 * Banner
 * User: Wei Zeng
 */
class Banner extends BaseValidate
{
    /**
     * 验证规则
     * @var array
     */
    protected $rule = [
        'id' => 'require|positiveInteger',
    ];

    /**
     * 场景
     * @var array
     */
    protected $scene = [
        // 获取 banner 信息
        'read' => ['id'],
    ];
}
