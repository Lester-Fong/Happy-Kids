import Front from "./Portal/Administrator/Front/front.vue";
import Login from "./Portal/Administrator/Front/login.vue";
import ForgotPassword from "./Portal/Administrator/Front/forgot_password.vue";
import ForgotPasswordOTP from "./Portal/Administrator/Front/forgot_password_otp.vue";
import ResetPassword from "./Portal/Administrator/Front/reset_password.vue";
import AdminDashboard from "./Portal/Administrator/dashboard.vue";

export default [
    {
        path: "",
        component: Front,
        meta: { isAdminAuthentication: false, isAdmin: true },
        children: [
            { path: "/admin", component: Login, name: "AdminLogin" },
            { path: "/admin/forgot-password", component: ForgotPassword, name: "ForgotPassword" },
            { path: "/admin/forgot-password-otp", component: ForgotPasswordOTP, name: "ForgotPasswordOTP" },
            { path: "/admin/reset-password/:security", component: ResetPassword, name: "ResetPassword", params: true },
        ],
    },
    { path: "/admin/dashboard", component: AdminDashboard, name: "AdminDashboard", meta: { isAdminAuthentication: true } },
];
