<template>
	<div class="alist">
		<el-card shadow="hover" class="ecard" v-for="item in articles" :key="item.id">
			<el-container>
				<div class="cover" @click="goArticle(item)">
					<img class="img1" :src="item.cover" alt="">
					<img class="img2" :src="item.cover" alt="">
				</div>
    		<div class="con">
    			<div style="width:100%;">
      			<div class="title" @click="goArticle(item)">{{item.title}}</div>
      			<div class="category">
      				分类：<el-button size="mini" :type="tagType[item.category_id%5]" style="padding:5px 10px;">{{categoryName(item.category_id)}}</el-button>
      			</div>
      			<div class="tag">
					标签：
      				<el-tag v-for="(tag,i) in item.tags" :key="tag.id" size="mini" :type="tagType[i]" style="margin-right: 2px;">{{tag.name}}</el-tag>
      			</div>
      			<div class="keywords">{{item.keywords}}</div>
      			<div class="info">
      				<span><i class="el-icon-view"></i> {{item.click}}</span>
      				<span class="time"><i class="el-icon-date"></i> {{item.create_time}}</span>
      			</div>
    			</div>
    		</div>
    		<div class="zhiding">置顶</div>
    	</el-container>
    </el-card>
		<div class="page">
			<el-pagination
			  background
			  :current-page="page"
			  :page-size="size"
			  @current-change="handleCurrentChange"
			  layout="total,prev, pager, next,jumper"
			  :total="total">
			</el-pagination>
			<el-pagination
			  background
			  :current-page="page"
			  :pager-count="5"
			  :page-size="5"
			  layout="prev, pager, next"
			  :total="total">
			</el-pagination>
		</div>
	</div>
</template>
<script>
  import rightbox from "./right"
  import {getCategory,getTag,getArticles} from "@/api"
  export default{
  	components:{
    	rightbox,
    },
    data(){
		return {
			articles:[
			// {
			// 	id:1,
			// 	cover:'https://ss0.bdstatic.com/6ONWsjip0QIZ8tyhnq/it/u=1618097094,4154452434&fm=77&w_h=121_75&cs=423647557,799948659',
			// 	category_id:1,
			// 	title:'CentOS7下LNMP环境配置-服务器配置',
			// 	keywords:'服务器,centOS,LNMP',
			// 	click:666,
			// 	create_time: '2018.5.25 12:12:12',
			// 	tags:[{'id':1,'name':'前端'},{'id':2,'name':'js'}],
			// }
			],
			
			total:30,
			size:5,
			page:1,
			categories:[{id:1,name:'待定'}],
			tagType:['success','info','warning','danger','']
			}
    },
    computed:{
    	
    },
    created(){
    	this.getCategory()
    },
    methods:{
    	categoryName(id){
    		for(var i = 0;i<this.categories.length;i++){
    			if(this.categories[i].id==id){
    				return this.categories[i].name;
    			}
    		}
    	},
    	handleCurrentChange(val){
    		console.log(`当前页: ${val}`);
    	},
    	goArticle(item){
    		this.$router.push('/article/'+item.id)
    	},
    	checkUrl(router){
    		router = router || this.$route;
    		if(router.path.indexOf('/home/category/')===0){
    			// if(!router.params) return;
	        console.log('分类',router.params.id)
	      }else
	      if(router.path.indexOf('/home/search/')===0){
	      	// if(!router.params) return;
	        console.log('搜索',router.params.keyword)
	      }else
	      if(router.path.indexOf('/home/tag/')===0){
	      	// if(!router.params) return;
	        console.log('标签',router.params.id)
	      }else
	      if(router.path.indexOf('/home')===0){
	      	console.log('home')
	      	this.getCategory()
	      }
    	},
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
		},

    },
    watch:{
	    '$route':function (router) {
	    	console.log(router)
	    	// console.log(1)
	      this.checkUrl(router);
	    }
    },
  }
</script>
<style>
	a{text-decoration: none;color:#6b8caf;font-size: 14px;}
	
	.ecard{margin-bottom: 20px;cursor: pointer;position: relative;}
	.ecard .cover{width: 40%;min-width: 300px;position: relative;overflow: hidden;}
	.ecard .cover:hover .img2{width: 120%;top:-10%;left:-10%;}
	.ecard .cover .img1{width:100%;opacity:0;}
	.ecard .cover .img2{width:100%;position: absolute;top:0;left: 0;}
	
	.ecard .con{margin-left:2%;width: 58%;display: flex;align-items: center;}
	.ecard .con .title{font-size: 16px;font-weight: bold;color:#3a8ee6;}
	.ecard .con .title:hover{text-decoration:underline;}
	.ecard .con .category,.ecard .con .tag{font-size: 14px;margin-top: 8px;color: #c0c4cc;}
	.ecard .con .keywords{font-size: 14px;color: #303133;margin-top: 8px;}
	.ecard .con .info{font-size: 14px;color: #606266;margin-top: 8px;}
	.ecard .con .info .time{margin-left: 20px;}
	.ecard .zhiding{position: absolute;top:10px;right: 10px;background: #67c23a;padding: 2px 5px;color: white;border-radius: 5px;box-shadow: 0 0 30px 2px rgba(25,222,83,.5),inset 0 0 0 1px rgba(255,255,255,.3)}

	.page{text-align: center;margin:20px 0;}
	.page .el-pagination:nth-child(2){display: none;}
	

	@media screen and (max-width: 640px) { 
	  .ecard .cover{width: 100%;}
	  .ecard .con{width: 98%;margin-left:0;padding: 5px 1%;}
	  .ecard .con .category,.ecard .con .tag{display: inline-block;}
	  .ecard .el-card__body{padding: 5px;}
	  .ecard .el-container{display: block;}
	  .ecard .con .title{font-size: 18px;}
	  .ecard .con .info .time{float: right;}
	  .page .el-pagination{white-space: normal;}
	  .page .el-pagination:nth-child(1){display: none;}
	  .page .el-pagination:nth-child(2){display: block;}
	}
</style>