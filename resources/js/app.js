import Vue from "vue";
import VueRouter from "vue-router";
import App from "./App.vue";

require("./bootstrap");

Vue.use(VueRouter);
const router = new VueRouter({
    mode: "history", // Use history mode for clean URLs
    routes: [
        // Your routes here
    ],
});

new Vue({
    router,
    render: (h) => h(App),
}).$mount("#app");
