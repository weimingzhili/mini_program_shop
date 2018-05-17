<?php

namespace app\api\controller\v1;

use app\common\exception\ParameterException;
use app\common\service\TokenService;
use app\common\traits\ToolTrait;
use think\Request;

/**
 * token
 * User: Wei Zeng
 */
class TokenController extends Base
{
    use ToolTrait;

    /**
     * 生成用户 token
     *
     * @url /token/users 访问 url
     * @http get 请求方式
     * @param Request $request Request 实例
     * @return \think\response\Json
     * @throws ParameterException
     * @throws \think\Exception
     */
    public function createUserToken(Request $request)
    {
        // 获取参数
        $param = [];
        $param['code'] = $request->param('code');

        // 验证
        $checkRet = $this->validate($param, 'Token.createUserToken');
        if (!$checkRet)
        {
            throw new ParameterException($checkRet);
        }

        // 获取
        $tokenService = new TokenService();
        $token = $tokenService->getTokenByCode($param['code']);

        return $this->restResponse(['token' => $token]);
    }

    /**
     * 获取用户 token 状态
     *
     * @param Request $request Request 实例
     * @return \think\response\Json
     * @throws ParameterException
     */
    public function userTokenStates(Request $request)
    {
        // 获取参数
        $param = [];
        $param['token'] = $request->param('token');

        // 验证
        $checkRet = $this->validate($param, 'Token.userTokenStates');
        if (!$checkRet)
        {
            throw new ParameterException($checkRet);
        }

        // 检查
        $state = TokenService::checkToken($param['token']);

        return $this->restResponse(['tokenState' => $state]);
    }

    // 创建管理员 token

    /**
     * 创建管理员 token
     *
     * @url /token/adminTokens 访问 url
     * @http get 请求方式
     * @param Request $request
     * @return \think\response\Json
     * @throws ParameterException
     * @throws \app\common\exception\TokenException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function createAdminToken(Request $request)
    {
        // 获取参数
        $param = [];
        $param['app_id'] = $request->param('app_id');
        $param['app_secret'] = $request->param('app_secret');

        // 验证
        $checkRet = $this->validate($param, 'Token.createAdminToken');
        if ($checkRet !== true)
        {
            throw new ParameterException($checkRet);
        }

        // 生成
        $token = TokenService::getAdminToken($param['app_id'], $param['app_secret']);

        return $this->restResponse(['token' => $token]);
    }
}
