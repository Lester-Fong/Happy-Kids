<template>
    <div>
        <div v-if="is_loading" class="loader-gif"></div>
        <div class="modal fade show" tabindex="-1" id="donate_modal" data-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content bg-light">
                    <!-- HEADER -->
                    <div class="modal-header justify-content-center">
                        <h5>Donate Now &#9829;</h5>
                    </div>
                    <form @submit.prevent="onSubmit">
                        <!-- BODY -->
                        <div class="modal-body d-flex justify-content-center flex-column px-5 pt-4">
                            <div class="d-flex justify-content-between px-5">
                                <button v-for="(value, index) in prices" :key="index" class="btn btn-md btn-outline-secondary rounded-pill" :class="{ active: amount === value }" @click="handleButtonClick(value)" type="button">₱{{ value }}</button>
                            </div>

                            <!-- input with ₱ at left -->
                            <div class="input-group mt-3 px-5">
                                <span class="input-group-text">₱</span>
                                <input @keypress="checkInput" type="text" class="form-control fs-24" aria-label="Amount (to the nearest dollar)" v-model="amount" />
                                <span class="input-group-text">.00</span>
                            </div>

                            <span class="text-danger mb-0 px-5">{{ amount_error }}</span>
                        </div>

                        <div class="modal-footer border-0 pt-0">
                            <div class="d-flex align-items-center">
                                <a @click="onHideModal" href="javaScript:void(0)" class="me-2">Cancel</a>

                                <button type="submit" class="btn button--primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            is_loading: false,
            prices: [50, 200, 500, 1000],
            amount: null,
            amount_error: "",
        };
    },

    methods: {
        onHideModal() {
            this.$emit("onHideModal");
            this.onClearFields();
            this.onClearErrors();
        },

        handleButtonClick(value) {
            this.amount = value;
        },

        onSubmit() {
            this.onClearErrors();

            this.is_loading = true;
            this.$front_queries("save_donate", {
                donate: {
                    amount: parseInt(this.amount),
                    action_type: "donate",
                },
            })
                .then((res) => {
                    this.is_loading = false;

                    if (res.data.errors) {
                        let errors = Object.values(res.data.errors[0].extensions.validation).flat();
                        let errors_keys = Object.keys(res.data.errors[0].extensions.validation).flat();

                        this.amount_error = errors_keys.some((q) => q == "donate.amount") ? errors[errors_keys.indexOf("donate.amount")] : "";
                    } else {
                        let response = res.data.data.donate;

                        if (!response.error) {
                            this.onClearFields();
                            this.onClearErrors();
                            Swal.fire("Success!", response.message, "success").then(() => {
                                this.$emit("success");
                                // redirect to response.href
                                window.location.href = response.href;
                                this.is_loading = true;
                            });
                        } else {
                            Swal.fire("Error!", response.message, "error");
                        }
                    }
                })
                .catch(() => {
                    this.is_loading = false;
                    Swal.fire("Error!", this.global_error_message, "error");
                });
        },

        onClearFields() {
            this.amount = "";
        },

        onClearErrors() {
            this.amount_error = "";
        },

        checkInput(event) {
            let keyCode = event.keyCode ? event.keyCode : event.which;
            if (keyCode < 48 || keyCode > 57) {
                // 48-57 are the key codes for 0-9
                event.preventDefault();
            }
        },
    },
};
</script>
