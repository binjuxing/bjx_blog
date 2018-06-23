<template>
<div>
	<el-form ref="form" :rules="rules" :model="form" label-width="100px">
		<el-form-item label="标 题" prop="title" >
			<el-input v-model="form.title" placeholder="请输入文章标题"  class="ainput" maxlength=50>
				<template slot="append">{{form.title.length}}/50</template>
			</el-input>
			
		</el-form-item>
		<el-form-item label="作 者" prop="author" >
			<el-input v-model="form.author" placeholder="请输入作者"  class="ainput" maxlength=16>
				<template slot="append">{{form.author.length}}/16</template>
			</el-input>
		</el-form-item>
		<el-form-item label="分 类" prop="category_id">
	        <el-select filterable v-model="form.category_id" class="ainput">
	            <el-option
		            v-for="(item,index) in categories"
		            :key="Number(item.id)"
		            :label="item.name"
		            :value="Number(item.id)"
		            >
	            </el-option>
	        </el-select>
	        <el-button type="info" class="el-icon-plus" title="新增分类" @click="go('adminCategoryAdd')"></el-button>
        </el-form-item>
      	<el-form-item label="标 签" prop="tag" >
      		<el-select v-model="tag" multiple placeholder="请选择" :multiple-limit='3' class="ainput">
			    <el-option
			      v-for="item in tags"
			      :key="item.id"
			      :label="item.name"
			      :value="item.id">
			    </el-option>
		    </el-select>
		    <el-button type="info" class="el-icon-plus" title="新增标签" @click="go('adminTagAdd')"></el-button>
		    <template slot="append">{{form.author.length}}/16</template>
		</el-form-item>
		<el-form-item label="关键词" prop="keywords" >
			<el-input v-model="form.keywords" placeholder="请输入关键词"  class="ainput" maxlength=30>
				<template slot="append">{{form.keywords.length}}/30</template>
			</el-input>
		</el-form-item>
		<el-form-item label="封面图" prop="cover" >
      <el-upload
			  class="avatar-uploader"
			  :action="baseUrl+'article/upImg?XDEBUG_SESSION_START=11392'"
			  :headers="{token:$store.state.token}"
			  name="image"
			  :data="{id:form.id}"
			  :show-file-list="false"
			  :on-success="handleAvatarSuccess"
			  :before-upload="beforeAvatarUpload">
			  <img v-if="form.cover" :src="form.cover" class="avatar">
			  <i v-else class="el-icon-plus avatar-uploader-icon"></i>
			</el-upload>
		</el-form-item>
		<el-form-item label="显 示" prop="is_show" >
      <el-switch
			  v-model="form.is_show"
			  active-color="#13ce66"
			  inactive-color="#ff4949">
			</el-switch>
		</el-form-item>
		<el-form-item label="置 顶" prop="is_top" >
      <el-switch
			  v-model="form.is_top"
			  active-color="#13ce66"
			  inactive-color="#ff4949">
			</el-switch>
		</el-form-item>
		<el-form-item label="推 荐" prop="recommend" >
      <el-switch 
			  v-model="form.recommend"
			  active-color="#13ce66"
			  inactive-color="#ff4949">
			</el-switch>
		</el-form-item>

		<el-form-item label="内 容" prop="markdown">
			<!-- 编辑 -->
			<mavon-editor v-model="form.markdown" ref=md readModel="true" :ishljs="true"  style="width: 90%;min-width: 500px;max-width:100%;"
				@imgAdd="imgAdd"
			/>
		</el-form-item>
	</el-form>
	<div style="text-align: center;">
		<el-button type="info" @click="save()">保存</el-button>
	</div>
	
</div>
	
