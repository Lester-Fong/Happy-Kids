<template>
    <div>
        <div class="loader-gif" v-if="is_loading"></div>
        <h1>Recent Supporters</h1>

        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <table id="donators_table" class="table table-striped dt-table-hover" style="width: 100%">
                        <thead class="mb-4">
                            <tr>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Country</th>
                                <th>Date Given</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="a in donators" :key="a.id">
                                <td>
                                    {{ formatFullname(a.firstname, a.lastname) }}
                                </td>
                                <td>
                                    {{ a.email }}
                                </td>
                                <td>
                                    {{ a.country }}
                                </td>
                                <td>
                                    {{ a.date_created | formatTransDateWithTime2 }}
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
    metaInfo: {
        title: "Admin - Supporters",
    },

    data() {
        return {
            donators: [],
            filteredDonator: [],
            is_loading: false,
        };
    },

    created() {
        this.onPopulateData();
    },

    methods: {
        onPopulateData() {
            this.is_loading = true;
            this.$admin_queries("donators", {
                action_type: "display_all",
            })
                .then((res) => {
                    this.is_loading = false;
                    this.filteredDonator = res.data.data.donators;
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
        donators() {
            this.$nextTick(() => {
                this.datatable = this.onDatatable("#donators_table", false);
            });
        },

        filteredDonator: function (value) {
            $("#donators_table").DataTable().destroy();
            this.donators = this.filteredDonator;
        },
    },
};
</script>
