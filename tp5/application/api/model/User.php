<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21 0021
 * Time: 20:48
 */

namespace app\api\model;


class User extends BaseModel
{
    public function add(){
        $data = ['username' => 'binjuxing',
            'password' => self::encrypt('bjx5031958'),
            'name' => 'Jayson',
            'scope' => 99,
            'status' => 1,
            'create_time' => time()
        ];
        self::create($data);
    }
    /*
     * 密码加密
     * */
    public static function encrypt($password){
        return md5(sha1($password.config('secure.pwd_salt')));
    }
}