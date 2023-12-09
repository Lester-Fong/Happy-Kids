<template>
    <div>
        <div class="loader-gif" v-if="is_calling_api"></div>
        <form @submit.prevent="onVerifyOTP" class="form">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h2>2-Step Verification</h2>
                            <p>Enter the code for verification.</p>
                        </div>
                        <div class="col-sm-2 col-3 ms-auto">
                            <div class="mb-3">
                                <input type="text" class="form-control opt-input" v-model="OTP_1" />
                            </div>
                        </div>
                        <div class="col-sm-2 col-3">
                            <div class="mb-3">
                                <input type="text" class="form-control opt-input" v-model="OTP_2" />
                            </div>
                        </div>
                        <div class="col-sm-2 col-3">
                            <div class="mb-3">
                                <input type="text" class="form-control opt-input" v-model="OTP_3" />
                            </div>
                        </div>
                        <div class="col-sm-2 col-3 me-auto">
                            <div class="mb-3">
                                <input type="text" class="form-control opt-input" v-model="OTP_4" />
                            </div>
                        </div>
                        <div class="col-sm-2 col-3 me-auto">
                            <div class="mb-3">
                                <input type="text" class="form-control opt-input" v-model="OTP_5" />
                            </div>
                        </div>
                        <div class="col-sm-2 col-3 me-auto">
                            <div class="mb-3">
                                <input type="text" class="form-control opt-input" v-model="OTP_6" />
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="mb-4">
                                <button type="submit" class="btn btn-secondary w-100">VERIFY</button>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="text-center">
                                <p class="mb-0">Didn't receive the code ? <a href="javascript:void(0);" @click="onResendOTP" class="text-warning">Resend</a></p>
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
    data() {
        return {
            OTP_1: "",
            OTP_2: "",
            OTP_3: "",
            OTP_4: "",
            OTP_5: "",
            OTP_6: "",
            is_calling_api: false,
        };
    },
    created() {
        if (sessionStorage.getItem("email") == null) {
            this.$router.replace({ name: "ForgotPassword" });
        }
    },
    mounted() {
        this.onOTPForm();
    },

    methods: {
        onVerifyOTP() {
            let otp = this.OTP_1 + this.OTP_2 + this.OTP_3 + this.OTP_4 + this.OTP_5 + this.OTP_6;
            this.is_calling_api = true;
            this.$admin_queries("admin_outside_action", {
                admin: {
                    otp: otp,
                    email: sessionStorage.getItem("email"),
                    action_type: "forgot_password_check_otp",
                },
            }).then((res) => {
                let response = res.data.data.administrator;
                this.is_calling_api = false;
                if (!response.error) {
                    Swal.fire("Success", response.message, "success")
                        .then(() => {
                            this.$router.push({ name: "ResetPassword", params: { security: response.reset_password_security } });
                        })
                        .catch((err) => {
                            console.error(err);
                        });
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            });
        },
        onResendOTP() {
            this.is_calling_api = true;
            this.$admin_queries("admin_outside_action", {
                admin: {
                    email: sessionStorage.getItem("email"),
                    action_type: "verify_email",
                },
            })
                .then((res) => {
                    this.is_calling_api = false;
                    let response = res.data.data.administrator;

                    if (!response.error) {
                        Swal.fire("Success", response.message, "success");
                    } else {
                        Swal.fire("Error", response.message, "error");
                    }
                })
                .catch((err) => {
                    console.error(err);
                    this.is_calling_api = false;
                    Swal.fire("Error!", this.global_error_message, "error");
                });
        },
    },
};
</script>
