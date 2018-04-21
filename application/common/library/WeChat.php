<?php

namespace app\common\library;

use think\Config;
use app\common\traits\CurlTrait;

/**
 * 微信
 * User: Wei Zeng
 */
class WeChat
{
    use CurlTrait;

    /**
     * 小程序 appID
     * @var string
     */
    protected $appId;

    /**
     * 小程序 AppSecret
     * @var string
     */
    protected $appSecret;

    /**
     * 小程序接口域名
     * @var string
     */
    protected $api_host;

    /**
     * 小程序接口地址
     * @var array
     */
    protected $api_urls;

    /**
     * 初始化
     */
    public function __construct()
    {
        // 加载配置
        $config = Config::get('wechat.mini_program');
        $this->appId = $config['app_id'];
        $this->appSecret = $config['app_secret'];
        $this->api_host = $config['api_host'];
        $this->api_urls = $config['api_urls'];
    }

    /**
     * 根据 code 获取 session 数据
     * @param string $code 小程序 js code
     * @return mixed
     */
    public function getSessionByCode($code)
    {
        $url = 'https://' . $this->api_host . $this->api_urls['get_session_by_code'];

        return $this->curlGet($url, [
            'appid' => $this->appId,
            'secret' => $this->appSecret,
            'js_code' => $code,
            'grant_type' => 'authorization_code',
        ], 'json');
    }
}
