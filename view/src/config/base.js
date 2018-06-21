/**
 * 配置编译环境和线上环境之间的切换
 * 
 * baseUrl: 域名地址
 * routerMode: 路由模式
 * baseImgPath: 图片存放地址
 * 
 */
 // API基地址
// let baseUrl = 'https://xuanhengkj.com/xuanheng/api/v1';

let baseUrl = '';
// let routerMode = 'history';
let baseImgPath = '';


// let getToken = ;

if (process.env.NODE_ENV == 'development') {
	baseUrl = 'http://localhost/bjxblog/tp5/public/';
	baseImgPath = 'http://localhost/bjxblog/tp5/public/images';
}else{
	baseUrl = 'https://api.xch.kim/admin/api/pc';
	baseImgPath = '';
}

export {
	baseUrl,
	// routerMode,
	baseImgPath,
	
}