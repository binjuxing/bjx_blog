<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/30 0030
 * Time: 9:07
 */

namespace app\api\validate;


class CategoryValidate extends BaseValidate
{
    protected $rule = [
        'id' => 'isPositiveInteger',
        'name' => 'require|length:1,10',
        'description' => 'length:0,50',
        'nav_show' => 'require|in:0,1',
        'sort'=>'require|between:0,99'
    ];
}