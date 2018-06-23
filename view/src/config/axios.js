import axios from 'axios'

import router from '../router'
import store from '../store/'
import { baseUrl } from './base'
export default async(url,params) => {
	let c = {
		data : {},
		type : 'get',
		cacheName : '',
		Loading : true,
		needToken : true,
		upType:''
	}
	// 参数赋值
	for(var key in params){
		c[key] = params[key];
	}
	// 缓存读取
	let cache = c.cacheName!='',hasId = c.data&&c.data.id&&Number(c.data.id)>0;
	if(cache){
		let value = sessionStorage.getItem(c.cacheName),re,nowtime = new Date().getTime();
		if(store.state[c.cacheName]&&Object.keys(store.state[c.cacheName]).length>0&&hasId||
			store.state[c.cacheName].time&&store.state[c.cacheName].time>nowtime){
			re = store.state[c.cacheName];
		}else if(value){
			let val = JSON.parse(value);
			if(val.data&& typeof val.data == 'string')val.data = JSON.parse(val.data);
			if(hasId||val.time>nowtime){
				re = val
				store.commit(c.cacheName,val)
			}
		}
		
		if(re){
			if(hasId){
				var keyName = c.cacheName+'_'+c.data.id;
				if(re[keyName]&&re[keyName].time>nowtime){
					if(typeof re[keyName].data == 'string')re[keyName].data = JSON.parse(re[keyName].data);
					return new Promise((resolve, reject) => {
						resolve({data:re[keyName]})
					})
				}
			}else{
				return new Promise((resolve, reject) => {
					resolve({data:re})
				})
			}
			
		}
		
	}
	let method = c.type.toLowerCase();
	let axiosConfig = {
		// `url`是将用于请求的服务器URL
		url: url,
		 
		// `method`是发出请求时使用的请求方法
		method: method, // 默认get
		 
		// `baseURL`将被添加到`url`前面，除非`url`是绝对的。
		// 可以方便地为 axios 的实例设置`baseURL`，以便将相对 URL 传递给该实例的方法。
		baseURL: baseUrl,
		 
		// `transformRequest`允许在请求数据发送到服务器之前对其进行更改
		// 这只适用于请求方法'PUT'，'POST'和'PATCH'
		// 数组中的最后一个函数必须返回一个字符串，一个 ArrayBuffer或一个 Stream
		 
		// transformRequest: [function (data) {
		// // 做任何你想要的数据转换
		 
		// return data;
		// }],
		 
		// `transformResponse`允许在 then / catch之前对响应数据进行更改
		transformResponse: [function (data) {
			c.Loading&&store.commit("loading",false)
			if(typeof data=='string')data = JSON.parse(data);
			if(cache){
				data.time = new Date().getTime()+7200000;//2小时内有效
				if(hasId){
					let ca = sessionStorage.getItem(c.cacheName)?JSON.parse(sessionStorage.getItem(c.cacheName)):{};
					ca[c.cacheName+'_'+c.data.id] = data;
					sessionStorage.setItem(c.cacheName,JSON.stringify(ca))
					store.commit(c.cacheName,ca)
				}else{
					sessionStorage.setItem(c.cacheName,JSON.stringify(data))
					store.commit(c.cacheName,data)
				}
				
			}
			
			if(data.data&&typeof data.data=='string')data.data = JSON.parse(data.data);
		 	// if(data.error_code===10001){
		 	// 	router.push({name:"login"})
		 	// }
			return data;
		}],
		 
		// `headers`是要发送的自定义 headers
		// headers: {'X-Requested-With': 'XMLHttpRequest','token':'jj'},
		 
		// `params`是要与请求一起发送的URL参数
		// 必须是纯对象或URLSearchParams对象
		// params: type=='get'?data:'',
		 
		// `paramsSerializer`是一个可选的函数，负责序列化`params`
		// (e.g. https://www.npmjs.com/package/qs, http://api.jquery.com/jquery.param/)
		// paramsSerializer: function(params) {
		// 	return Qs.stringify(params, {arrayFormat: 'brackets'})
		// },
		 
		// `data`是要作为请求主体发送的数据
		// 仅适用于请求方法“PUT”，“POST”和“PATCH”
		// 当没有设置`transformRequest`时，必须是以下类型之一：
		// - string, plain object, ArrayBuffer, ArrayBufferView, URLSearchParams
		// - Browser only: FormData, File, Blob
		// - Node only: Stream
		// data: {},
		 
		// `timeout`指定请求超时之前的毫秒数。
		// 如果请求的时间超过'timeout'，请求将被中止。
		// timeout: 1000,
		 
		// `withCredentials`指示是否跨站点访问控制请求
		// should be made using credentials
		// withCredentials: false, // default
		 
		// `adapter'允许自定义处理请求，这使得测试更容易。
		// 返回一个promise并提供一个有效的响应（参见[response docs]（＃response-api））
		// adapter: function (config) {
		// /* ... */
		// },
		 
		// `auth'表示应该使用 HTTP 基本认证，并提供凭据。
		// 这将设置一个`Authorization'头，覆盖任何现有的`Authorization'自定义头，使用`headers`设置。
		// auth: {
		// username: 'janedoe',
		// password: 's00pers3cret'
		// },
		 
		// “responseType”表示服务器将响应的数据类型
		// 包括 'arraybuffer', 'blob', 'document', 'json', 'text', 'stream'
		// responseType: 'json', // default
		 
		//`xsrfCookieName`是要用作 xsrf 令牌的值的cookie的名称
		// xsrfCookieName: 'XSRF-TOKEN', // default
		 
		// `xsrfHeaderName`是携带xsrf令牌值的http头的名称
		// xsrfHeaderName: 'X-XSRF-TOKEN', // default
		 
		// `onUploadProgress`允许处理上传的进度事件
		// onUploadProgress: function (progressEvent) {
		// // 使用本地 progress 事件做任何你想要做的
		// },
		 
		// `onDownloadProgress`允许处理下载的进度事件
		// onDownloadProgress: function (progressEvent) {
		// // Do whatever you want with the native progress event
		// },
		 
		// `maxContentLength`定义允许的http响应内容的最大大小
		// maxContentLength: 2000,
		 
		// `validateStatus`定义是否解析或拒绝给定的promise
		// HTTP响应状态码。如果`validateStatus`返回`true`（或被设置为`null` promise将被解析;否则，promise将被
		  // 拒绝。
		// validateStatus: function (status) {
		// return status >= 200 && status < 300; // default
		// },
		 
		// `maxRedirects`定义在node.js中要遵循的重定向的最大数量。
		// 如果设置为0，则不会遵循重定向。
		// maxRedirects: 5, // 默认
		 
		// `httpAgent`和`httpsAgent`用于定义在node.js中分别执行http和https请求时使用的自定义代理。
		// 允许配置类似`keepAlive`的选项，
		// // 默认情况下不启用。
		// httpAgent: new http.Agent({ keepAlive: true }),
		// httpsAgent: new https.Agent({ keepAlive: true }),
		 
		// 'proxy'定义代理服务器的主机名和端口
		// `auth`表示HTTP Basic auth应该用于连接到代理，并提供credentials。
		// 这将设置一个`Proxy-Authorization` header，覆盖任何使用`headers`设置的现有的`Proxy-Authorization` 自定义 headers。
		// proxy: {
		// 	host: '127.0.0.1',
		// 	port: 9000,
		// 	auth: : {
		// 	username: 'mikeymike',
		// 	password: 'rapunz3l'
		// 	}
		// },
		 
		// “cancelToken”指定可用于取消请求的取消令牌
		// (see Cancellation section below for details)
		// cancelToken: new CancelToken(function (cancel) {
		// })
	}
	if(method=='get') axiosConfig.params = c.data;
	if(method=='post') axiosConfig.data = c.data;
	if(c.needToken) axiosConfig.headers = {'token':sessionStorage.getItem('token')}
	if(c.upType=='img')axiosConfig.headers['Content-Type'] = 'multipart/form-data';
	c.Loading&&store.commit("loading")
	return axios.request(axiosConfig);
}