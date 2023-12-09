<template>
    <div>
        <div class="loader-gif" v-if="is_loading"></div>
        <h1>Administrator</h1>

        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <table id="admin_table" class="table table-striped dt-table-hover" style="width: 100%">
                        <thead class="mb-4">
                            <tr>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="a in administrators" :key="a.id">
                                <td>
                                    {{ formatFullname(a.firstname, a.lastname) }}
                                </td>
                                <td>
                                    {{ a.mobile }}
                                </td>
                                <td>
                                    {{ a.email }}
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
                                        <a href="javascript:void(0);" class="dropdown-item" @click="onEditBlogCategory(a)"> Edit </a>
                                        <a href="javascript:void(0);" class="dropdown-item" @click="onDeleteRecord(a.administrator_id)">Delete </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <administrator-form :selected_admin="selected_admin" :is_edit="is_edit" @onHideModal="hideModal" @success="onSuccess" />
    </div>
</template>

<script>
import AdministratorForm from "./administrator/form.vue";

export default {
    metaInfo: {
        title: "Admin - Administrator",
    },

    components: { AdministratorForm },

    data() {
        return {
            administrators: [],
            filteredAdmin: [],
            is_loading: false,
            is_edit: false,
            selected_admin: {},
        };
    },

    created() {
        this.onPopulateData();
    },

    methods: {
        onPopulateData() {
            this.is_loading = true;
            this.$admin_queries("get_admin", {
                action_type: "display_all",
            })
                .then((res) => {
                    this.is_loading = false;
                    this.filteredAdmin = res.data.data.administrator;
                })
                .catch(() => {
                    this.is_loading = false;
                    Swal.fire("Error!", this.global_error_message, "error");
                });
        },

        onCreateRecord() {
            this.is_edit = false;
            $("#admin_modal").modal("show");
        },

        onEditBlogCategory(data) {
            this.is_edit = true;
            $("#admin_modal").modal("show");
            this.selected_admin = data;
        },

        onDeleteRecord(administrator_id) {
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
                    this.$admin_queries("save_admin", {
                        admin: {
                            administrator_id: administrator_id,
                            action_type: "delete_record",
                        },
                    })
                        .then((res) => {
                            this.is_loading = false;

                            let response = res.data.data.administrator;

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
            $("#admin_modal").modal("hide");
            this.is_edit = false;
        },

        onSuccess() {
            this.is_edit = false;
            $("#admin_modal").modal("hide");
            this.onPopulateData();
        },
    },

    watch: {
        administrators() {
            this.$nextTick(() => {
                this.datatable = this.onDatatable("#admin_table", true);
            });
        },

        filteredAdmin: function (value) {
            $("#admin_table").DataTable().destroy();
            this.administrators = this.filteredAdmin;
        },
    },
};
</script>
