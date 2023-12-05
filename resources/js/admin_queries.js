import axios from "axios";
import Vue from "vue";
import admin_requests from "./RequestQueries/admin_requests";

let requestNames = ["admin_outside_action"];

let adminRequestNames = ["get_admin", "blogs", "save_blogs", "blog_categories", "save_blog_categories"];

let getApiUrl = (queryName) => {
    let segment = "";

    if (requestNames.some((q) => q === queryName)) {
        segment = "";
    }

    if (adminRequestNames.some((q) => q === queryName)) {
        segment = "/admin";
    }
    return `/graphql${segment}`;
};

Vue.prototype.$admin_queries = function (requestName, requestVariable) {
    var token = "";
    var secret_passphrase = process.env.MIX_SECRET_PASSPHRASE;

    if (adminRequestNames.some((q) => q === requestName)) {
        const encryptedToken = sessionStorage.getItem("admin_api_token");
        token = this.CryptoJS.AES.decrypt(encryptedToken, secret_passphrase).toString(this.CryptoJS.enc.Utf8);
    }

    let options = {
        method: "POST",
        url: getApiUrl(requestName),
        data: {
            query: admin_requests[requestName],
        },
    };

    requestVariable ? (options.data.variables = requestVariable) : null;

    if (token) {
        options.headers = {
            Authorization: `Bearer ${token}`,
            "Cache-Control": "no-cache, max-age=3600",
        };
    }

    return axios(options);
};
