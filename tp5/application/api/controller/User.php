<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21 0021
 * Time: 21:11
 */

namespace app\api\controller;


use app\lib\enum\Scope;
use think\captcha\Captcha;

class User extends BaseController
{
    public function login(){

    }
    /*
     * 验证码获取
     * @url get pc/user/code
     * */
    public function code(){
        $captcha = new Captcha();
        $captcha->expire = 300;//验证码有效时间
        if(config('secure.cross_domain'))
            $captcha->type = 'cache';// 验证码验证方式 session/cache  跨域用cache
        $captcha->fontSize = 36;//字体大小
        $captcha->length   = 4; // 验证码长度
        return $captcha->entry();
    }
}