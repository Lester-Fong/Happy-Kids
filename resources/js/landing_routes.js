import index from "./LandingPages/index.vue";
import HomePage from "./LandingPages/homepage.vue";
import AboutPage from "./LandingPages/about.vue";
import OurTeamPage from "./LandingPages/ourteam.vue";
import FAQPage from "./LandingPages/faq.vue";
import FeedingProgramPage from "./LandingPages/feeding_program.vue";
import ScholarshipProgramPage from "./LandingPages/scholarship_program.vue";
import EventsPage from "./LandingPages/events.vue";
import StoriesPage from "./LandingPages/blogs.vue";
import ContactPage from "./LandingPages/contact.vue";
import StoriesDetailsPage from "./LandingPages/blogs/details.vue";
import SuccessPaypal from "./LandingPages/paypal/success.vue";
import CancelPaypal from "./LandingPages/paypal/cancel.vue";

export default [
    {
        path: "/",
        component: index,
        children: [
            { path: "/", component: HomePage, name: "HomePage" },
            { path: "/about", component: AboutPage, name: "AboutPage" },
            { path: "/ourteam", component: OurTeamPage, name: "OurTeamPage" },
            { path: "/faq", component: FAQPage, name: "FAQPage" },
            { path: "/feeding-program", component: FeedingProgramPage, name: "FeedingProgramPage" },
            { path: "/scholarship-program", component: ScholarshipProgramPage, name: "ScholarshipProgramPage" },
            { path: "/events", component: EventsPage, name: "EventsPage" },
            { path: "/stories", component: StoriesPage, name: "StoriesPage" },
            { path: "/contact", component: ContactPage, name: "ContactPage" },
            { path: "/stories/:slug", component: StoriesDetailsPage, name: "StoriesDetailsPage", params: true },
            { path: "/paypal/success", component: SuccessPaypal, name: "SuccessPaypal", query: true },
            { path: "/paypal/cancel", component: CancelPaypal, name: "CancelPaypal", query: true },
        ],
    },
];
