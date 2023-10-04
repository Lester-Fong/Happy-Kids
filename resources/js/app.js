import Vue from "vue";
import VueRouter from "vue-router";
import App from "./App.vue";
import routes from "./routes";
import "./admin_queries";

require("./bootstrap");

Vue.use(VueRouter);
const router = new VueRouter({
    mode: "history", // Use history mode for clean URLs
    routes, // Short for `routes: routes`
});

new Vue({
    router,
    render: (h) => h(App),
}).$mount("#app");
