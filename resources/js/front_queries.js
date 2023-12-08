import axios from "axios";
import Vue from "vue";
import front_requests from "./RequestQueries/front_requests";

Vue.prototype.$front_queries = function (queryName, queryVariables) {
    let options = {
        url: "/graphql",
        method: "POST",
        data: {
            query: front_requests[queryName],
        },
    };

    if (queryVariables) {
        options.data.variables = queryVariables;
    }

    return axios(options);
};
