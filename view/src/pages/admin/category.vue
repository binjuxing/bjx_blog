<template>
	<el-table
    :data="categories"
    border
    style="width: 100%">
    <el-table-column
      prop="id"
      label="id">
    </el-table-column>
    <el-table-column
      prop="name"
      label="分类名">

    </el-table-column>
    <el-table-column
      prop="nav_show"
      label="导航显示">
      <template slot-scope="scope">
        <i class="el-icon-success" v-if="scope.row.nav_show" style="color:#82de82;font-size: 22px;"></i>
      </template>
    </el-table-column>
    <el-table-column
      prop="sort"
      label="排序">
    </el-table-column>
    <el-table-column
      prop="create_time"
      label="创建时间">
    </el-table-column>
    <el-table-column
      prop="update_time"
      label="更新时间">
    </el-table-column>
    <el-table-column
      fixed="right"
      label="操作">
      <template slot-scope="scope">
        <el-button type="info" size="small" icon="el-icon-edit" @click="eidt(scope.row)"></el-button>
      </template>
    </el-table-column>
  </el-table>
</template>
<script>

import {getCategory} from '@/api/index'
	export default{
		data(){
			return {
				categories:[],
			}
		},
		created(){
			this.getData()
		},
		methods:{
			getData(){
				let res = getCategory();
				res.then(res=>{
					console.log(res)
					let data = res.data;
					if(Number(data.error_code)===0){
						this.categories = data.data;
					}else{
						this.$message({type: 'info',message: data.msg,duration:1500});
					}
				})
			},
			eidt(row){
				this.$store.commit('editData',row);
				this.$router.push('/admin/category/'+row.id)
			}
		}
	}
</script>