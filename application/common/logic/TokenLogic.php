<?php

namespace app\common\logic;

use app\common\exception\ForbiddenException;
use app\common\exception\TokenException;
use app\common\library\WeChat;
use app\common\model\ThirdApp;
use app\common\model\User;
use think\Cache;
use think\Config;
use think\Exception;
use think\Request;

/**
 * token
 * User: Wei Zeng
 */
class TokenLogic extends Logic
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
            'scope' => Config::get('scope.role')['user'],
        ], Config::get('cache.token_expires_in'));
        if (!$cachedRet)
        {
            throw new Exception("Cache Failed. Parameter: " . var_export($cachedRet, true));
        }

        return $token;
    }

    // 获取管理员 token

    /**
     * 获取管理员 token
     *
     * @param $app_id
     * @param $app_secret
     * @return string
     * @throws Exception
     * @throws TokenException
     * @throws \think\exception\DbException
     */
    public static function getAdminToken($app_id, $app_secret)
    {
        // 查询
        $thirdAppRecord = ThirdApp::get(function ($query) use ($app_id, $app_secret)
        {
            $query->where(['app_id' => $app_id])->where(['app_secret' => $app_secret]);
        });
        if (empty($thirdAppRecord))
        {
            $apiConfig = Config::get('api');
            throw new TokenException(
                $apiConfig['response_message']['authorization_failed'],
                $apiConfig['response_code']['authorization_failed']
            );
        }

        // 生成 token
        $token = self::generateToken();

        // 写入缓存
        $cachedRet = Cache::set($token, [
            'admin_id' => $thirdAppRecord->id,
            'scope' => $thirdAppRecord->scope,
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
     * @throws TokenException
     */
    public static function getCachedSessionByToken($key = '')
    {
        // 获取 token
        $token = Request::instance()->header('token');
        if (empty($token))
        {
            $config = Config::get('api');
            throw new TokenException(
                $config['response_message']['token_cannot_be_empty'],
                $config['response_code']['token_cannot_be_empty']
            );
        }

        // 获取缓存
        $session = Cache::get($token);
        if (empty($session))
        {
            throw new TokenException();
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
     * @throws TokenException
     */
    public static function getSessionUserId()
    {
        return self::getCachedSessionByToken('user_id');
    }

    /**
     * 比对是否拥有或多于用户权限
     *
     * @return bool
     * @throws ForbiddenException
     * @throws TokenException
     */
    public static function isUserScope()
    {
        // 获取并比对
        $scope = self::getCachedSessionByToken('scope');
        if ($scope < Config::get('scope.role')['user'])
        {
            throw new ForbiddenException();
        }

        return true;
    }

    /**
     * 比对是否只拥有用户权限
     *
     * @return bool
     * @throws ForbiddenException
     * @throws TokenException
     */
    public static function isOnlyUserScope()
    {
        // 获取并比对
        $scope = self::getCachedSessionByToken('scope');
        if ($scope != Config::get('scope.role')['user'])
        {
            throw new ForbiddenException();
        }

        return true;
    }

    /**
     * 检测用户是否匹配
     *
     * @param int $checkedUserId 要检测的id
     * @return bool
     * @throws TokenException
     */
    public static function checkUserMatches($checkedUserId)
    {
        return $checkedUserId == self::getSessionUserId();
    }

    /**
     * 检测 token
     *
     * @param string $token token
     * @return bool
     */
    public static function checkToken($token)
    {
        // 获取 session
        $session = Cache::get($token);

        return !empty($session) ? true : false;
    }
}
