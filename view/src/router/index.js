import Vue from 'vue'
import Router from 'vue-router'
import Main from '@/components/main'
// 后台管理
import adminIndex from '@/pages/admin/index'
import adminArticle from '@/pages/admin/article'
import adminArticleEdit from '@/pages/admin/articleEdit'
import adminCategory from '@/pages/admin/category'
import adminCategoryEdit from '@/pages/admin/categoryEdit'
import adminTag from '@/pages/admin/tag'
import adminTagEdit from '@/pages/admin/tagEdit'
// 前端
import home from '@/pages/home/home'
import article from '@/pages/home/article'

Vue.use(Router)

const mainRouter = [
  {
    path: 'home',
    name: 'home',
    component: home,
    meta:{title:"首页"},
  },
  {
    path: 'home/category/:id',
    name: 'category',
    component: home,
    meta:{title:"文章分类"},
  },{
    path: 'home/tag/:id',
    name: 'tag',
    component: home,
    meta:{title:"文章标签"},
  },
  {
    path: 'home/search/:keyword',
    name: 'search',
    component: home,
    meta:{title:"文章搜索"}
  },
  {
    path: '/article/:id',
    name: 'article',
    component: article,
    meta:{title:"文章详情"}
  },

  {
    path: 'admin/index',
    name: 'adminIndex',
    component: adminIndex,
    meta:{title:"后台首页"}
  },
  {
    path: 'admin/article',
    name: 'adminArticle',
    component: adminArticle,
    meta:{title:"文章"}
  },
  {
    path: 'admin/article/add',
    name: 'adminArticleAdd',
    component: adminArticleEdit,
    meta:{title:"文章编辑"}
  },
  {
    path: 'admin/article/edit',
    name: 'adminArticleEdit',
    component: adminArticleEdit,
    meta:{title:"文章编辑"}
  },
  {
    path: 'admin/category',
    name: 'adminCategory',
    component: adminCategory,
    meta:{title:"分类"}
  },
  {
    path: 'admin/category/add',
    name: 'adminCategoryAdd',
    component: adminCategoryEdit,
    meta:{title:"新增分类"}
  },
  {
    path: 'admin/category/:id',
    name: 'adminCategoryEdit',
    component: adminCategoryEdit,
    meta:{title:"分类编辑"}
  },
  {
    path: 'admin/tag',
    name: 'adminTag',
    component: adminTag,
    meta:{title:"标签"}
  },
  {
    path: 'admin/tag/add',
    name: 'adminTagAdd',
    component: adminTagEdit,
    meta:{title:"新增标签"}
  },
  {
    path: 'admin/tag/:id',
    name: 'adminTagEdit',
    component: adminTagEdit,
    meta:{title:"标签编辑"}
  },

]
export default new Router({
  routes: [
    {
      path: '/',
      name: 'Main',
      redirect: '/home',
      component: Main,
      children:mainRouter
    }
  ]
})
