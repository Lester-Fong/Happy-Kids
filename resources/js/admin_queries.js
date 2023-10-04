import axios from "axios";
import Vue from "vue";
import admin_requests from "./RequestQueries/admin_requests";

let requestNames = ["admin_outside_action"];

let getApiUrl = (queryName) => {
    let segment = "";

    if (requestNames.some((q) => q === queryName)) {
        segment = "";
    }

    console.log(segment);

    return `/graphql${segment}`;
};

Vue.prototype.$admin_queries = function (requestName, requestVariable) {
    let options = {
        method: "POST",
        url: getApiUrl(requestName),
        data: {
            query: admin_requests[requestName],
        },
    };

    requestVariable ? (options.data.variables = requestVariable) : null;

    return axios(options);
};
