<template>

  <el-header style="text-align: right;height: 50px;background: rgb(67,74,80);color: white;">
    <div style="float: left;margin-top: 10px;">
      <i class="el-icon-star-on" style="font-size:30px;color: white"></i>
      <span style="font-size:25px;">管理后台 </span>
    </div>
    <div style="display: inline-block;line-height: 50px;margin-right: 20px;cursor: pointer;">
      <span> <i class="icon iconfont icon-yonghutouxiang"></i> Admin</span> | 
      <span @click="go('home')">前端</span>
    </div>
  </el-header>

  

</template>

<script>
export default {
  name: 'headers',
  data () {
    return {
      
    }
  },
  methods:{
    go(name){
      this.$router.push({name:name})
    },
    // exit(){
    //   sessionStorage.clear();
    //   this.$router.push("login")
    // }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
