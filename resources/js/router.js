import Vue from "vue";
import Router from "vue-router";
import home from "./components/pages/home.vue";
import tags from "./components/pages/tags.vue";
Vue.use(Router);

const routes = [
    { path: "/", component: home },
    { path: "/tags", component: tags },
];

export default new Router({
    mode: "history",
    routes,
});
