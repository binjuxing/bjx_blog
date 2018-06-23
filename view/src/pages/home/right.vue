<template>
	<div>
		<el-card shadow="hover">
		<div class="ctitle">当前日期</div>
		<timer></timer>
		</el-card>
		<el-card shadow="hover">
		<div class="ctitle">所有标签</div>
			<el-button v-for="tag in tags" :key="tag.id" size="mini" plain :type="tagType[tag.id-1]" style="border-radius:7px;padding: 6px 10px;margin:5px 3px;" @click="$router.push('/home/tag/'+tag.id)">{{tag.name}}{{tag.article_count&&tag.article_count>0?'('+tag.article_count+')':''}}</el-button>
		</el-card>
		<el-card shadow="hover" >
		<div class="ctitle">文章推荐</div>
			<p class="article">CentOS7下LNMP环境配置-服务器配置</p>
			<p class="article">CentOS7下LNMP环境配置-服务器配置</p>
		</el-card>
		<el-card shadow="hover" class="link">
			<div class="ctitle">友情链接</div>
			<div class="link-list" v-for="item in flinks">
				<a :href="item.url" target="_black">
				<img class="icon" v-if="item.show" :src="item.icoUrl" alt="">
				<i v-else class="icon-share_link"></i> 
				{{item.name}}
			</a>
			</div>
		</el-card>
	</div>
</template>
<script>
	import Timer from "./time"
	import {getTag} from "@/api"
export default{
	components:{
		Timer,
	},
    data(){
    	return {
    		links:[],
    		tags:[{'id':1,'name':'前端',count:0},{'id':2,'name':'js',count:10},{'id':3,'name':'php',count:5},{'id':4,'name':'js',count:10},{'id':5,'name':'php',count:5}],
    		tagType:['success','info','warning','danger',''],
    	}
    },
    computed:{
    	flinks(){
    		var data = this.checkIco();
    		console.log(data)
    		return data;
    	}
    },
    created(){
    	this.links = [{id:1,url:'https://www.liaoxuefeng.com/',name:'廖雪峰的官方网站',show:false,iconUrl:''},{id:1,url:'https://baijunyao.com',name:'白俊遥博客,技术博客,个人博客模板,php博客系统',show:false,iconUrl:''}]
    	this.getTag();
    },
    methods:{
    	checkIco(){
    		for(let i=0,obj;obj=this.links[i];i++){
    			var imgUrl = 'favicon.ico';
    			if(obj.url.charAt(obj.url.length-1)!='/')
    				imgUrl=obj.url+'/'+imgUrl;
    			else
    				imgUrl=obj.url+imgUrl;
    				obj.icoUrl = imgUrl;
    				let img=new Image();  
				    img.onload=()=>{obj.show=true;}  
				    img.src=imgUrl;
    		}
    		return this.links
    	},
    	getTag(){
			let res = getTag();
			res.then(res=>{
				let data = res.data;
				if(Number(data.error_code)===0){
					this.tags = data.data;
				}else{
					this.$message({type: 'info',message: data.msg,duration:1500});
				}
			})
		},
	}
}
</script>
<style>
	
	.el-card{margin-bottom: 20px;}
	.ctitle{text-align: center;line-height: 30px;color: #888;font-weight: bold;}
	.link .link-list{height: 22px;margin-bottom: 5px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;}
	.article {cursor:pointer; font-size: 15px;line-height: 16px;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;}
	.article:hover {text-decoration:underline;}
	
	.link .link-list img{width: 20px;vertical-align: middle;}
</style>