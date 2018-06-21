<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21 0021
 * Time: 20:48
 */

namespace app\api\model;


class Article extends BaseModel
{
    /*
     * 获取文章
     * */
    public static function getArticle($page,$category_id,$tag,$key){
        $article = self::with('tags');
        if($tag!=''){
//            $article->hasWhere()
        }else{
            if($category_id!='')
                $article->where('category_id',$category_id);
            if($key!='')
                $article->where('title|keywords','like','%'.$key.'%');
        }
        $article->paginate(['page'=>$page,'list_rows'=>10]);

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
            $article = self::where(['id'=>$data['id'],'user_id'=>$data['user_id']])->allowField(true)->update($data);
            if($article){
                $this->articleTag($data['id'],$data['tag']);
            }
        }
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