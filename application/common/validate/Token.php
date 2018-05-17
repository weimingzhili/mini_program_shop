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
     *
     * @var array
     */
    protected $rule = [
        // table fields
        'code' => 'require',
        'app_id' => 'require',
        'app_secret' => 'require',

        // other fields
        'token' => 'require',
    ];

    /**
     * 场景
     *
     * @var array
     */
    protected $scene = [
        // 生成用户 token
        'createUserToken' => ['code'],
        // 获取 token 状态
        'userTokenStates' => ['token'],
        // 生成管理员 token
        'createAdminToken' => ['app_id', 'app_secret'],
    ];
}
