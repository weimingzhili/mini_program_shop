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
     * 生成 token
     *
     * @url /token/users 访问 url
     * @http get 请求方式
     * @param Request $request Request 实例
     * @return \think\response\Json
     * @throws ParameterException
     * @throws \think\Exception
     */
    public function create(Request $request)
    {
        // 获取参数
        $param         = [];
        $param['code'] = $request->param('code');

        // 验证
        $checkRet = $this->validate($param, 'Token.create');
        if (!$checkRet)
        {
            throw new ParameterException($checkRet);
        }

        // 获取
        $tokenService = new TokenService();
        $token = $tokenService->getTokenByCode($param['code']);

        return $this->restResponse(['token' => $token]);
    }
}
