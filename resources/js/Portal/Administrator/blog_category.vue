<template>
    <div>
        <div class="loader-gif" v-if="is_loading"></div>
        <h1>Blogs Category</h1>

        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <table id="blogs_category_table" class="table table-striped dt-table-hover" style="width: 100%">
                        <thead class="mb-4">
                            <tr>
                                <th>Title</th>
                                <th>Date Created</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="a in blog_categories" :key="a.id">
                                <td>
                                    {{ a.name }}
                                </td>
                                <td>
                                    {{ a.date_created | formatTransDateWithTime }}
                                </td>
                                <td class="text-center dropdown">
                                    <a class="dropdown-toggle" href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a href="javascript:void(0);" class="dropdown-item" @click="onEditBlogCategory(a)"> Edit Blog </a>
                                        <a href="javascript:void(0);" class="dropdown-item" @click="onDeleteCategory(a.category_id)">Delete Blog</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <blog-category-form :selected_blog_category="selected_blog_category" :is_edit="is_edit" @onHideModal="hideModal" @success="onSuccess" />
    </div>
</template>

<script>
import BlogCategoryForm from "./blog_category/form.vue";
export default {
    components: {
        BlogCategoryForm,
    },

    data() {
        return {
            blog_categories: [],
            filteredCategory: [],
            is_loading: false,
            is_edit: false,
            selected_blog_category: {},
        };
    },

    created() {
        this.onPopulateData();
    },

    methods: {
        onPopulateData() {
            this.is_loading = true;
            this.$admin_queries("blog_category", {
                action_type: "display_all",
            })
                .then((res) => {
                    console.log("res: ", res);
                    this.is_loading = false;
                    this.filteredCategory = res.data.data.blog_category;
                })
                .catch(() => {
                    this.is_loading = false;
                    Swal.fire("Error!", this.global_error_message, "error");
                });
        },

        onCreateRecord() {
            this.is_edit = false;
            $("#blog_category_modal").modal("show");
            // this.$router.replace({ name: "AdminBlogsNew" });
        },

        onEditBlogCategory(data) {
            this.is_edit = true;
            $("#blog_category_modal").modal("show");
            this.selected_blog_category = data;
        },

        onDeleteCategory(category_id) {
            Swal.fire({
                title: "Are you sure?",
                html: "You want to delete this record?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it",
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then((res) => {
                if (res.isConfirmed == true) {
                    this.is_loading = true;
                    this.$admin_queries("save_blog_categories", {
                        blog_category: {
                            category_id: category_id,
                            action_type: "delete_record",
                        },
                    })
                        .then((res) => {
                            this.is_loading = false;

                            let response = res.data.data.blog_category;

                            if (response.error == false) {
                                Swal.fire("Success!", response.message, "success");
                                this.onPopulateData();
                            } else {
                                Swal.fire("Error!", response.message, "error");
                            }
                        })
                        .catch(() => {
                            this.is_loading = false;
                            Swal.fire("Error!", this.global_error_message, "error");
                        });
                }
            });
        },

        hideModal() {
            $("#blog_category_modal").modal("hide");
            this.is_edit = false;
        },

        onSuccess() {
            this.is_edit = false;
            $("#blog_category_modal").modal("hide");
            this.onPopulateData();
        },
    },

    watch: {
        blog_categories() {
            this.$nextTick(() => {
                this.datatable = this.onDatatable("#blogs_category_table", true);
            });
        },

        filteredCategory: function (value) {
            $("#blogs_category_table").DataTable().destroy();
            this.blog_categories = this.filteredCategory;
        },
    },
};
</script>
