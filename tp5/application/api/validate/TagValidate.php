<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/30 0030
 * Time: 17:24
 */

namespace app\api\validate;


class TagValidate extends BaseValidate
{
    protected $rule = [
        'id' => 'isPositiveInteger',
        'name' => 'require|length:1,10',
    ];
    protected $message = [
        'id' => 'id必须是正整数',
        'name' => '标签名必须有，且长度1~10',
    ];

}