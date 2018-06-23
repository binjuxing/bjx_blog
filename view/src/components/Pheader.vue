<template>
	<el-header class="pheader" >
      <div class="hcon">
        
        <div class="title">
        	<img src="http://img2.imgtn.bdimg.com/it/u=388006013,1820809809&fm=200&gp=0.jpg" alt="">
        	<span> 博客博客</span>
        </div>
        <div class="nav">
            <i class="el-icon-menu phone-menu" v-show="$store.state.fullWidth<640&&!showList" @click="setshow()"></i>
            <ul class="nav-meun" v-show="$store.state.fullWidth>640||showList" @click="setshow()">
                <li :class="$route.name=='home'?'active':''" @click="go('home')">首页</li>
                <li v-for="item in categories" :class="$route.path=='/home/category/'+item.id?'active':''" @click="goCategory(item.id)">{{item.name}}</li>
                <li @click="go('adminIndex')">管理</li>
                <li >隐藏</li>
            </ul>
        </div>
        
      </div>
    </el-header>
</template>
<script>
    import {getCategory} from '@/api/index'
    export default {
        data(){
            return {
                categories:[
                // {
                //     id:1,
                //     name:'HTML'
                // },
                // {
                //     id:2,
                //     name:'PHP'
                // },
                // {
                //     id:3,
                //     name:'Python'
                // },
                // {
                //     id:4,
                //     name:'MySql'
                // }
                ],
                showList:false
            }
        },
        created(){
            this.getCategory()
        },
        methods:{
            go(name){
                this.$router.push({name:name})
            },
            goCategory(id){
                this.$router.push('/home/category/'+id)
            },
            setshow(){
                this.showList = !this.showList;
            },
            getCategory(){
                let res = getCategory();
                res.then(res=>{
                    let data = res.data;
                    if(Number(data.error_code)===0){
                        var arr = []
                        for(var i = 0;i < data.data.length; i++){
                            if(data.data[i].nav_show){
                                arr.push(data.data[i])
                            }
                        }
                        this.categories = arr;
                    }else{
                        this.$message({type: 'info',message: data.msg,duration:1500});
                    }
                })

            },

        },
        mounted(){

        }
    }
</script>
<style>
	.pheader{height: 50px!important;background: rgb(67,74,80);color: white;}
	.hcon{width:100%;max-width: 1200px;margin:0 auto;position: relative;}
	.hcon .title{display: inline-block;padding: 4px 0;font-size: 22px;color:white;text-shadow: 1px 1px 3px white}
	.hcon .title img{width: 42px;height: 42px;vertical-align:middle;}
    .clear{display: block;content: '';clear:both;}
	.nav {	position: absolute;top:0;right:0;font-size: 20px;margin-right: 18px;z-index: 999;cursor: pointer;}
    .nav .nav-meun{padding: 0;margin:0;transition: all .5s;}
    .nav .phone-menu{font-size: 34px;margin-top: 8px;color: #fff12f;}
    .nav-meun  li{line-height: 48px; min-width: 100px;text-align: center;transition: all .2s;background: #484848;list-style:none;float: left;border-bottom: 2px solid #484848;}
    .nav-meun  li:hover{background: #000000;border-color:#fff12f;color: #fff12f;}
    .nav-meun  li:last-child{display: none;}
    .nav-meun .active{color: #fff12f;border-color:#fff12f;}
    @media screen and (max-width: 640px) {
        /*.nav-meun {display: none;}*/
        .nav-meun  li{float: none;}
        .nav-meun  li:last-child{display: block;}
        .nav .phone-menu{display: block;}
    
    }
</style>
