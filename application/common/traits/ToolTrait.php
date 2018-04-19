<?php

namespace app\common\traits;

/**
 * 常用工具
 * User: Wei Zeng
 */
trait ToolTrait
{
    /**
     * 随机字符串生成器
     * @param int $length 长度
     * @param bool $includeSpecial 是否包含特殊字符
     * @return string
     */
    public static function randomStringGenerator($length = 32, $includeSpecial = false)
    {
        // 字符池
        $baseCharPool    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $specialCharPool = '!@#$%^&*()-_';
        $finalCharPool   = $includeSpecial ? $baseCharPool . $specialCharPool : $baseCharPool;

        // 随机获取
        $string         = '';
        $charPoolLength = strlen($finalCharPool);
        for($i = 0; $i < $length; $i++) {
            $string .= $finalCharPool[mt_rand(0, $charPoolLength - 1)];
        }

        return $string;
    }

    /**
     * emoji 过滤器
     * @param string $string 要过滤的字符串
     * @return string
     */
    public static function emojiFilter($string)
    {
        return preg_replace_callback('/./u', function(array $match) {
            return strlen($match[0]) >= 4 ? '' : $match[0];
        }, $string);
    }
}
