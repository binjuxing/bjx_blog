import Vue from 'vue'
import Vuex from 'vuex'

// import {baseUrl} from '@/config/base'

Vue.use(Vuex)

const state = {
	userInfo: {},//个人信息
	token:{},
	config:{},
	loading:false,
	fullWidth: document.documentElement.clientWidth,
	fullHeight: document.documentElement.clientHeight,
	editData:{},
	isAdmin:false,//是否进入后台
	categories:{},// 分类
	tags:{}, // 标签
	links:{}, // 友链
}

const mutations = {
	saveUserInfo(state){
		state.userInfo = JSON.parse(sessionStorage.getItem('userInfo'));
	},
	saveToken(state){
		state.token = JSON.parse(sessionStorage.getItem('token'));
	},
	saveConfig(state){
		state.config = JSON.parse(sessionStorage.getItem('userInfo'));
	},
	loading(state,bol=true){
		state.loading = bol;
	},
	fullw(state,w){
		state.fullWidth = w;
	},
	fullh(state,h){
		state.fullHeight = h;
	},
	editData(state,value){
		state.editData = value;
	},
	isAdmin(state,bol=false){
		state.isAdmin = bol;
	},
	categories(state,value){
		state.categories = value?value:JSON.parse(sessionStorage.getItem('categories'));
	},
	tags(state,value){
		state.tags = value?value:JSON.parse(sessionStorage.getItem('tags'));
	},
	links(state,value){
		state.links = value?value:JSON.parse(sessionStorage.getItem('links'));
	}
}

const actions = {
	// async getAdminData({commit}){
	// 	try{
	// 		const res = await getAdminInfo()
	// 		if (res.status == 1) {
	// 			commit('saveAdminInfo', res.data);
	// 		}else{
	// 			throw new Error(res)
	// 		}
	// 	}catch(err){
	// 		console.log('您尚未登陆或者session失效')
	// 	}
	// },
	showDelDialog({commit},fn){
		state.dialogVisible = true;
		state.DelDialogFn = fn;
	},
	affirmDialog(){
		state.dialogVisible = false;
		state.DelDialogFn();
	},
}
const getters = {

	getToken(){
		return sessionStorage.getItem('token');
	}
}
const store = new Vuex.Store({
	state,
	actions,
	mutations,
	getters
})
export default store