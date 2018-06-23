<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21 0021
 * Time: 20:48
 */

namespace app\api\model;


use app\lib\exception\BaseException;
use think\model\concern\SoftDelete;

class Article extends BaseModel
{
    protected $autoWriteTimestamp = true;
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $hidden = ['delete_time'];
    /*
     * 获取文章
     * */
    public static function getArticles($page,$category_id,$tag,$key){
        $article = self::with('tags');
        if($tag!=''){
//            $article->hasWhere()
        }else{
            if($category_id!='')
                $article->where('category_id',$category_id);
            if($key!='')
                $article->where('title|keywords','like','%'.$key.'%');
        }
        return $article->paginate(['page'=>$page,'list_rows'=>10]);
    }
    public static function getArticle($id){
        $article = cache('article_'.$id);
        if(!$article){
            $article = self::with('tags')->where('id',$id)->find();
            if($article)
                cache('article_' . $id, json_encode($article->toArray()), 86400);
            else
                throw new BaseException('请求的文章不存在');
        }
        return $article;
    }
    /*
     * 保存文章
     * */
    public function saveArticle($data){
        // 是否新增
        $new  = !isset($data['id'])||$data['id']=='';
        $data['user_id'] = 1;
        if($new){
            $article = self::allowField(true)->create($data);
            if($article) {
                $this->articleTag($article->id, $data['tag']);
                if($article->id)
                    cache('article_id',++$article->id,0);// 更新id
            }
        }else{
            $article = self::allowField(true)->update($data,['id'=>$data['id'],'user_id'=>$data['user_id']]);
            if($article){
                $this->articleTag($data['id'],$data['tag']);
            }
        }
        if($article->id)
        cache('article_'.$article->id,null);// 清除文章缓存，下次直接请求数据库
        return $article;
    }
    /*
     * 添加关联标签
     * */
    public function articleTag($id,$tags){
        $articleTag = new ArticleTag();
        // 先删后加
        $articleTag->where('article_id',$id)->delete();
        $data = [];
        foreach($tags as $v){
            $data[] = ['article_id'=>$id,'tag_id'=>$v];
        }
        $articleTag->saveAll($data);
    }
    public function tags(){
        return $this->hasMany('ArticleTag','article_id','id');
    }
}