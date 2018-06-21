<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/30 0030
 * Time: 8:54
 */

namespace app\api\controller;


use app\api\validate\CategoryValidate;
use app\api\model\Category as CategoryModel;

class Category extends BaseController
{
    /*
     * 获取分类
     * @url post category/get
     * */
    public function get(){
        $res = CategoryModel::cacheCategories();
        return $this->returnData($res,'categories');
    }
    /*
     * 保存分类
     * @url post category/save
     * */
    public function save(){
        $data = $this->getValidateData(new CategoryValidate());
        $status = (new CategoryModel)->saveCategory($data);
        return $this->returnStatus($status);
    }
}