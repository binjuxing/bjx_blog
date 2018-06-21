<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * @param string $url post请求地址
 * @param array $params
 * @return mixed
 */
function curl_post($url, array $params = array())
{
    $data_string = json_encode($params);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt(
        $ch, CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json'
        )
    );
    $data = curl_exec($ch);
    curl_close($ch);
    return ($data);
}
/**
 * @param string $url get请求地址
 * @param int $httpCode 返回状态码
 * @return mixed
 */
function curl_get($url, &$httpCode = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //false不做证书校验,部署在linux环境下请改为true
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $file_contents = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $file_contents;
}
/*
 * 随即字符串生成函数
 * @param int length 字符串长度
 * @param int type 模式 1纯数字，2纯字母，3小写加数字，4全部混合
 * */
function getRandChar($length=32,$type=4)
{
    $str = null;
    $s1 = '0123456789';
    $s2 = 'abcdefghijklmnopqrstuvwxyz';
    $s3 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    if($type==1){
        $strPol = $s1;
    }elseif($type==2){
        $strPol = $s2.$s3;
    }elseif($type==3){
        $strPol = $s1.$s2;
    }else{
        $strPol = $s1.$s2.$s3;
    }
    $max = strlen($strPol) - 1;
    for ($i = 0;
         $i < $length;
         $i++) {
        $str .= $strPol[rand(0, $max)];
    }
    return $str;
}