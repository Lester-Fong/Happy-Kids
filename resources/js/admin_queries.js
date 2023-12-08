import axios from "axios";
import Vue from "vue";
import admin_requests from "./RequestQueries/admin_requests";

let uploadQueries = ["save_pages", "save_blogs"];

let adminRequestNames = ["get_admin", "blogs", "save_blogs", "blog_category", "save_blog_categories", "save_pages"];
let requestNames = ["admin_outside_action"];

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

Vue.prototype.$admin_queries = function (queryName, queryVariables) {
    var token = "";
    var secret_passphrase = process.env.MIX_SECRET_PASSPHRASE;

    if (adminRequestNames.some((q) => q === queryName)) {
        const encryptedToken = sessionStorage.getItem("admin_api_token");
        token = this.CryptoJS.AES.decrypt(encryptedToken, secret_passphrase).toString(this.CryptoJS.enc.Utf8);
    }

    let options = {
        method: "POST",
        url: getApiUrl(queryName),
        data: {
            query: admin_requests[queryName],
        },
    };

    if (uploadQueries.some((q) => q === queryName)) {
        let bodyFormData = new FormData();

        bodyFormData.set(
            "operations",

            JSON.stringify({
                query: admin_requests[queryName],
                variables: queryVariables,
            })
        );

        bodyFormData.set("operationName", null);

        bodyFormData.set(
            "map",
            JSON.stringify({ file: ["variables.file"], file1: ["variables.file1"], file2: ["variables.file2"], file3: ["variables.file3"], file4: ["variables.file4"], file5: ["variables.file5"], selectedFileHow: ["variables.selectedFileHow"], selectedFileRoles: ["variables.selectedFileRoles"], selectedFileCore: ["variables.selectedFileCore"], thumbnail: ["variables.thumbnail"] })
        );
        if (queryVariables.file || queryVariables.file1 || queryVariables.file2 || queryVariables.file3 || queryVariables.file4 || queryVariables.file5) {
            bodyFormData.append("file", queryVariables.file);
            bodyFormData.append("file1", queryVariables.file1);
            bodyFormData.append("file2", queryVariables.file2);
            bodyFormData.append("file3", queryVariables.file3);
            bodyFormData.append("file4", queryVariables.file4);
            bodyFormData.append("file5", queryVariables.file5);
        }

        if (queryVariables.thumbnail) {
            bodyFormData.append("thumbnail", queryVariables.thumbnail);
        }

        if (queryVariables.selectedFileHow) {
            for (let index = 0; index < queryVariables.selectedFileHow.length; index++) {
                bodyFormData.append("selectedFileHow[" + index + "]", queryVariables.selectedFileHow[index]);
            }
        }

        if (queryVariables.selectedFileRoles) {
            for (let index = 0; index < queryVariables.selectedFileRoles.length; index++) {
                bodyFormData.append("selectedFileRoles[" + index + "]", queryVariables.selectedFileRoles[index]);
            }
        }

        if (queryVariables.selectedFileCore) {
            for (let index = 0; index < queryVariables.selectedFileCore.length; index++) {
                bodyFormData.append("selectedFileCore[" + index + "]", queryVariables.selectedFileCore[index]);
            }
        }

        //var upload_url = "/graphql";
        var upload_url = getApiUrl(queryName);

        return axios.post(upload_url, bodyFormData, {
            headers: {
                "Content-Type": "multipart/form-data",
                Authorization: `Bearer ${token}`,
            },
        });
    }

    queryVariables ? (options.data.variables = queryVariables) : null;

    if (token) {
        options.headers = {
            Authorization: `Bearer ${token}`,
            "Cache-Control": "no-cache, max-age=3600",
        };
    }

    return axios(options);
};
