<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21 0021
 * Time: 17:31
 */

namespace app\api\controller;


use app\api\model\BaseModel;
use think\Controller;

class BaseController extends Controller
{
    /*
     * 获取通过验证的数据
     * @param object $validate 验证器
     * */
    protected function getValidateData($validate){
        $params = $validate->goCheck();
        return $validate->getDataByRule($params);
    }
    /*
     * 返回客户端的数据处理
     * @param array|object $data 返回客户端的数据
     * @param string       $upTimeFiled 数据更新字段
     * @param int          $errorCode 错误码，默认为0（成功）
     * */
    protected function returnData($data = [],$upTimeFiled='',$errorCode = 0){
        $data = ['error_code'=>$errorCode,'data'=>$data];
        if($upTimeFiled!=''){
            $data['update_time'] = BaseModel::updateTime($upTimeFiled,false);
        }
        return $data;
    }
    /*
     * 返回客户端的状态处理
     * @param boll $status 需要处理的状态
     * */
    protected function returnStatus($status){
        if($status){
            return ['error_code'=>0,'msg'=>'成功'];
        }
        return ['error_code'=>10000,'msg'=>'失败'];
    }
    /***用户权限校验***/

    // 是否登录
    protected function checkLogin(){

    }
    // 超级管理员
    protected function checkSuper(){

    }
}