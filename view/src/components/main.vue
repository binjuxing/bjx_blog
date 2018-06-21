<template>
<div style="height: 100%;width: 100%;" v-loading="$store.state.loading">
  <div v-if="$store.state.isAdmin" class="admin">
    <aheader></aheader>
    <el-container>
      <amenu></amenu>
      <el-container style="position: relative;min-height: 500px;" :style="{height: $store.state.fullHeight-50+'px'}">
      <Breadcrumb class="breadcrumb"></Breadcrumb>
        <el-main style="margin-bottom: 50px;height: 0;" >
          <keep-alive>
                  <router-view v-if="$route.meta[1]"></router-view>
          </keep-alive>
              <router-view v-if="!$route.meta[1]"></router-view>
        </el-main>
        <el-footer style="position: absolute;bottom: 0px;width: 100%;min-width:757px;height: 50px;background:  rgba(123,123,123,.1);text-align: center;line-height: 50px;">
        <a href="###">Jayson</a>
        </el-footer>
      </el-container>
    </el-container>
  </div>

    
  <div v-else class="pages">
    <pheader></pheader>
    <Breadcrumb class="breadcrumb"></Breadcrumb>
    <el-container class="home-con" :style="homeCon">
      <keep-alive>
        <router-view class="left-view"></router-view>
      </keep-alive>
      <rightbox class="right"></rightbox>
    </el-container>
    <el-footer class="efooter" >
    本博客使用Vue+Element+thinkPHP搭建 © 2017-2018 ICP证：粤ICP备12345678号
    联系邮箱：jsonbin@163.com
    </el-footer>
  </div>
</div>
 
</template>

<script>

import Aheader from '@/components/Aheader'
// import Container_title from '@/components/container_title'
import Amenu from '@/components/Amenu'
import Pheader from '@/components/Pheader'
import Breadcrumb from '@/components/Breadcrumb'
import rightbox from "@/pages/home/right"
// import Page_title from '@/components/page_title'
// import Del_dialog from '@/components/del_dialog'
import {test} from '@/api/index'
export default {
  // name: 'main',
  data(){

    return {
      isLogin:false,
      homeconH:0,
    }
  },
  components:{
    Aheader,
    Amenu,
    Breadcrumb,
    // Container_title,
    // Page_title,
    // Del_dialog,
    Pheader,
    rightbox
  },
  created(){
    this.$store.commit("saveUserInfo")
    // this.$store.commit("loading")
    // setTimeout(()=>{
    //   this.$store.commit("loading",false)
    // },500)
    // console.log(this.$store.state.userInfo)
    // let res = test({'id':1});
    // res.then(res=>{
    //   console.log(res)
    // })
    // .catch(err=>{
    //   console.log(err)
    // })
    if(this.$route.path.indexOf('/admin/')===0){
        this.$store.commit("isAdmin",true);
      }
    
  },
  computed:{
    homeCon(){
      var fH = this.$store.state.fullHeight;

      if(this.homeconH&&fH-100>this.homeconH){
        return{'min-height':fH-156+'px'};
      }
      // return this.$store.state.fullHeight
      return{height:'auto'};
    }
  },
  methods:{
    check_login(){
      var token_time = sessionStorage.getItem('token_time');
      if (Date.now()-token_time>21600*1000) {        
        this.$router.push({name:"login"})
      }else{

      }
    },
  },
  mounted(){
    window.onresize = () => {
      if(!this.timer1) {
        var w = document.documentElement.clientWidth
        var h = document.documentElement.clientHeight
          if(w!=this.$store.state.fullWidth)this.$store.commit("fullw",w);
          if(h!=this.$store.state.fullHeight)this.$store.commit("fullh",h)
          this.timer1 = true;
          setTimeout(()=>{
            this.timer1 = false
          },30)
        }
    }
    if(!this.$store.state.isAdmin){
      this.homeconH = document.querySelector('.home-con').offsetHeight;
    }
    
  },
  watch:{
    '$route':function (router) {
      if(router.path.indexOf('/admin/')===0){
        this.$store.commit("isAdmin",true);
      }else{
        this.$store.commit("isAdmin")
      }
      
      if (router.meta.title) {
        document.title = router.meta.title+'-xx博客'
      }
    },
  }
}
</script>

<style>
.admin{min-width: 800px;}
.fheader{width: 100%;}
.home-con ,.breadcrumb{max-width:1200px;width:100%;margin:0 auto;}
.admin .breadcrumb{width:99.8%;min-width: 757px;max-width: none;}

.home-con{min-height: 500px;}
.left-view{width:69.4%;min-width: 300px;padding-top: 20px;}
.right{width: 30%;padding: 20px 0 0 1.6%;}
/*.breadcrumb{margin-top: 1px;}*/
.efooter{text-align: center;height: 50px!important;width: 100%;line-height: 50px;}
@media screen and (max-width: 960px) {
    .home-con{width: 950px;padding: 0 5px;}
    .el-header,.efooter{width:960px;}
}
@media screen and (max-width: 640px) {
  .home-con{width:98%;padding:0 1%;}
  .breadcrumb{padding:0;width:99%;}
  .right {display: none;position: fixed;}
  .left-view,.el-header,.efooter{width:100%;}
  .efooter{line-height: normal;}
}
</style>
