<?php

namespace app\common\validate;

/**
 * 专题
 * User: Wei Zeng
 */
class Topic extends BaseValidate
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
        // 获取专题
        'read' => ['id'],
    ];
}
