<?php

namespace app\api\controller\v1;

use app\common\service\TokenService;
use app\common\traits\ResponseTrait;
use think\Controller;

/**
 * 基类
 * User: Wei Zeng
 */
class Base extends Controller
{
    use ResponseTrait;

    /**
     * 校验是否只拥有用户权限
     *
     * @return bool
     * @throws \app\common\exception\ForbiddenException
     * @throws \app\common\exception\TokenException
     */
    protected function checkOnlyUserScope()
    {
        return TokenService::isOnlyUserScope();
    }

    /**
     * 校验是否拥有或多于用户权限
     *
     * @return bool
     * @throws \app\common\exception\ForbiddenException
     * @throws \app\common\exception\TokenException
     */
    protected function checkUserScope()
    {
        return TokenService::isUserScope();
    }
}
