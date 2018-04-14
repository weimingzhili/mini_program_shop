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
        return is_numeric($value) && is_int($value + 0) && $value > 0 ? true : $field . '必须是正整数';
    }
}
