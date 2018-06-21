<template>
	<div>
		<div class="atitle">{{article.title}}</div>
		<div class="keyword">关键词：{{article.keywords}}</div>
		<el-row class="info1">
		  <el-col :span="6">分类：<el-button size="mini" :type="tagType[article.category_id%5]">{{categoryName(article.category_id)}}</el-button></el-col>
		  <el-col :span="6">标签：<el-tag v-for="(tag,i) in article.tag" :key="tag.id" size="mini" :type="tagType[i]" style="margin-right: 2px;">{{tag.name}}</el-tag></el-col>
		  <el-col :span="4"><i class="el-icon-view"></i> {{article.click}}</el-col>
		  <el-col :span="8"><i class="el-icon-date"></i> {{article.create_time}}</el-col>
		</el-row>
		<el-row class="info2">
		<el-col :span="15">标签：<el-tag v-for="(tag,i) in article.tag" :key="tag.id" size="mini" :type="tagType[i]" style="margin-right: 2px;">{{tag.name}}</el-tag></el-col>
		  <el-col :span="9">分类：<el-button size="mini" :type="tagType[article.category_id%5]">{{categoryName(article.category_id)}}</el-button></el-col>
	  </el-row>
	  <el-row class="info2">
	  <el-col :span="15"><i class="el-icon-date"></i> {{article.create_time}}</el-col>
		  <el-col :span="9"><i class="el-icon-view"></i> {{article.click}}</el-col>
		</el-row>
		<mavon-editor :ishljs="true" v-model="article.markdown" :toolbarsFlag="false" :subfield="false" defaultOpen="preview"/>
	</div>
	
</template>
<script>
	export default{
		data(){
			return {
				article:{
					id:1,
					cover:'https://ss0.bdstatic.com/6ONWsjip0QIZ8tyhnq/it/u=1618097094,4154452434&fm=77&w_h=121_75&cs=423647557,799948659',
					category_id:1,
					title:'CentOS7下LNMP环境配置-服务器配置',
					keywords:'服务器,centOS,LNMP',
					click:666,
					create_time: '2018.5.25 12:12:12',
					tag:[{'id':1,'name':'前端'},{'id':2,'name':'js'}],
					markdown:" ### 啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊",
				},
				categorys:[{id:1,name:'待定'}],
				tagType:['success','info','warning','danger',''],
			}
		},
		methods:{
    	categoryName(id){
    		for(var i = 0;i<this.categorys.length;i++){
    			if(this.categorys[i].id==id){
    				return this.categorys[i].name;
    			}
    		}
    	},
    	//获取文档内容
        getContent: function(){
          let content = this.$refs.ueditor.getUEContent();
          console.log(content);
          alert(content);
        }
    },
    mounted(){
    }
	}
</script>
<style>
	.atitle{font-size: 22px;font-weight: bold;color:#3a8ee6;margin-bottom: 20px;}
	.info2{display: none;}
	.keyword,.info1,.info2{margin-bottom: 20px;}
	@media screen and (max-width: 640px) {
		.info1{display: none;}
		.info2{display: block;}
		.atitle{margin-bottom: 10px;}
		.keyword,.info1,.info2{margin-bottom: 10px;}
	}
</style>