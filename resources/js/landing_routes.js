import axios from "axios";

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

const onAddViewsToPage = async (to, from, next) => {
    var currentPage = to?.path;
    currentPage = currentPage?.replace("/", "");
    let options = {
        url: "/graphql",
        method: "POST",
        data: {
            query: `query front($action_type: String!, $currentPage: String) {
                front(action_type: $action_type, currentPage: $currentPage) {
                    pages {
                      encrypted_pages_id,
                    }
                }
            }`,
            variables: {
                action_type: "add_page_views",
                currentPage: currentPage === "" ? "home" : currentPage,
            },
        },
    };

    let response = await axios(options);
    response = await response.data.data.front.pages;
    if (Object.keys(response).length > 0) {
        next();
    } else {
        window.history.back();
        return false;
    }
};

export default [
    {
        path: "/",
        component: index,
        children: [
            {
                path: "/",
                component: HomePage,
                name: "HomePage",
                beforeEnter: onAddViewsToPage,
            },
            {
                path: "/about",
                component: AboutPage,
                name: "AboutPage",
                beforeEnter: onAddViewsToPage,
            },
            { path: "/ourteam", component: OurTeamPage, name: "OurTeamPage", beforeEnter: onAddViewsToPage },
            { path: "/faq", component: FAQPage, name: "FAQPage", beforeEnter: onAddViewsToPage },
            { path: "/feeding-program", component: FeedingProgramPage, name: "FeedingProgramPage", beforeEnter: onAddViewsToPage },
            { path: "/scholarship-program", component: ScholarshipProgramPage, name: "ScholarshipProgramPage", beforeEnter: onAddViewsToPage },
            { path: "/events", component: EventsPage, name: "EventsPage", beforeEnter: onAddViewsToPage },
            { path: "/stories", component: StoriesPage, name: "StoriesPage", beforeEnter: onAddViewsToPage },
            { path: "/contact", component: ContactPage, name: "ContactPage", beforeEnter: onAddViewsToPage },
            { path: "/stories/:slug", component: StoriesDetailsPage, name: "StoriesDetailsPage", params: true },
            { path: "/paypal/success", component: SuccessPaypal, name: "SuccessPaypal", query: true },
            { path: "/paypal/cancel", component: CancelPaypal, name: "CancelPaypal", query: true },
        ],
    },
];
