<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21 0021
 * Time: 20:49
 */

namespace app\api\model;


use app\lib\exception\BaseException;
use think\model\concern\SoftDelete;

class Category extends BaseModel
{
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $hidden = ['delete_time'];
    public function saveCategory($data){
        // 是否新增
        $new  = !isset($data['id'])||$data['id']=='';
        if($new){
            $this->checkName($data['name']);
            $this->checkNavShow($data['nav_show']);
            $statue = self::create($data);
        }else{
            $this->checkName($data['name'],$data['id']);
            $this->checkNavShow($data['nav_show'],false);
            $statue = self::update($data);
        }
        if($statue){
            // 更新缓存
            self::cacheCategories();
        }
        return $statue;
    }
    /*
     * 获取所有分类
     * */
    public static function getAll(){
        $categories = cache('categories');
        if(!false){
            $categories = self::cacheCategories();
        }
        return $categories;
    }
    /*
     * 分类名重复检查
     * $param string $name 分类名
     * $param int    $id   分类id
     * */
    protected function checkName($name,$id=0){
        if(self::whereNotIn('id',$id)->where('name',$name)->find()){
            throw new BaseException('分类名已存在，换一个吧');
        }
        return true;
    }
    /*
     * 前端导航显示检查
     * $param  int  $navShow  0或1 1为显示
     * $param  bool $new      是否新增
     * */
    protected function checkNavShow($navShow,$bol=true){
        $num = $bol?0:1;
        if($navShow==1&&self::where('nav_show',1)->count()>6-$num){
            throw new BaseException('导航最多可显示六个');
        }
        return true;
    }
    /*
     * 缓存分类信息
     * */
    public static function cacheCategories(){
        $categories = self::order('nav_show desc,sort desc')->select();
        $data = [];
        foreach($categories as $v){
            $da = $v->toArray();
            $da['nav_show'] = $da['nav_show']==0?false:true;
            $data[] = $da;
        }
        cache('categories',$data,0);
        self::updateTime('categories');
        return $data;
    }
}