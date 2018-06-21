<template>
	
<div>
	<el-form ref="form" :rules="rules" :model="form" label-width="100px">
		<el-form-item label="标签名" prop="name" >
			<el-input v-model="form.name"  placeholder="请输入标签名" class="ainput"  maxlength=50>
				<template slot="append">{{form.name.length}}/10</template>
			</el-input>
		</el-form-item>
	</el-form>
	<div style="text-align: center;width: 50%;">
		<el-button type="info" @click="save()">保存</el-button>
	</div>
</div>
</template>
<script>
import {getTag,saveTag} from '@/api/index'
	export default{
		data(){
			return {
				form:{
					id:'',
					name:'',
				},
				isAdd:true,
				rules:{
			        name: [
			          { required: true, message: '请输入分类名', trigger: 'blur' ,type:'string'}
			        ],
			    }
			}
		},
		created(){
			if(this.$route.name=='adminTagEdit'){
				this.isAdd = false;
				if(this.$store.state.editData.id){
					this.form = this.$store.state.editData;
				}else{
					// console.log()
					this.getTag(this.$route.params.id)
				}
			}
		},
		methods:{
			getTag(id){
				getTag().then(res=>{
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
						let res = saveTag(this.form)
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