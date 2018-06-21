<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/30 0030
 * Time: 17:04
 */

namespace app\api\controller;

use app\api\model\Tag as TagModel;
use app\api\validate\TagValidate;

class Tag extends BaseController
{
    /*
     * 获取标签
     * @url post tag/get
     * */
    public function get(){
        $res = TagModel::getAll();
        return $this->returnData($res,'tags');
    }
    /*
     * 保存标签
     * @url post tag/save
     * */
    public function save(){
        $data = $this->getValidateData(new TagValidate());
        $status = (new TagModel())->saveTag($data);
        return $this->returnStatus($status);
    }
}