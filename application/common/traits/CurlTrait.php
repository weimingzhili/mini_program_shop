<?php

namespace app\common\traits;

/**
 * Curl
 * User: Wei Zeng
 */
trait Curl
{
    /**
     * 配置
     * @var array
     */
    protected $options = [
        // 超时时间
        CURLOPT_TIMEOUT        => 30,
        // 是否返回结果
        CURLOPT_RETURNTRANSFER => true,
    ];
    /**
     * http get 请求
     * @param string $url 请求地址
     * @param array $param 请求参数
     * @param string $format 结果格式化，支持json，xml
     * @param array $options 配置选项
     * @return mixed
     */
    public function curlGet($url, $param = [], $format = '', $options = [])
    {
        // 初始化
        if (!empty($options))
        {
            $this->options = array_merge($this->options, $options);
        }
        $this->options[CURLOPT_URL] = $url;
        $ch = curl_init();

        // 若有参数
        if (!empty($param))
        {
            $this->options[CURLOPT_URL] .= '?' . http_build_query($param);
        }

        // 设置
        curl_setopt_array($ch, $this->options);

        // 执行
        $result = curl_exec($ch);

        // 关闭
        curl_close($ch);

        // 处理结果
        if (!empty($result) && !empty($format))
        {
            $result = $this->conversionResult($result, $format);
        }

        return $result;
    }
    /**
     * http post 请求
     * @param string $url 请求地址
     * @param array $param 请求参数
     * @param string $format 结果格式化，支持json，xml
     * @param array $options 配置选项
     * @return mixed
     */
    public function curlPost($url, $param = [], $format = '', $options = [])
    {
        // 初始化
        if (!empty($options))
        {
            $this->options = array_merge($this->options, $options);
        }
        $this->options[CURLOPT_URL]  = $url;
        $this->options[CURLOPT_POST] = true;
        $ch = curl_init();

        // 若有参数
        if (!empty($param))
        {
            $this->options[CURLOPT_POSTFIELDS] = $param;
        }

        // 设置
        curl_setopt_array($ch, $this->options);

        // 执行
        $result = curl_exec($ch);

        // 关闭
        curl_close($ch);

        // 处理结果
        if (!empty($result) && !empty($format))
        {
            $result = $this->conversionResult($result, $format);
        }

        return $result;
    }
    /**
     * 转换结果
     * @param string $result 结果
     * @param string $format 转换格式
     * @return mixed
     */
    public function conversionResult($result, $format)
    {
        switch ($format)
        {
            case 'json':
                $result = $this->conversionJsonToArray($result);
                break;
            case 'xml':
                $result = $this->conversionXmlToArray($result);
        }

        return $result;
    }
    /**
     * json 转换成数组
     * @param string $json JSON 数据
     * @return array|bool
     */
    public function conversionJsonToArray($json)
    {
        // 解码
        $result = json_decode($json, true);

        return is_array($result) ? $result : false;
    }
    /**
     * xml 转换成数组
     * @param string $xml XML 数据
     * @return array|bool
     */
    public function conversionXmlToArray($xml)
    {
        // 禁止引用外部xml实体
        libxml_disable_entity_loader(true);

        // 转换
        $result = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        return is_array($result) ? $result : false;
    }
}
