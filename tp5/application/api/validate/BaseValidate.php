<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21 0021
 * Time: 17:12
 */

namespace app\api\validate;


use app\lib\exception\BaseException;
use app\lib\exception\ParameterException;
use think\captcha\Captcha;
use think\facade\Request;
use think\Validate;

class BaseValidate extends Validate
{
    /*
     * 参数校验
     * $params array 校验参数
     * */
    public function goCheck($params = [])
    {
        if(empty($params)){
            // 获取api传入的参数
            $request = Request::instance();
            $params = $request->param();
        }
        // 多参数校验
        $result = $this->batch()
            ->check($params);
        if (!$result)
        {
            $e = new ParameterException(
                [
                    'msg' => $this->error,
                ]);
            throw $e;
        }
        else
        {
            return $params;
        }
    }
    /*
     * 参数过滤，过滤不必要的参数
     * */
    public function getDataByRule($arrays)
    {
        $newArray = [];
        foreach ($this->rule as $key => $value)
        {
            $key = trim(explode('|',$key)[0]);
            if(array_key_exists($key,$arrays)){
                $newArray[$key] = $arrays[$key];
            }
        }
        return $newArray;
    }
    // 验证码校验
    public function checkCode($value){
        $captcha = new Captcha();
        $bol = config('secure.cross_domain')?$captcha->checkCode($value):$captcha->check($value);
        if(!$bol){
            throw new BaseException([
                'errorCode'=>10005,
                'msg' => '验证码错误'
            ]);
        };
        return true;
    }
    // 正整数校验
    protected function isPositiveInteger($value){
        if(is_numeric($value) && is_int($value+0)&&($value+0)>0){
            return true;
        }
        return false;
    }
    // 手机号码校验
    protected function isMobile($value)
    {

        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    // 密码正则校验
    protected function checkPwd($value){
        if (!preg_match("/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z\_\!\@\#\?\*]{6,18}$/", $value)){
            throw new BaseException(['msg'=>'密码必须包含数字和字母，长度：6~18，可用特殊字符：_!@#?*']);
        }
        return true;

    }
    // 不作参数校验
    protected function notCheck($value){
        return true;
    }
}