<?php

namespace app\common\validate;

use think\Validate;

/**
 * 基础
 * User: Wei Zeng
 */
class BaseValidate extends Validate
{
    /**
     * 正整数验证规则
     * @param mixed $value 验证参数
     * @param string $rule 验证规则
     * @param array $data 所有的验证参数
     * @param string $field 验证的参数名
     * @return bool|string
     */
    protected function positiveInteger($value, $rule, $data, $field)
    {
        return is_numeric($data[$field]) && is_int($data[$field] + 0) && $data[$field] > 0 ? true : $field . '必须是正整数';
    }

    /**
     * 手机号码验证规则
     *
     * @param mixed $value 验证参数
     * @param string $rule 验证规则
     * @param array $data 所有的验证参数
     * @param string $field 验证的参数名
     * @return bool|string
     */
    protected function mobile($value, $rule, array $data, $field)
    {
        return is_null($data[$field]) || preg_match('^1(3|4|5|7|8)[0-9]\d{8}$^', $data[$field]) ? true : $field . '不是正确的手机号码';
    }
}
