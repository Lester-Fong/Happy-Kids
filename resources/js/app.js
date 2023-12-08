import Vue from "vue";
import VueRouter from "vue-router";
import VueMeta from "vue-meta";
import App from "./App.vue";
import admin_routes from "./routes";
import landingPagesRoutes from "./landing_routes";
import VueCryptojs from "vue-cryptojs";

import "./admin_queries";
import "./front_queries";
import "./helper";
import moment from "moment";

require("./bootstrap");
let routes = [];
routes = routes.concat(landingPagesRoutes, admin_routes);

Vue.use(VueRouter);
Vue.use(VueCryptojs);
Vue.use(VueMeta);
const router = new VueRouter({
    routes,
    mode: "history",
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return {
                selector: to.hash,
            };
        } else {
            return { x: 0, y: 0 };
        }
    },
});

Vue.filter("formatTransDate", function (value) {
    if (value) {
        if (value && moment(value, "YYYY-MM-DD", true).isValid()) {
            return moment(value).format("MMM DD YYYY");
        }
        return value;
    }
});

// 2023-12-08 15:13:48 to MMM DD YYYY
Vue.filter("formatTransDateWithTime", function (value) {
    if (value) {
        if (value && moment(value, "YYYY-MM-DD HH:mm:ss", true).isValid()) {
            return moment(value).format("MMM DD YYYY");
        }
    }
});

// onget the day and month only 20 May
Vue.filter("formatTransDate2", function (value) {
    if (value) {
        if (value && moment(value, "YYYY-MM-DD", true).isValid()) {
            return moment(value).format("DD MMM");
        }
        return value;
    }
});

router.beforeEach((to, from, next) => {
    // ADMIN
    if (to.matched.some((m) => m.meta.isAdminAuthentication === true)) {
        if (sessionStorage.getItem("admin_api_token") === null || sessionStorage.getItem("login_type") === null) {
            window.location.href = "/admin";
            sessionStorage.clear();
            return;
        }
    } else {
        if (to.matched.some((m) => m.meta.isAdmin === true)) {
            if (sessionStorage.getItem("login_type") != null) {
                sessionStorage.clear();
            }
        }
    }
    next();
});

Vue.prototype.$appEvents = new Vue();

new Vue({
    router,
    render: (h) => h(App),
}).$mount("#app");