</template>
<script>
	import {getCategory,getTag,upArticleImg,saveArticle,article} from '@/api'
	import {baseUrl} from '@/config/base.js'
	export default{
		data(){
			let validateTag = (rule, value, callback) => {
		      if (this.tag.length<1) {
		        callback(new Error(rule.message));
		      } else{
		        callback();
		      }
		    };
			return {
				id:'',
				form:{
					id:'',
					title:'',
					author:'',
					category_id:'',
					tag:[],
					keywords:'',
					cover:'',
					is_show:1,
					is_top:0,
					recommend:0,
					markdown:''
				},
				// 分类
				categories:[],
				// 标签
				tag:[],
				tags:[],
				isAdd:true,
				baseUrl:baseUrl,
				rules:{
			        title: [
			          { required: true, message: '请输入文章标题', trigger: 'blur' ,type:'string'}
			        ],
			        author: [
			          { required: true, message: '请输入作者', trigger: 'blur' ,type:'string'}
			        ],
			        category_id: [
			          { required: true, message: '请选择分类', trigger: 'change' ,type:'number'}
			        ],
			        tag: [
			          { required: true,validator: validateTag, message: '请选择标签', trigger: 'change' ,type:'array'}
			        ],
			        keywords: [
			          { required: true, message: '请输入关键词', trigger: 'blur' ,type:'string'}
			        ],
			        cover: [
			          { required: true, message: '怎能少了封面图', trigger: 'change' ,type:'string'}
			        ],
			        markdown: [
			          { required: true, message: '一点内容都没有，发毛文章啊', trigger: 'change' ,type:'string'}
			        ],
			    }
			}
		},
		created(){
			
			if(this.$route.name=='adminArticleEdit'){
				this.isAdd = false;
				this.id = this.$route.params.id;
			}
			this.getCategory();
		},
		mounted(){
			
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
						if(!this.isAdd)this.getArticle();
					}else{
						this.$message({type: 'info',message: data.msg,duration:1500});
					}
				})
			},
			getArticle(){
				let res = article({id:this.id});
				res.then(res=>{
					let data = res.data;
					if(Number(data.error_code)===0){
						let arr = [];
						for(var i = 0;i<data.data.tags.length;i++){
							arr.push(data.data.tags[i].tag_id);
						}
						this.tag = arr;
						data.data.is_show = Number(data.data.is_show)==1?true:false;
						data.data.is_top = Number(data.data.is_top)==1?true:false;
						data.data.recommend = Number(data.data.recommend)==1?true:false;
						this.form = data.data;
						console.log(this.form)
					}else{
						this.$message({type: 'info',message: data.msg,duration:1500});
					}
				})
			},
			tagChange(i){
				if(this.form.tag[i]){
					this.form.tag[i] = this.tage[i];
				}else{
					// this.form.tag[i];
				}
			},
			imgAdd(pos, $file){
				// console.log(pos,$file)
				// 第一步.将图片上传到服务器.
       	var formdata = new FormData();
        formdata.append('image', $file);
        formdata.append('id', this.form.id);
        let res = upArticleImg(formdata)
        res.then(res=>{
         	if(res.data.error_code===0){
         		this.$refs.md.$img2Url(pos, res.data.data.url);
         	}
        })
        return
        axios({
          url: 'server url',
          method: 'post',
          data: formdata,
          headers: { 'Content-Type': 'multipart/form-data' },
        }).then((url) => {
          // 第二步.将返回的url替换到文本原位置![...](0) -> ![...](url)
          /**
          * $vm 指为mavonEditor实例，可以通过如下两种方式获取
          * 1. 通过引入对象获取: `import {mavonEditor} from ...` 等方式引入后，`$vm`为`mavonEditor`
          * 2. 通过$refs获取: html声明ref : `<mavon-editor ref=md ></mavon-editor>，`$vm`为 `this.$refs.md`
          */
          $vm.$img2Url(pos, url);
        })
			},
			handleAvatarSuccess(res, file) {
        // this.form.cover = URL.createObjectURL(file.raw);
        this.form.cover = res.data.url
	    },
			beforeAvatarUpload(file) {
				const imgType = file.type === 'image/jpeg'||file.type === 'image/png'||file.type === 'image/gif';
				const isLt1M = file.size / 1024 / 1024 < 1;

				if (!imgType) {
				  this.$message.error('上传头像图片只能是 JPG/PNG/GIF 格式!');
				}
				if (!isLt1M) {
				  this.$message.error('上传头像图片大小不能超过 1MB!');
				}
				return imgType && isLt1M;
			},
			save(){
				this.$refs.form.validate((valid) => {
	        if (valid) {
	        	this.form.is_show = this.form.is_show?1:0;
	        	this.form.is_top = this.form.is_top?1:0;
	        	this.form.recommend = this.form.recommend?1:0;
	        	this.form.tag = this.tag;
	        	console.log(this.form)
	        	// return
						let res = saveArticle(this.form)
						res.then(res=>{
							let data = res.data;
							if(Number(data.error_code)===0){
								this.$message({type: 'success',message: '保存成功',duration:1500});
								this.$router.back(-1);
							}else{
								this.$message({type: 'info',message: data.msg,duration:1500});
							}
						});
					}
				})
			},
			go(name){
				this.$router.push({name:name})
			}
		}
	} 
</script>
<style>
.ainput{
	min-width:360px;width:40%
}
.avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 200px;
    height: 200px;
    line-height: 200px;
    text-align: center;
  }
  .avatar {
    width: 300px;
    /*height: 178px;*/
    display: block;
  }
</style>