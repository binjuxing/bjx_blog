<template>
	
<div>
	<el-form ref="form" :rules="rules" :model="form" label-width="100px">
		<el-form-item label="分类名" prop="name" >
			<el-input v-model="form.name"  placeholder="请输入分类名" class="ainput"  maxlength=50>
				<template slot="append">{{form.name.length}}/10</template>
			</el-input>
		</el-form-item>
		<el-form-item label="描 述" prop="description" >
			<el-input v-model="form.description"  placeholder="请输入分类描述" class="ainput"  maxlength=50>
				<template slot="append">{{form.description.length}}/50</template>
			</el-input>
		</el-form-item>
		<el-form-item label="排 序" prop="sort" >
			<el-input v-model="form.sort"  placeholder="输入排序值" class="ainput"  maxlength=50>
			<template slot="append">0~99整数，数值越大越靠前，默认0</template>
			</el-input>
		</el-form-item>
		<el-form-item label="导航显示" prop="nav_show" >
			<el-switch
			  v-model="form.nav_show"
			  :active-text="nav_show?'显示':'不显示'"
			  active-color="#13ce66"
			  inactive-color="#ff4949">
			</el-switch>
		</el-form-item>
	</el-form>
	<div style="text-align: center;width: 50%;">
		<el-button type="info" @click="save()">保存</el-button>
	</div>
</div>
</template>
<script>
import {getCategory,saveCategory} from '@/api/index'
	export default{
		data(){
			return {
				form:{
					id:'',
					name:'',
					description: '',
					nav_show:0,
					sort:0,
				},
				nav_show:false,
				isAdd:true,
				rules:{
			        name: [
			          { required: true, message: '请输入分类名', trigger: 'blur' ,type:'string'}
			        ],
			    }
			}
		},
		created(){
			if(this.$route.name=='adminCategoryEdit'){
				this.isAdd = false;
			}
			if (!this.isAdd) {
				if(this.$store.state.editData.id){
					this.form = this.$store.state.editData;
				}else{
					this.getCategory(this.$route.params.id)
				}
				
			}
		},
		methods:{
			getCategory(id){
				getCategory().then(res=>{
					let data = res.data;
					if(Number(data.error_code)===0){
						for(var i=0,obj;obj=data.data[i];i++){
							if(obj.id==id){
								this.form = obj;
								break;
							}
						}
					}
				})
			},
			save(){
				this.$refs.form.validate((valid) => {
			        if (valid) {
						this.form.nav_show = this.nav_show?1:0;
						let res = saveCategory(this.form)
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
		}
	}
</script>
<style>
	.ainput{min-width:360px;width:50%}
</style>