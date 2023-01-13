import Vue from "vue";
import Router from "vue-router";
import home from "./components/pages/home.vue";
import tags from "./admin/pages/tags.vue";
import category from "./admin/pages/category.vue";
Vue.use(Router);

const routes = [
    { path: "/", component: home },
    { path: "/tags", component: tags },
    { path: "/category", component: category },
];

export default new Router({
    mode: "history",
    routes,
});
