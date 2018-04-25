<?php

namespace app\common\traits;

use app\common\exception\ForbiddenException;
use app\common\service\TokenService;
use think\Config;

/**
 * 作用域控制
 * User: Wei Zeng
 */
trait ScopeTrait
{
    /**
     * 校验用户权限
     *
     * @return bool
     * @throws ForbiddenException
     * @throws \app\common\exception\TokenException
     */
    protected function checkUserScope()
    {
        // 获取 scope
        $scope = TokenService::getCachedSessionByToken('scope');
        if ($scope < Config::get('scope.role')['user'])
        {
            throw new ForbiddenException();
        }

        return true;
    }
}
