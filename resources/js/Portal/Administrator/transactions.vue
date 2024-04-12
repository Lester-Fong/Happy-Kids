<template>
    <div>
        <div class="loader-gif" v-if="is_loading"></div>
        <h1>Transactions</h1>

        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <table id="transaction_table" class="table table-striped dt-table-hover" style="width: 100%">
                        <thead class="mb-4">
                            <tr>
                                <th>Response ID</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="a in transactions" :key="a.id">
                                <td>
                                    {{ a.response_id }}
                                </td>
                                <td>
                                    <span class="badge" :class="badgeClass(a.status)">{{ badgeText(a.status) }}</span>
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
        title: "Admin - Transactions",
    },

    data() {
        return {
            transactions: [],
            filteredTransaction: [],
            is_loading: false,
        };
    },

    created() {
        this.onPopulateData();
    },

    methods: {
        onPopulateData() {
            this.is_loading = true;
            this.$admin_queries("transactions", {
                action_type: "display_all",
            })
                .then((res) => {
                    this.is_loading = false;
                    this.filteredTransaction = res.data.data.transactions;
                })
                .catch(() => {
                    this.is_loading = false;
                    Swal.fire("Error!", this.global_error_message, "error");
                });
        },

        badgeClass(status) {
            if (status == "COMPLETED") {
                return "badge-success";
            } else {
                return "badge-danger";
            }
        },

        badgeText(status) {
            if (status == "COMPLETED") {
                return "Completed";
            } else {
                return "Failed";
            }
        },
    },

    watch: {
        transactions() {
            this.$nextTick(() => {
                this.datatable = this.onDatatable("#transaction_table", true);
            });
        },

        filteredTransaction: function (value) {
            $("#transaction_table").DataTable().destroy();
            this.transactions = this.filteredTransaction;
        },
    },
};
</script>
