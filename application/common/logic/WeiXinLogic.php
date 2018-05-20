<?php

namespace app\common\logic;

use app\common\traits\CurlTrait;
use think\Cache;
use think\Config;
use think\Exception;

/**
 * 微信基类
 * User: Wei Zeng
 */
class WeiXinLogic extends Logic
{
    use CurlTrait;

    /**
     * appId
     *
     * @var string
     */
    protected $appId = '';

    /**
     * 密钥
     *
     * @var string
     */
    protected $appSecret = '';

    /**
     * 获取 access_token url
     *
     * @var string
     */
    protected $accessTokenUrl = '';

    /**
     * access_token 缓存的 key
     */
    const tokenCachedKey = 'wx_access_token';

    /**
     * access_token 缓存时间
     */
    const tokenExpiresIn = 7000;

    /**
     * 初始化
     */
    public function __construct()
    {
        // 读取配置
        $wxConfig = Config::get('wx');
        $this->accessTokenUrl = $wxConfig['api_url'];
        $this->appId = $wxConfig['mini_program']['app_id'];
        $this->appSecret = $wxConfig['mini_program']['app_secret'];
    }

    /**
     * 获取 access_token
     *
     * @return mixed
     * @throws Exception
     */
    public function getAccessToken()
    {
        // 从缓存中获取 access_token
        $accessToken = $this->getAccessTokenFromCache();
        if (empty($accessToken))
        {
            // 从微信服务器获取 access_token
            $accessToken = $this->getAccessTokenFromWxServer();

            // 保存 access_token
            $this->saveAccessToken($accessToken);
        }

        return $accessToken;
    }

    /**
     * 从缓存中获取 access_token
     *
     * @return mixed
     */
    protected function getAccessTokenFromCache()
    {
        return Cache::get(self::tokenCachedKey);
    }

    /**
     * 从微信服务器获取 access_token
     *
     * @return mixed
     * @throws Exception
     */
    protected function getAccessTokenFromWxServer()
    {
        // 获取
        $result = $this->curlGet(
            $this->accessTokenUrl,
            [
                'grant_type' => 'client_credential',
                'appid' => $this->appId,
                'secret' => $this->appSecret
            ],
            'json'
        );
        if (empty($result))
        {
            throw new Exception('Request Access Token Api Failed');
        }
        if (empty($result['access_token']))
        {
            throw new Exception($result['errmsg']);
        }

        return $result['access_token'];
    }

    /**
     * 保存 access_token
     *
     * @param $accessToken
     * @throws Exception
     */
    protected function saveAccessToken($accessToken)
    {
        // 保存
        $cachedRet = Cache::set(
            self::tokenCachedKey,
            $accessToken,
            self::tokenExpiresIn
        );
        if (!$cachedRet)
        {
            throw new Exception('Access Token Cached Failed');
        }
    }
}
