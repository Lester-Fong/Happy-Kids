import index from "./LandingPages/index.vue";
import HomePage from "./LandingPages/homepage.vue";
import AboutPage from "./LandingPages/about.vue";
import OurTeamPage from "./LandingPages/ourteam.vue";

export default [
    {
        path: "/",
        component: index,
        name: "index",
        children: [
            { path: "/", component: HomePage, name: "HomePage" },
            { path: "/about", component: AboutPage, name: "AboutPage" },
            { path: "/ourteam", component: OurTeamPage, name: "OurTeamPage" },
        ],
    },
];
