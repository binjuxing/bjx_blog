<template>
<div>
		
	
	<el-table
	    :data="articles"
	    border
	    style="width: 100%">
    	<el-table-column
      label="封面图" align="center">
      <template slot-scope="scope">
      	<img :src="scope.row.cover" alt="" style="width:100%;max-width:150px;">
      </template>
	    </el-table-column>
	    <el-table-column
	      prop="title"
	      label="标题">
	    </el-table-column>
	    <el-table-column
	      prop="author"
	      label="作者" width="200">
	    </el-table-column>
	    <el-table-column
	      prop="category_name"
	      label="分类">
	    </el-table-column>
	    <el-table-column
	      prop="category_name"
	      label="标签">
	    </el-table-column>
	    <el-table-column
	      prop="keywords"
	      label="关键词">
	    </el-table-column>
	    <el-table-column
	      fixed="right"
	      label="操作"
	      width="200">
	      <template slot-scope="scope" >
	        <el-button  type="info" size="small" icon="el-icon-view" @click="go('article/see',scope.row.id)">查看</el-button>
	        <el-button type="primary" size="small" icon="el-icon-edit" @click="go('article/edit',scope.row.id)">编辑</el-button>
	      </template>
	    </el-table-column>
  	</el-table>
  	<div style="text-align:center;margin-top: 10px;">
  		<el-pagination
	      @current-change="handleCurrentChange"
	      :current-page="page"
	      layout="total,  prev, pager, next, jumper"
	      :total="total">
	   	</el-pagination>
  	</div>
     
</div>
</template>
<script>
import {getCategory,getTag,getArticles} from '@/api/index'
	export default{
		data(){
			return {
				articles:[],
				categories:[],
				tags:[],
		        page:1,
		        total:0
			}
		},
		created(){
			this.getCategory();
		},

		methods:{
			getCategory(){
				let res = getCategory();
				res.then(res=>{
					let data = res.data;
					if(Number(data.error_code)===0){
						this.categories = data.data;
						this.getTag();
					}else{
						this.$message({type: 'info',message: data.msg,duration:1500});
					}
				})
			},
			getTag(){
				let res = getTag();
				res.then(res=>{
					let data = res.data;
					if(Number(data.error_code)===0){
						this.tags = data.data;
						this.getArticle()
					}else{
						this.$message({type: 'info',message: data.msg,duration:1500});
					}
				})
			},
			getArticle(){
				let res = getArticles();
				res.then(res=>{
					console.log(res)
					
					if(Number(res.data.error_code)===0){
						let data = res.data.data.data;
						this.total = res.data.data.total;
						for(var i=0;i<data.length;i++){
							for(var j = 0;j<this.categories.length;j++){
								if(data[i].category_id==this.categories[j].id){
									data[i].category_name = this.categories[j].name;
									break;
								}
							}

							for(var k = 0;k<data[i].tags.length;k++){
								for(var l = 0;l<this.tags.length;l++){
									if(data[i].tags[k].tag_id==this.tags[l].id){
										data[i].tags[k].name = this.tags[l].name;
										break;
									}
								}
								
							}
						}
						this.articles = data;
					}else{
						this.$message({type: 'info',message: data.msg,duration:1500});
					}
				})
				// var data = [{
				// 	id:1,
				// 	cover:'https://ss0.bdstatic.com/6ONWsjip0QIZ8tyhnq/it/u=1618097094,4154452434&fm=77&w_h=121_75&cs=423647557,799948659',
				// 	category_id:1,
				// 	title:'CentOS7下LNMP环境配置-服务器配置',
				// 	keywords:'服务器,centOS,LNMP',
				// 	click:666,
				// 	create_time: '2018.5.25 12:12:12',
				// 	tags:[{'tag_id':1},{'tag_id':2,}],
				// 	},{
				// 	id:2,
				// 	cover:'https://ss0.bdstatic.com/6ONWsjip0QIZ8tyhnq/it/u=1618097094,4154452434&fm=77&w_h=121_75&cs=423647557,799948659',
				// 	category_id:1,
				// 	title:'CentOS7下LNMP环境配置-服务器配置',
				// 	keywords:'服务器,centOS,LNMP',
				// 	click:666,
				// 	create_time: '2018.5.25 12:12:12',
				// 	tags:[{'tag_id':1},{'tag_id':2,}],
				// }]
				// console.log(this.categories.length)
				// for(var i=0;i<data.length;i++){
				// 	for(var j = 0;j<this.categories.length;j++){
				// 		if(data[i].category_id==this.categories[j].id){
				// 			data[i].category_name = this.categories[j].name;
				// 			break;
				// 		}
				// 	}

				// 	for(var k = 0;k<data[i].tags.length;k++){
				// 		for(var l = 0;l<this.tags.length;l++){
				// 			if(data[i].tags[k].tag_id==this.tags[l].id){
				// 				data[i].tags[k].name = this.tags[l].name;
				// 				break;
				// 			}
				// 		}
						
				// 	}
				// }

				// this.articles = data;
				// console.log(this.articles)

			},
			handleCurrentChange(page){
				this.page = page;
				getArticle()
			},
			go(url,id){
				this.$router.push(url+'/'+id);
			}
		}
	}
</script>