<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
//use think\facade\Route;
//Route::get('think', function () {
//    return 'hello,ThinkPHP5!';
//});
//Route::get('hello/:name', 'index/index/hello');

/*
 * Login
 * */
Route::group('login',function(){
    // 用户登录
    Route::post('/admin','login/admin');
    // 获取验证码
    Route::get('/code','login/code');
});
/*
 * User
 * */
Route::group('user',function(){
    // 用户登录
    Route::post('/login','user/login');
    // 获取验证码
    Route::get('/code','user/code');
});
/*
 * Category
 * */
Route::group('category',function(){
    // 获取所有分类
    Route::get('/get','category/get');
    // 保存分类
    Route::post('/save','category/save');

});
/*
 * Tag
 * */
Route::group('tag',function(){
    // 获取所有标签
    Route::get('/get','tag/get');
    // 保存标签
    Route::post('/save','tag/save');

});
/*
 * Article
 * */
Route::group('article',function(){
    // 文章详情
    Route::get('', 'article/get');
    // 文章列表
    Route::get('/get', 'article/gets');
    // 图片上传
    Route::post('/upImg', 'article/upImg');
    // 保存文章
    Route::post('/save','article/save');
});

