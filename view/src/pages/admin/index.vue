<template>
  <div class="hello">
  <el-row>
    <el-button disabled>默认按钮</el-button>
    <el-button type="primary" disabled>主要按钮</el-button>
    <el-button type="success" disabled>成功按钮</el-button>
    <el-button type="info" disabled>信息按钮</el-button>
    <el-button type="warning" disabled>警告按钮</el-button>
    <el-button type="danger" disabled>危险按钮</el-button>
  </el-row> 
  </div>
</template>

<script>
import {test} from '@/api/index'
export default {
  name: 'adminIndex',
  data () {
    return {
    }
  },
  created(){   
            
    // let res = test({'id':1});
    // res.then(res=>{
    //   console.log(res)
    // })
    // .catch(err=>{
    //   console.log(err)
    // })
            
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
