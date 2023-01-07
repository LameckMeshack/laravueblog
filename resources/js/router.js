import Vue from 'vue';
import Router from 'vue-router';
import Home from "./components/pages/PageOne.vue"
Vue.use(Router);



const routes = [
  { path: '/', component: Home },
]



export default new Router({
  routes,
})