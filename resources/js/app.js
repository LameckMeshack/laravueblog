import "./bootstrap";

import Vue from "vue";
import ViewUI from "view-design";
import Editor from "vue-editor-js";
import "view-design/dist/styles/iview.css";
import router from "./router";
import store from "./store";
import common from "./common";

Vue.use(ViewUI);
Vue.mixin(common);
Vue.use(Editor);

Vue.component("mainapp", require("./components/mainapp.vue").default);
const app = new Vue({
    el: "#app",
    store,
    router,
});
