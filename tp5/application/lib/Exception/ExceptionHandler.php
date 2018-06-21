<?php
/**
 * Created by 七月.
 * Author: 七月
 * Date: 2017/4/24
 * Time: 3:33
 */

namespace app\lib\exception;


use think\Exception;
use think\exception\Handle;
use think\facade\Log;
use think\facade\Request;
use think\facade\Env;

class ExceptionHandler extends Handle
{

    private $code;
    private $msg;
    private $errorCode;

    // 需要返回客户端当前请求的URL路径
    public function render(\Exception $e)
    {
        if ($e instanceof BaseException)
        {
            //如果是自定义的异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }
        else
        {
            if (config('app_debug'))
            {
                return parent::render($e);
            }
            else
            {
                $this->code = 500;
                $this->msg = '服务器内部错误，请联系维护人员';
                $this->errorCode = 999;
                $this->recordErrorLog($e);
            }
        }
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => Request::url()
        ];
        return json($result, $this->code);
    }

    private function recordErrorLog(\Exception $e)
    {
        Log::init(
            [
                'type' => 'File',
                'path' => Env::get('LOG_PATH'),
                'level' => ['error']
            ]);
        Log::record($e->getMessage(), 'error');
    }
}