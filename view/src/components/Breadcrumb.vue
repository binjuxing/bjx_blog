<template>
	<el-card shadow="always" style="position: relative;height: 54px;margin-bottom: 0;" >
    <el-breadcrumb separator-class="el-icon-arrow-right"  class="zbreadcrumb">

		  <el-breadcrumb-item :to="{ path: $store.state.isAdmin?'/admin/index':'/home' }" v-show="$route.name!='home'&&$route.name!='adminIndex'">首页</el-breadcrumb-item>
		  <el-breadcrumb-item>{{$route.meta.title}}</el-breadcrumb-item>
		  <!-- <el-breadcrumb-item>分类详情</el-breadcrumb-item> -->
		</el-breadcrumb>
		<div v-show="$store.state.isAdmin&&showAdd()" class="ablack addbtn">
			<el-button size="small" plain type="info" @click="$router.push({name:pathName})">{{addName}}</el-button>
		</div>
		<div :class="$store.state.isAdmin?'ablack':'pblack'">
			<el-button size="small" type="info" v-show="$route.name!='home'" @click="$router.back(-1)">返回</el-button>
		</div>
		<div class="search" @keyup.13="searching()" v-show="!$store.state.isAdmin">
			<el-input placeholder="请输入内容" v-model="search" clearable class="input-with-select" size="small">
		    <!-- <template slot="prepend">Http://</template> -->
		    <el-button slot="append" icon="el-icon-search" @click="searching()"></el-button>
	  	</el-input>
	  </div>
   </el-card>
</template>
<script>
	export default{
		data(){
			return {
				search:'',
				show_add:[
					'adminCategory',
					'adminTag',
					'adminArticle',
				],
				addName:'添加',
				pathName:'',
			}
		},
		created(){
		},
		computed:{
			route(){

			}
		},
		methods:{
			searching(){
				if(this.search&&this.search.trim()!=''){
					this.$router.push('/home/search/'+this.search.trim());
				}else{
					this.$message('请输入内容再进行搜索');
				}
			},
			showAdd(){
				let router = this.$route;
				for(var i=0;i<this.show_add.length;i++){
					if(this.$route.name==this.show_add[i]){
						this.addName = '新增'+this.$route.meta.title;
						this.pathName = this.$route.name+'Add';
						return true;
					}
				}
			}
		},
		// watch:{
		//     '$route':function (router) {
		//       console.log(router)
		// 	}
		// }
    
	}
</script>
<style>
	.ablack,.pblack,.search{width: 240px;position: absolute;top:10px;right: 40px;}
	.ablack{width: 60px;right: 50px;}
	.pblack{width: 50px;right: 300px;}
	.addbtn{right: 150px;}
	.el-card__body{padding: 18px;}
	@media screen and (max-width: 640px) {
		.zbreadcrumb{display: none;}
		.search{right: 10px;}
		.pblack{right: 268px;}
	}
</style>