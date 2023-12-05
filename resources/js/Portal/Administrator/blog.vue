<template>
    <div>
        <div class="loader-gif" v-if="is_loading"></div>
        <h1>Blogs/Stories Page</h1>

        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <table id="blogs_table" class="table table-striped dt-table-hover" style="width: 100%">
                        <thead class="mb-4">
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Date Created</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="blog in blogs" :key="blog.id">
                                <td>
                                    <span>
                                        <img :src="`/public/uploads/blog_thumbnail/${blog.original_blogs_id}/thumb/${blog.thumbnail}`" onerror="this.src='/public/uploads/default.jpg'" v-if="blog.thumbnail != ''" width="75" />
                                    </span>
                                </td>
                                <td>
                                    {{ blog.title }}
                                </td>
                                <td>
                                    {{ blog.date | formatTransDate }}
                                </td>
                                <td class="text-center dropdown">
                                    <a class="dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                        <router-link class="dropdown-item" :to="'/admin/blogs/edit/' + blog.blogs_id"> Edit Blog </router-link>
                                        <a href="javascript:void(0);" class="dropdown-item" @click="onDeleteBlog(blog)">Delete Blog</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            blogs: [],
            filteredBlogs: [],
            is_loading: false,
            is_edit: false,
            selected_list: {},
        };
    },

    created() {
        this.onPopulateData();
    },

    methods: {
        onPopulateData() {
            this.is_loading = true;
            this.$admin_queries("blogs", {
                action_type: "display_all",
            })
                .then((res) => {
                    this.is_loading = false;
                    this.filteredBlogs = res.data.data.blogs;
                })
                .catch(() => {
                    this.is_loading = false;
                    Swal.fire("Error!", this.global_error_message, "error");
                });
        },

        onCreateRecord() {
            this.is_edit = false;
            this.$router.replace("/admin/blogs/new");
        },

        onDeleteBlog(blogs) {
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
                    this.$admin_queries("save_blogs", {
                        blogs: {
                            blogs_id: blogs.blogs_id,
                            action_type: "delete_record",
                        },
                    })
                        .then((res) => {
                            this.is_loading = false;

                            let response = res.data.data.blogs;

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
    },

    watch: {
        blogs() {
            this.$nextTick(() => {
                this.datatable = this.onDatatable("#blogs_table", true);
            });
        },

        filteredBlogs: function (value) {
            $("#blogs_table").DataTable().destroy();
            this.blogs = this.filteredBlogs;
        },
    },
};
</script>
