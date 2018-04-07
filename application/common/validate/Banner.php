<?php

namespace app\common\validate;

/**
 * Banner
 * User: Wei Zeng
 */
class Banner extends Base
{
    /**
     *
     */
    protected $rule = [
        'id' => 'require|number',
    ];

    /**
     * 场景
     */
    protected $scene = [
        // 获取 banner 信息
        'read' => ['id'],
    ];
}
