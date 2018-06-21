<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22 0022
 * Time: 18:23
 */

namespace app\api\service;


use app\api\model\Article;
use think\facade\Env;

class Img
{
    public function upload($id){
        $path = $this->getPath($id);
        $imgPath = Env::get('ROOT_PATH').'public/images/';
        $file = request()->file('image');
//        if(is_array($file)){
//            foreach($file as $v){
//                $file = $v;
//                break;
//            }
//        }
        $file->validate(['size'=>1048576,'ext'=>'jpg,png,gif']);
        $info = $file->getInfo();
        $fileName = getRandChar(3,2).substr(time(),5).'.'
            .pathinfo($info['name'], PATHINFO_EXTENSION);
        $status = $file->move($imgPath. $path,$fileName);
        return ['url'=>config('app_host').'public/images/'.$path.'/'.$fileName];
    }
    public function getPath($id){
        $id = $id!=''&&is_int($id)?$id:cache('article_id');
        if(!$id){
            $article = Article::order('id desc')->find();
            $id = $article?$article->id:1;
            cache('article_id',$id,0);
        }
        return 'article/'.$id;
    }
}