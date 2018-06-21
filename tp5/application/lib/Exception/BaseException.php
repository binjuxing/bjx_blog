<?php
/**
 * Created by 七月.
 * Author: 七月
 * Date: 2017/4/24
 * Time: 3:52
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    // HTTP 状态码 404,200
    public $code = 200;

    // 错误具体信息
    public $msg = '出错了';

    // 自定义的错误码
    public $errorCode = 10000;

    public function __construct($params = []){
        if( !is_array($params)){
            if(is_string($params))$this->msg = $params;
        }else{
            if(array_key_exists('code',$params)){
                $this->code = $params['code'];
            }

            if(array_key_exists('msg',$params)){
                $this->msg = $params['msg'];
            }

            if(array_key_exists('errorCode',$params)){
                $this->errorCode = $params['errorCode'];
            }
        }

    }

}