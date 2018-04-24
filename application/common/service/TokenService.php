<?php

namespace app\common\service;

use app\common\exception\NotFoundException;
use app\common\exception\TokenException;
use app\common\library\WeChat;
use app\common\model\User;
use think\Cache;
use think\Config;
use think\Exception;
use think\Request;

/**
 * token
 * User: Wei Zeng
 */
class TokenService extends BaseService
{
    /**
     * 根据 code 获取 token
     *
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

    /**
     * 获取缓存的 session
     *
     * @param string $key 缓存键名
     * @return mixed
     * @throws NotFoundException
     * @throws TokenException
     */
    public static function getCachedSessionByToken($key = '')
    {
        // 获取 token
        $token = Request::instance()->header('token');
        if (empty($token))
        {
            throw new TokenException('Token Could Not Empty');
        }

        // 获取缓存
        $session = Cache::get($token);
        if (empty($session))
        {
            throw new NotFoundException('Cached Session Not Found');
        }

        // 返回所需的信息
        switch ($key)
        {
            case 'openid':
                $value = $session['weChatSession']['openid'];
                break;
            case 'session_key':
                $value = $session['weChatSession']['session_key'];
                break;
            case 'weChatSession':
                $value = $session['weChatSession'];
                break;
            case 'user_id':
                $value = $session['user_id'];
                break;
            case 'scope':
                $value = $session['scope'];
                break;
            default:
                $value = $session;
        }

        return $value;
    }

    /**
     * 从缓存的 session 获取 user_id
     *
     * @return mixed
     * @throws NotFoundException
     * @throws TokenException
     */
    public static function getSessionUserId()
    {
        return self::getCachedSessionByToken('user_id');
    }
}
