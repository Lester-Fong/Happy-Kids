<template>
    <div>
        <div class="loader-gif" v-if="is_calling_api"></div>
        <div v-if="!isAuthenticate">
            <form @submit.prevent="onSubmitForm" class="form">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <h2>Sign In</h2>
                                <p>Enter your email and password to login</p>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" v-model="admin_email" />
                                    <p class="text-warning">{{ email_error }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-4">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" v-model="admin_password" />
                                    <p class="text-warning">{{ password_error }}</p>
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <router-link :to="{ name: 'ForgotPassword' }">Forgot Password?</router-link>
                            </div>

                            <div class="col-12">
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-secondary w-100">SIGN IN</button>
                                </div>
                            </div>

                            <!-- <div class="col-12 mb-4">
                            <div class="">
                                <div class="seperator">
                                    <hr />
                                    <div class="seperator-text"><span>Or continue with</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-12">
                            <div class="mb-4">
                                <button class="btn btn-social-login w-100">
                                    <img src="/public/src/assets/img/google-gmail.svg" class="img-fluid" />
                                    <span class="btn-text-inner">Google</span>
                                </button>
                            </div>
                        </div>

                        <div class="col-sm-4 col-12">
                            <div class="mb-4">
                                <button class="btn btn-social-login w-100">
                                    <img src="/public/src/assets/img/github-icon.svg" class="img-fluid" />
                                    <span class="btn-text-inner">Github</span>
                                </button>
                            </div>
                        </div>

                        <div class="col-sm-4 col-12">
                            <div class="mb-4">
                                <button class="btn btn-social-login w-100">
                                    <img src="/public/src/assets/img/twitter.svg" class="img-fluid" />
                                    <span class="btn-text-inner">Twitter</span>
                                </button>
                            </div>
                        </div> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div v-else>
            <googlemfa :admin_email="admin_email" :admin_password="admin_password" />
        </div>
    </div>
</template>

<script>
import googlemfa from "./google_authentication.vue";

export default {
    components: {
        googlemfa,
    },

    data() {
        return {
            admin_email: "",
            admin_password: "",
            is_calling_api: false,

            email_error: "",
            password_error: "",
            isAuthenticate: false,
        };
    },
    methods: {
        onSubmitForm() {
            this.is_calling_api = true;
            this.$admin_queries("admin_outside_action", {
                admin: {
                    email: this.admin_email,
                    password: this.admin_password,
                    action_type: "login",
                },
            })
                .then((res) => {
                    this.is_calling_api = false;
                    if (res.data.errors) {
                        let errors = Object.values(res.data.errors[0].extensions.validation).flat();
                        let errors_keys = Object.keys(res.data.errors[0].extensions.validation).flat();

                        this.email_error = errors_keys.some((q) => q == "admin.email") ? errors[errors_keys.indexOf("admin.email")] : "";
                        this.password_error = errors_keys.some((q) => q == "admin.password") ? errors[errors_keys.indexOf("admin.password")] : "";
                    } else {
                        let response = res.data.data.administrator;
                        if (!response.error) {
                            this.isAuthenticate = true;
                        } else {
                            Swal.fire("Error!", response.message, "error");
                        }
                    }
                })
                .catch(() => {
                    this.is_calling_api = false;
                    Swal.fire("Error!", this.global_error_message, "error");
                });
        },
    },
};
</script>
