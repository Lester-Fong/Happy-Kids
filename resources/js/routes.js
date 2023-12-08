import Front from "./Portal/Administrator/Front/front.vue";
import Login from "./Portal/Administrator/Front/login.vue";
import ForgotPassword from "./Portal/Administrator/Front/forgot_password.vue";
import ForgotPasswordOTP from "./Portal/Administrator/Front/forgot_password_otp.vue";
import ResetPassword from "./Portal/Administrator/Front/reset_password.vue";
import AdminDashboard from "./Portal/Administrator/dashboard.vue";
import AdminEvents from "./Portal/Administrator/events.vue";
import AdminGallery from "./Portal/Administrator/gallery.vue";
import AdminBlogs from "./Portal/Administrator/blog.vue";
import AdminBlogCategory from "./Portal/Administrator/blog_category.vue";
import AdminFAQ from "./Portal/Administrator/faq.vue";
import AdminTestimonials from "./Portal/Administrator/testimonial.vue";
import AdminOurTeam from "./Portal/Administrator/team.vue";
import AdminPages from "./Portal/Administrator/pages.vue";
import AdminPagesCreate from "./Portal/Administrator/pages/form.vue";
import AdminSMS from "./Portal/Administrator/sms.vue";
import AdminDonation from "./Portal/Administrator/donation.vue";
import AdminBlogsForm from "./Portal/Administrator/blogs/form.vue";

export default [
    {
        path: "/admin",
        component: Front,
        meta: { isAdminAuthentication: false, isAdmin: true },
        children: [
            { path: "/admin", component: Login, name: "AdminLogin" },
            { path: "/admin/forgot-password", component: ForgotPassword, name: "ForgotPassword" },
            { path: "/admin/forgot-password-otp", component: ForgotPasswordOTP, name: "ForgotPasswordOTP" },
            { path: "/admin/reset-password/:security", component: ResetPassword, name: "ResetPassword", params: true },
        ],
    },
    { path: "/admin/dashboard", component: AdminDashboard, name: "AdminDashboard", meta: { isAdminAuthentication: true, isDashboard: true } },
    { path: "/admin/events", component: AdminEvents, name: "AdminEvents", meta: { isAdminAuthentication: true, isEvents: true } },
    { path: "/admin/gallery", component: AdminGallery, name: "AdminGallery", meta: { isAdminAuthentication: true, isGallery: true } },
    { path: "/admin/blogs", component: AdminBlogs, name: "AdminBlogs", meta: { isAdminAuthentication: true, isBlogs: true } },
    { path: "/admin/faq", component: AdminFAQ, name: "AdminFAQ", meta: { isAdminAuthentication: true, isFAQ: true } },
    { path: "/admin/testimonials", component: AdminTestimonials, name: "AdminTestimonials", meta: { isAdminAuthentication: true, isTestimonial: true } },
    { path: "/admin/our-team", component: AdminOurTeam, name: "AdminOurTeam", meta: { isAdminAuthentication: true, isOurTeam: true } },
    { path: "/admin/pages", component: AdminPages, name: "AdminPages", meta: { isAdminAuthentication: true, isPages: true } },
    { path: "/admin/pages/create", component: AdminPagesCreate, name: "AdminPagesCreate", meta: { isAdminAuthentication: true, isPages: true } },
    { path: "/admin/sms", component: AdminSMS, name: "AdminSMS", meta: { isAdminAuthentication: true, isSMS: true } },
    { path: "/admin/donations", component: AdminDonation, name: "AdminDonation", meta: { isAdminAuthentication: true, isDonations: true } },
    { path: "/admin/blogs/new", component: AdminBlogsForm, name: "AdminBlogsNew", meta: { isAdminAuthentication: true, isBlog: true }, params: true },
    { path: "/admin/blogs/edit/:id", component: AdminBlogsForm, name: "AdminBlogsEdit", meta: { isAdminAuthentication: true, isBlog: true }, params: true },
    { path: "/admin/blog-category", component: AdminBlogCategory, name: "AdminBlogCategory", meta: { isAdminAuthentication: true, isBlogsCategory: true } },
];
