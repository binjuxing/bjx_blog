<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21 0021
 * Time: 21:13
 */

namespace app\api\validate;


class UserValidate extends BaseValidate
{
    protected $rule = [
        'username' => 'require|length:4,16|alphaNum',
        'password' => 'require|length:6,18',
        'code|验证码'=>'require|checkCode'
    ];
    protected $rules = [

    ];
    public function __construct($key = ''){
        if($key!=''){
            $this->rule = $this->rules[$key];
        }
    }
}