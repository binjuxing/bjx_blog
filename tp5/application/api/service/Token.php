<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21 0021
 * Time: 18:07
 */

namespace app\api\service;


use app\lib\exception\BaseException;
use app\lib\exception\TokenException;
use think\facade\Request;

class Token
{
    // 生成token
    public static function generateToken()
    {
        //随机字符串 length = 32
        $randChars = getRandChar();
        //请求开始时的时间戳
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //salt 盐
        $salt = config('secure.token_salt');
        return md5($randChars . $timestamp . $salt);
    }
    /*
     * 获取缓存中的值
     * @param string $key         需要获取的值名，为空则返回全部值
     * @param bool   $isInterrupt 获取不到缓存值时，中断程序（true）,不中断（false）返回false
     * */
    public static function getCache($key = '',$isInterrupt = true)
    {
        $token = Request::header('token');
        $vars = Cache($token);
        if (!$vars) {
            if($isInterrupt)
                throw new TokenException();
            else
                return false;
        }else{
            if (!is_array($vars))
                $vars = json_decode($vars, true);
            if($key=='')
                return $vars;
            if (array_key_exists($key, $vars))
                return $vars[$key];
            elseif($isInterrupt)
                throw new BaseException('尝试获取的Token变量并不存在');
        }
        return false;
    }
}