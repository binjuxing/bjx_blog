// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'

import App from './App'
import router from './router'
// vuex stroe
import store from './store/'
// mavonEditor
import mavonEditor from 'mavon-editor'
    // markdown-it对象：md.s_markdown, md => mavonEditor实例
    //                 or
    //                 mavonEditor.markdownIt 
import 'mavon-editor/dist/css/index.css'
Vue.use(mavonEditor)

// element
import Element  from 'element-ui';
Vue.use(Element)
import 'element-ui/lib/theme-chalk/index.css';
// import {Header,
// 	Menu,
// 	Footer,
// 	Submenu,
// 	MenuItem,
// 	Main,
// 	Container,
// 	MenuItemGroup,
// 	Breadcrumb,
//   	BreadcrumbItem,
//   	Button,
//   	Row,
//   	Input,
//   	InputNumber,
//   	Form,
//   	FormItem,
//   	Select,
// 	Option,
// 	OptionGroup,
// 	Checkbox,
// 	Table,
//   	TableColumn,
//   	Upload,
//   	Message,
//   	MessageBox,
// 	} from 'element-ui';
// Vue.config.productionTip = false
// Vue.use(Header)
// Vue.use(Menu)
// Vue.use(Footer)
// Vue.use(Submenu)
// Vue.use(MenuItem)
// Vue.use(Main)
// Vue.use(Container)
// Vue.use(MenuItemGroup)
// Vue.use(Breadcrumb)
// Vue.use(BreadcrumbItem)
// Vue.use(Button)
// Vue.use(Row)
// Vue.use(Input)
// Vue.use(InputNumber)
// Vue.use(Form)
// Vue.use(FormItem)
// Vue.use(Select)
// Vue.use(Option)
// Vue.use(OptionGroup)
// Vue.use(Checkbox)
// Vue.use(Table)
// Vue.use(TableColumn)
// Vue.use(Upload)
// Vue.use(Message)
// Vue.use(MessageBox)
// Vue.prototype.$loading = Loading.service;
// Vue.prototype.$msgbox = MessageBox;
// Vue.prototype.$alert = MessageBox.alert;
// Vue.prototype.$confirm = MessageBox.confirm;
// Vue.prototype.$prompt = MessageBox.prompt;
// Vue.prototype.$notify = Notification;
// Vue.prototype.$message = Message;
// router.push('admin/index')
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})
