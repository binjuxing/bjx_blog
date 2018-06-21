<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21 0021
 * Time: 22:48
 */

namespace app\api\behavior;


class Run
{
    public function appInit($params)
    {
        if(config('secure.cross_domain')){

            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Headers: token,Origin, X-Requested-With, Content-Type, Accept, Authorization");
            header('Access-Control-Allow-Methods: POST,GET,PUT,DELETE');
            if(request()->isOptions()){
                exit();
            }
        }

    }

//    public function appEnd($params)
//    {
//
//    }
}