<template>
    <div class="loader-gif" v-if="is_loading"></div>
    <!-- <div v-else class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="success-content">
                    <h2>Thank you for your donation!</h2>
                    <p>Your donation has been successfully processed. You will receive an email confirmation shortly.</p>
                    <p>Thank you for your support!</p>
                </div>
            </div>
        </div>
    </div> -->
</template>

<script>
export default {
    data() {
        return {
            token: this.$route.query.token,
            is_loading: false,
        };
    },

    created() {
        this.onCapturePaymentOrder();
    },

    methods: {
        onCapturePaymentOrder() {
            this.is_loading = true;
            this.$front_queries("save_donate", {
                donate: {
                    token: this.token,
                    action_type: "success_capture",
                },
            })
                .then((res) => {
                    this.is_loading = false;
                    let response = res.data.data.donate;

                    if (!response.error) {
                        Swal.fire("Success!", response.message, "success");
                        this.$router.push({ name: "HomePage" }).then(() => {
                            Swal.fire("Success!", "Thank you for your donation. We appreciate your support!", "success");
                        });
                    } else {
                        Swal.fire("Error!", response.message, "error");
                        this.$router.push({ name: "HomePage" });
                    }
                })
                .catch(() => {
                    this.is_loading = false;
                    Swal.fire("Error!", this.global_error_message, "error");
                    this.$router.push({ name: "HomePage" });
                });
        },
    },
};
</script>
