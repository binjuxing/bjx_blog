<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21 0021
 * Time: 20:47
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model
{
    public static function updateTime($field,$bol = true){
        $upTime = cache('update_time');
        $time = time();
        if(!$upTime){
            $upTime = [
                'categories'=>$time,
                'tags'=>$time,
            ];
        }else{
            if($bol||!isset($upTime[$field])){
                $upTime[$field] = $time;
            }
        }
        cache('update_time',$upTime,0);
        if(!$bol)
            return $upTime[$field];
    }
}