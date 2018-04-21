<?php

namespace app\common\service;

use app\common\library\WeChat;
use app\common\model\User;
use think\Cache;
use think\Config;
use think\Exception;

/**
 * token
 * User: Wei Zeng
 */
class Token extends BaseService
{
    /**
     *  根据 code 获取 token
     * @param $code
     * @return string
     * @throws Exception
     * @throws \think\exception\DbException
     */
    public function getTokenByCode($code)
    {
        // 获取 openid
        $weChat = new WeChat();
        $result = $weChat->getSessionByCode($code);
        if (empty($result) || isset($result['errcode']))
        {
            throw new Exception("WeChat Session Interface Request Failed. Result:\n" . var_export($result, true));
        }

        // 获取用户
        $user = User::getUserByOpenid($result['openid']);
        if (empty($user))
        {
            // 创建用户
            $user = User::create(['openid' => $result['openid']]);
        }

        // 生成 token
        $token = self::generateToken();

        // 写入缓存
        $cachedRet = Cache::set($token, [
            'weChatSession' => $result,
            'user_id' => $user->id,
            'scope' => 16,
        ], Config::get('cache.token_expires_in'));
        if (!$cachedRet)
        {
            throw new Exception("Cache Failed. Parameter: " . var_export($cachedRet, true));
        }

        return $token;
    }
}
