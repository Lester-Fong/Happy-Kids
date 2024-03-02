<template>
    <div>
        <div class="loader-gif" v-if="is_calling_api"></div>
        <form @submit.prevent="onSubmitForm" class="form">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h2>Multi Factor Authentication</h2>
                            <p>Enter the verification code from your authentication application.</p>
                        </div>
                        <div v-if="!is_mfa">
                            <div class="d-flex justify-content-center w-150px border border-dark mx-auto mb-3 p-2">
                                <qr-code :size="130" :text="qrcode" color="#000" />
                            </div>

                            <div class="form-group my-2 text-center">
                                <p class="small-font">
                                    MFA Key: <span>{{ secret_key }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="mb-3">
                                <label class="form-label">MFA Code</label>
                                <input type="text" class="form-control" v-model="code" />
                                <p class="text-warning">{{ mfa_error }}</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-4">
                                <button type="submit" class="btn btn-secondary w-100 mb-2">VERIFY</button>
                                <p>Why am I seeing this? <a target="_blank" href="https://www.google.com/landing/2step/">Learn more about MFA</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: ["admin_email", "admin_password"],

    data() {
        return {
            code: "",
            qrcode: "",
            secret_key: "",
            mfa_error: "",
            is_mfa: false,
            is_calling_api: false,
        };
    },

    created() {
        this.onCreate();
    },

    methods: {
        onCreate() {
            this.$admin_queries("admin_outside_action", {
                admin: {
                    email: this.admin_email,
                    action_type: "display_mfa",
                },
            })
                .then((res) => {
                    let response = res.data.data.administrator;

                    if (response.otp_key == "") {
                        this.qrcode = response.qr_url;
                        this.secret_key = response.secret;
                        this.is_mfa = false;
                    } else {
                        this.is_mfa = true;
                        this.secret_key = response.otp_key;
                    }
                })
                .catch(() => {
                    Swal.fire("Error!", this.global_error_message, "error");
                });
        },

        onSubmitForm() {
            this.is_calling_api = true;

            this.mfa_error = "";

            if (this.code) {
                this.$admin_queries("admin_outside_action", {
                    admin: {
                        code: this.code,
                        secret_key: this.secret_key,
                        email: this.admin_email,
                        password: this.admin_password,
                        action_type: "validate_mfa",
                    },
                })
                    .then((res) => {
                        this.is_calling_api = false;

                        let response = res.data.data.administrator;
                        if (response.error == false) {
                            const encryptedToken = this.CryptoJS.AES.encrypt(response.access_token, process.env.MIX_SECRET_PASSPHRASE).toString();
                            sessionStorage.setItem("admin_api_token", encryptedToken);
                            sessionStorage.setItem("login_type", "admin");
                            this.$appEvents.$emit("admin-login");

                            this.$router.push({ name: "AdminDashboard" });
                        } else {
                            Swal.fire("Error!", response.message, "error");
                        }
                    })
                    .catch(() => {
                        this.is_calling_api = false;
                        Swal.fire("Error!", this.global_error_message, "error");
                    });
            } else {
                this.is_calling_api = false;
                this.mfa_error = "Please input a code";
            }
        },
    },
};
</script>
