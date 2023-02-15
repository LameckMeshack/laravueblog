import "./bootstrap";

import Vue from "vue";
import ViewUI from "view-design";
// import Editor from "vue-editor-js";
import Editor from "vue-editor-js/src/index";
import "view-design/dist/styles/iview.css";
import router from "./router";
import store from "./store";
import common from "./common";
import jsonToHTML from "./jsonToHTML";

Vue.use(ViewUI);
Vue.mixin(common);
Vue.mixin(jsonToHTML);
Vue.use(Editor);

Vue.component("mainapp", require("./components/mainapp.vue").default);
const app = new Vue({
    el: "#app",
    store,
    router,
});
