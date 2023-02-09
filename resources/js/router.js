import Vue from "vue";
import Router from "vue-router";
import home from "./components/pages/home.vue";
import tags from "./admin/pages/tags.vue";
import category from "./admin/pages/category.vue";
import createBlog from "./admin/pages/createBlog.vue";
import adminusers from "./admin/pages/adminusers.vue";
import login from "./admin/pages/login.vue";
import role from "./admin/pages/role.vue";
import assignRole from "./admin/pages/assignRole.vue";
import blogs from "./admin/pages/blogs.vue";
Vue.use(Router);

const routes = [
    { path: "/", component: home, name: "home" },
    { path: "/tags", component: tags, name: "tags" },
    { path: "/category", component: category, name: "category" },
    { path: "/createblog", component: createBlog, name: "createBlog" },
    { path: "/adminusers", component: adminusers, name: "adminusers" },
    { path: "/login", component: login, name: "login" },
    { path: "/role", component: role, name: "role" },
    { path: "/assignrole", component: assignRole, name: "assignrole" },
    { path: "/blogs", component: blogs, name: "blogs" },
];

export default new Router({
    mode: "history",
    routes,
});
