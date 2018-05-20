<?php

namespace app\common\logic;
use think\Config;
use think\Exception;

/**
 * 微信消息
 * User: Wei Zeng
 */
class WxMessageLogic extends WeiXinLogic
{
    /**
     * 发送模板消息
     *
     * @param object $order 订单
     * @param string $jumpPage 跳转页面
     * @return bool
     * @throws Exception
     */
    public function send($order, $jumpPage = '')
    {
        // 发送
        $wxConfig = Config::get('wx');
        $param = [
            'touser'      => '',
            'template_id' => '',
            'page'        => $jumpPage,
            'form_id'     => '',
            'data'        => '',
            'emphasis_keyword' => '',
        ];
        $result = $this->curlPost(
            $wxConfig['api_url']['send_template_message'],
            $param,
            'json'
        );
        if ($result['errcode'] === 0)
        {
            return true;
        }

        throw new Exception($result['errmsg']);
    }
}
