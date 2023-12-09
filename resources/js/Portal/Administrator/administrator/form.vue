<template>
    <div>
        <div v-if="is_loading" class="loader-gif"></div>

        <div class="modal fade show" tabindex="-1" id="admin_modal" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content bg-light">
                    <!-- HEADER -->
                    <div class="modal-header">
                        <h6 class="text-center">Administrator</h6>
                    </div>
                    <form @submit.prevent="onSubmit">
                        <!-- BODY -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6 mb-2">
                                    <label for="name" class="small-font">Firstname</label>
                                    <span class="text-warning">*</span>

                                    <input v-model="firstname" type="text" class="form-control form-control-sm" id="firstname" />
                                    <span class="text-warning mb-0">{{ firstname_error }}</span>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <label for="name" class="small-font">Lastname</label>
                                    <span class="text-warning">*</span>

                                    <input v-model="lastname" type="text" class="form-control form-control-sm" id="lastname" />
                                    <span class="text-warning mb-0">{{ lastname_error }}</span>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <label for="name" class="small-font">Email</label>
                                    <span class="text-warning">*</span>

                                    <input v-model="email" type="email" class="form-control form-control-sm" id="email" />
                                    <span class="text-warning mb-0">{{ email_error }}</span>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <label for="name" class="small-font">Password</label>
                                    <span class="text-warning">*</span>

                                    <input v-model="password" type="password" class="form-control form-control-sm" id="password" />
                                    <span class="text-warning mb-0">{{ password_error }}</span>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <label for="name" class="small-font">Mobile Number</label>

                                    <input v-model="mobile" type="text" class="form-control form-control-sm" id="mobile" />
                                </div>
                            </div>
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
    props: ["is_edit", "selected_admin"],

    data() {
        return {
            is_loading: false,
            firstname: "",
            firstname_error: "",
            lastname: "",
            lastname_error: "",
            email: "",
            email_error: "",
            password: "",
            password_error: "",
            mobile: "",
            admin_id: "",
        };
    },

    methods: {
        onHideModal() {
            this.$emit("onHideModal");
            this.onClearFields();
            this.onClearErrors();
        },

        onSubmit() {
            this.onClearErrors();
            this.is_loading = true;
            this.$admin_queries("save_admin", {
                admin: {
                    firstname: this.firstname,
                    lastname: this.lastname,
                    email: this.email,
                    password: this.password,
                    mobile: this.mobile,
                    administrator_id: this.admin_id,
                    action_type: this.is_edit ? "update_record" : "new_record",
                },
            })
                .then((res) => {
                    this.is_loading = false;

                    if (res.data.errors) {
                        let errors = Object.values(res.data.errors[0].extensions.validation).flat();
                        let errors_keys = Object.keys(res.data.errors[0].extensions.validation).flat();

                        this.firstname_error = errors_keys.some((q) => q == "admin.firstname") ? errors[errors_keys.indexOf("admin.firstname")] : "";
                        this.lastname_error = errors_keys.some((q) => q == "admin.lastname") ? errors[errors_keys.indexOf("admin.lastname")] : "";
                        this.email_error = errors_keys.some((q) => q == "admin.email") ? errors[errors_keys.indexOf("admin.email")] : "";
                        this.password_error = errors_keys.some((q) => q == "admin.password") ? errors[errors_keys.indexOf("admin.password")] : "";
                    } else {
                        let response = res.data.data.administrator;

                        if (!response.error) {
                            this.onClearFields();
                            this.onClearErrors();
                            Swal.fire("Success!", response.message, "success").then(() => {
                                this.$emit("success");
                            });
                        } else {
                            Swal.fire("Error!", "Record saving failed.", "error");
                        }
                    }
                })
                .catch(() => {
                    this.is_loading = false;
                    Swal.fire("Error!", this.global_error_message, "error");
                });
        },

        onClearErrors() {
            this.firstname_error = "";
            this.lastname_error = "";
            this.email_error = "";
            this.password_error = "";
        },

        onClearFields() {
            this.firstname = "";
            this.lastname = "";
            this.email = "";
            this.password = "";
            this.mobile = "";
        },
    },

    watch: {
        is_edit(val) {
            if (val) {
                this.firstname = this.selected_admin.firstname;
                this.lastname = this.selected_admin.lastname;
                this.email = this.selected_admin.email;
                this.mobile = this.selected_admin.mobile;
                this.admin_id = this.selected_admin.administrator_id;
            }
        },
    },
};
</script>
