<template>  
<div class="menu">
  <el-menu
    class="el-menu-vertical-demo"
    @open="handleOpen"
    @close="handleClose"
    :collapse="isCollapse"
    background-color="#545c64"
    text-color="#fff"
    active-text-color="#ffd04b">
      <div  class="el-menu-item collapse" @click="isCollapse=!isCollapse">
        <i v-if="isCollapse" class='el-icon-d-arrow-right'></i>
        <i v-else class='el-icon-d-arrow-left'></i>
      </div>
      <el-menu-item index="1" @click="go('adminIndex')">
        <i class="el-icon-star-on"></i>
        <span slot="title">首 页</span>
      </el-menu-item>
      <el-submenu index="1" >
        <template slot="title">
          <i class="el-icon-document"></i>
          <span>文 章</span>
        </template>
        <el-menu-item-group>
          <el-menu-item index="1-1" @click="go('adminCategory')" >分类</el-menu-item>
          <el-menu-item index="1-2" @click="go('adminTag')">标签</el-menu-item>
          <el-menu-item index="1-3" @click="go('adminArticle')">文章</el-menu-item>
        </el-menu-item-group>
      </el-submenu>
      <!-- <el-menu-item index="2">
        <i class="el-icon-menu"></i>
        <span slot="title">导航二</span>
      </el-menu-item>
      <el-menu-item index="3" disabled>
        <i class="el-icon-document"></i>
        <span slot="title">导航三</span>
      </el-menu-item> -->
      <el-menu-item index="4">
        <i class="el-icon-setting"></i>
        <span slot="title">设 置</span>
      </el-menu-item>
    </el-menu>
    </el-menu-item>
</div>

</template> 

<style>
  /*.menu{position: relative;flex:1;display: flex;flex-direction: column;}*/

  .el-menu-vertical-demo{min-height: 400px;height: 100%;overflow-y: auto;font-size: 28}
  .el-menu--collapse{overflow:visible;}
  .el-menu-vertical-demo:not(.el-menu--collapse) {
    width: 200px;    
  }
  .collapse{text-align: center;}
  .collapse:hover{
    background: rgb(67,74,80);
  }
  /*.collapse{margin-top: -40px;}*/
</style>

<script>
  export default {
    data() {
      return {
        isCollapse: false,
      };
    },
    created(){
    },
    methods: {
      change() {
        this.isCollapse=!this.isCollapse
      },
      go(url){
        this.$router.push({name:url})
      },
      handleOpen(key, keyPath) {
        // console.log(key, keyPath);
      },
      handleClose(key, keyPath) {
        // console.log(key, keyPath);
      }
    },
  }
</script>