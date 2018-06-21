<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22 0022
 * Time: 21:16
 */

namespace app\api\controller;


use app\lib\exception\TokenException;

class Login extends BaseController
{
    public function admin(){
        throw new TokenException();
    }
}