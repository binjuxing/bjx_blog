import axios from '@/config/axios'
// console.log(fetch)
// export const test = data => axios({url:'/login/admin',data,"post"});
// 分类
export const getCategory = () => axios('/category/get',{cacheName:'categories'});
export const saveCategory = data => axios('/category/save',{data:data,type:"post"});
// 标签
export const getTag = () => axios('/tag/get',{cacheName:'tags'});
export const saveTag = data => axios('/tag/save',{data:data,type:"post"});
//文章
export const article = data => axios('/article?XDEBUG_SESSION_START=14285',{data:data,cacheName:"articles"});// 文章详情
export const getArticles = data => axios('/article/get',{data:data});
export const upArticleImg = data => axios('/article/upImg',{data:data,type:"post",upType:'img'});
export const saveArticle = data => axios('/article/save?XDEBUG_SESSION_START=11392',{data:data,type:"post"});

