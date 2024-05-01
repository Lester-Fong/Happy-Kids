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

  computed: {
    createContent: function () {
      let content = null;
      var application_data = this.filteredTransaction;

      var csv_header = "ID, Amount, Status, Supporter Name, Date, Response ID";
      let csv = "";

      for (let index = 0; index < application_data.length; index++) {
        const app = application_data[index];

        // id, product, vendor, enabled, name, description, group_name
        var app_id = app.original_donate_id ? app.original_donate_id : "";
        var amount = app.amount ? app.amount : 0;
        var status = app.status ? app.status : "";
        var supporter_name = app.donator && app.donator.firstname && app.donator.lastname ? `${app.donator.firstname} ${app.donator.lastname}` : "";
        var date = app.date_created ? app.date_created : "";
        var response_id = app.response_id ? app.response_id : "";

        let data = [
          {
            ID: app_id,
            Amount: amount,
            Status: status,
            "Supporter Name": supporter_name,
            Date: date,
            "Response ID": response_id,
          },
        ];
        var fields = Object.keys(data[0]);

        var csv_data = data
          .map(function (row) {
            return fields
              .map(function (fieldName) {
                return JSON.stringify(row[fieldName]);
              })
              .join(",");
          })
          .join("\r\n");
        csv += csv_data + "\n";
      }
      content = csv_header + "\n" + csv;

      //sort content's product names to ascending
      content = content
        .split("\n")
        .sort(function (a, b) {
          return a.split(",")[1] > b.split(",")[1];
        })
        .join("\n");

      return content;
    },
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

    onExport() {
      let content = this.createContent;
      const blob = new Blob([content], {
        type: `application/csv`,
      });
      const link = document.createElement("a");
      link.href = window.URL.createObjectURL(blob);
      link.download = `transactions.csv`;
      link.click();
    },
  },

  watch: {
    transactions() {
      this.$nextTick(() => {
        this.datatable = this.onDatatable("#transaction_table", false);
        $(".dataTables_filter").append('<button class="btn button--primary ms-4 fw-bold btn-sm onExport">Export</button>');
        $(".onExport").on("click", this.onExport);
      });
    },

    filteredTransaction: function (value) {
      $("#transaction_table").DataTable().destroy();
      this.transactions = this.filteredTransaction;
    },
  },
};
</script>
