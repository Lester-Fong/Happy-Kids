<template>
    <div>
        <div v-if="is_loading" class="loader-gif"></div>
        <div class="modal fade show" tabindex="-1" id="blog_category_modal" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content bg-light">
                    <!-- HEADER -->
                    <div class="modal-header">
                        <h6 class="text-center">Blog Category</h6>
                    </div>
                    <form @submit.prevent="onSubmit">
                        <!-- BODY -->
                        <div class="modal-body">
                            <label for="name" class="small-font">Name</label>
                            <span class="text-warning">*</span>

                            <input v-model="name" type="text" class="form-control form-control-sm" id="name" />
                            <span class="text-warning mb-0">{{ name_error }}</span>
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
    props: ["is_edit", "selected_blog_category"],
    data() {
        return {
            is_loading: false,
            name: "",
            name_error: "",
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
            this.$admin_queries("save_blog_categories", {
                blog_category: {
                    name: this.name,
                    category_id: this.selected_blog_category.category_id,
                    action_type: this.is_edit ? "update_record" : "new_record",
                },
            })
                .then((res) => {
                    this.is_loading = false;

                    if (res.data.errors) {
                        let errors = Object.values(res.data.errors[0].extensions.validation).flat();
                        let errors_keys = Object.keys(res.data.errors[0].extensions.validation).flat();

                        this.name_error = errors_keys.some((q) => q == "blog_category.name") ? errors[errors_keys.indexOf("blog_category.name")] : "";
                    } else {
                        let response = res.data.data.blog_category;

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
            this.name_error = "";
        },

        onClearFields() {
            this.name = "";
        },
    },

    watch: {
        is_edit(val) {
            if (val) {
                this.name = this.selected_blog_category.name;
            }
        },
    },
};
</script>
