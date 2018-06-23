<template>
	<div>
		<div class="atitle">{{article.title}}</div>
		<div ></div>
		<el-row class="keyword">
			<el-col :span="12">关键词：{{article.keywords}}</el-col>
			<el-col :span="12"><i class="icon iconfont icon-yonghutouxiang" title="作者"></i> <span class="author">{{article.author}}</span></el-col>
		</el-row>
		<el-row class="info1">
		  <el-col :span="4">分类：<el-button size="mini" :type="tagType[article.category_id%5]">{{categoryName(article.category_id)}}</el-button></el-col>
		  <el-col :span="8"><i class="icon iconfont icon-biaoqian" title="标签"></i> <el-tag v-for="(tag,i) in article.tags" :key="tag.id" size="mini" :type="tagType[i]" style="margin-right: 2px;">{{tagName(tag.tag_id)}}</el-tag></el-col>
		  <el-col :span="4"><i class="el-icon-view"></i> {{article.click}}</el-col>
		  <el-col :span="8"><i class="el-icon-date"></i> {{article.create_time}}</el-col>
		</el-row>
		<el-row class="info2">
		<el-col :span="15"><i class="icon iconfont icon-biaoqian" title="标签"></i> <el-tag v-for="(tag,i) in article.tags" :key="tag.id" size="mini" :type="tagType[i]" style="margin-right: 2px;">{{tagName(tag.tag_id)}}</el-tag></el-col>
		  <el-col :span="9">分类：<el-button size="mini" :type="tagType[article.category_id%5]">{{categoryName(article.category_id)}}</el-button></el-col>
	  </el-row>
	  <el-row class="info2">
		  <el-col :span="15"><i class="el-icon-date"></i> {{article.create_time}}</el-col>
		  <el-col :span="9"><i class="el-icon-view"></i> {{article.click}}</el-col>
		</el-row>
		<mavon-editor :ishljs="true" v-model="article.markdown" :toolbarsFlag="false" :subfield="false" defaultOpen="preview"/>
		<div v-if="isAdmin" style="margin-top: 10px;text-align: center;">
			<el-button  type="info">前往修改</el-button>
		</div>
	</div>	
</template>
<script>
	import {getCategory,getTag,article} from '@/api/index'
	export default{
		data(){
			return {
				id:'',
				article:{
					// id:'1',
					// cover:'https://ss0.bdstatic.com/6ONWsjip0QIZ8tyhnq/it/u=1618097094,4154452434&fm=77&w_h=121_75&cs=423647557,799948659',
					// category_id:1,
					// title:'CentOS7下LNMP环境配置-服务器配置',
					// keywords:'服务器,centOS,LNMP',
					// click:666,
					// create_time: '2018.5.25 12:12:12',
					// tags:[{'article_id':1,'tag_id':'1'},{'article_id':1,'tag_id':'2'}],
					// markdown:" ### 啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊",
				},
				categories:[],
				tags:[],
				tagType:['success','info','warning','danger',''],
				isAdmin:false
			}
		},
		created(){
			this.id = this.$route.params.id;
			this.getCategory();
			if(this.$route.name=='adminArticleSee'){
					this.isAdmin = true;
			}
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
    	categoryName(id){
    		for(var i = 0;i<this.categories.length;i++){
    			if(this.categories[i].id==id){
    				return this.categories[i].name;
    			}
    		}
    	},
    	tagName(id){
    		console.log(id)
    		for(var i = 0;i<this.tags.length;i++){
    			if(this.tags[i].id==id){
    				return this.tags[i].name;
    			}
    		}
    	},
    	getArticle(){
    		let res = article({id:this.id});
				res.then(res=>{
					let data = res.data;
					if(Number(data.error_code)===0){
						data.data.create_time = this.getLocalTime(data.data.create_time);
						this.article = data.data;
					}else{
						this.$message({type: 'info',message: data.msg,duration:1500});
					}
				})
    	},
    	getLocalTime(nS) {
    		// console.log(nS,String(nS).test(/\d{10}/))
			  return /^[0-9]{10}$/.test(String(nS))?new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' '):nS;     
			}
    },
    mounted(){
    }
	}
</script>
<style>
	.atitle{font-size: 22px;font-weight: bold;color:#3a8ee6;margin-bottom: 20px;}
	.author{font-size: 16px;color: #3a8ee6;cursor: pointer;}
	.info2{display: none;}
	.keyword,.info1,.info2{margin-bottom: 20px;}
	@media screen and (max-width: 640px) {
		.info1{display: none;}
		.info2{display: block;}
		.atitle{margin-bottom: 10px;}
		.keyword,.info1,.info2{margin-bottom: 10px;}
	}
</style>