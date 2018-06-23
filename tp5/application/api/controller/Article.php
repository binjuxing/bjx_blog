<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22 0022
 * Time: 17:49
 */

namespace app\api\controller;

use app\api\service\Img;
use app\api\validate\ArticleValidate;
use think\Request;
use app\api\model\Article as ArticleModel;

class Article extends BaseController
{
    /*
     * 获取文章列表
     * @url get article/get
     * */
    public function gets($page = 1,$category_id = '', $tag = '', $key = ''){
        $res = ArticleModel::getArticles($page,$category_id,$tag,$key);
        return $this->returnData($res);
    }
    /*
     * 文章详情
     * @url get article
     * */
    public function get($id){
        $res = ArticleModel::getArticle($id);
        return $this->returnData($res);
    }
    /*
     * 上传文章图片
    */
    public function upImg($id = ''){
        $res =  (new Img())->upload($id);
        return $this->returnData($res);
    }
    public function save(){
        $data = $this->getValidateData(new ArticleValidate());
        $res = (new ArticleModel)->saveArticle($data);
        return $this->returnData($res);
    }
}