<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/31 0031
 * Time: 22:48
 */

namespace app\api\validate;


class ArticleValidate extends BaseValidate
{
    protected $rule = [
        'id' => 'isPositiveInteger',
        'title' => 'require|length:2,50',
        'author' => 'require|length:1,50',
        'category_id' => 'require|isPositiveInteger',
        'tag'=>'require|array|length:1,3',
        'keywords'=>'require|length:1,30',
        'cover'=>'require',
        'is_show'=>'require|in:0,1',
        'is_top'=>'require|in:0,1',
        'recommend'=>'require|in:0,1',
        'markdown'=>'require'
    ];
}