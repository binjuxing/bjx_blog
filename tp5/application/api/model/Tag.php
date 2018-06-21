<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21 0021
 * Time: 20:51
 */

namespace app\api\model;


use app\lib\exception\BaseException;
use think\model\concern\SoftDelete;

class Tag extends BaseModel
{
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $hidden = ['delete_time'];
    /*
     * 获取所有标签
     * */
    public static function getAll(){
        $categories = cache('categories');
        if(!false){
            $categories = self::cacheTags();
        }
        return $categories;
    }
    public function saveTag($data){

        // 是否新增
        $new  = !isset($data['id'])||$data['id']=='';
        if($new){
            $this->checkName($data['name']);
            $statue = self::create($data);
        }else{
            $this->checkName($data['name'],$data['id']);
            $statue = self::update($data);
        }
        if($statue){
            // 更新缓存
            self::cacheTags();
        }
        return $statue;
    }
    /*
     * 标签名重复检查
     * $param string $name 标签名
     * $param int    $id   标签id
     * */
    protected function checkName($name,$id=0){
        if(self::whereNotIn('id',$id)->where('name',$name)->find()){
            throw new BaseException('标签名已存在，换一个吧');
        }
        return true;
    }
    /*
     * 缓存标签信息
     * */
    public static function cacheTags(){
        $tags = self::withCount('article')->select();
        $data = [];
        foreach($tags as $v){
            $data[] = $v->toArray();
        }
        cache('tags',$data,0);
        self::updateTime('tags');
        return $tags;
    }
    public function article(){
        return $this->hasMany('ArticleTag','tag_id','id');
    }
}