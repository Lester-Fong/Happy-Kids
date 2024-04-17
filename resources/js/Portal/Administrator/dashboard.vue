<template>
  <div>
    <div v-if="is_loading" class="loader-gif"></div>
    <div v-else>
      <blockquote class="lead text-info fw-bold">Hello, {{ admin_name }} 👋</blockquote>
      <div class="row">
        <div class="col-md-12 card-group px-0">
          <div class="card">
            <div class="card-header hk_bg-primary">
              <h5 class="card-title m-0">Supporters of the Month</h5>
            </div>
            <div class="card-body">
              <table id="donators_table" class="table table-light" style="width: 100%">
                <thead class="mb-4">
                  <tr>
                    <th class="fw-bold text-center">Name</th>
                    <th class="fw-bold text-center">Country</th>
                    <th class="fw-bold text-center">Email Address</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(a, i) in donators" :key="i">
                    <td class="fw-bold text-center">
                      {{ formatFullname(a.firstname, a.lastname) }}
                    </td>
                    <td class="fw-bold text-center">
                      {{ a.country }}
                    </td>
                    <td class="fw-bold text-center">
                      <span>{{ a.email }}</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-12 card my-3 px-0">
          <div class="card-header hk_bg-primary">
            <h5 class="card-title m-0 px-0">Pages Engagement</h5>
          </div>
          <div id="chart" class="card-body">
            <VueApexCharts type="bar" height="300" :options="chartOptionsPage" :series="seriesPage"></VueApexCharts>
          </div>
        </div>
        <div class="col-md-6 col-12 card my-3 px-0">
          <div class="card-header hk_bg-primary">
            <h5 class="card-title m-0 px-0">Recent Donations</h5>
          </div>
          <div id="chartDonate" class="card-body">
            <VueApexCharts type="bar" height="300" :options="chartOptionsDonate" :series="seriesDonate"></VueApexCharts>
          </div>
        </div>
        <div class="col-md-12 card-group px-0 mb-4">
          <div class="card">
            <div class="card-header hk_bg-primary">
              <h5 class="card-title m-0">Most Viewed Blogs</h5>
            </div>
            <div class="card-body">
              <table id="blogs_table" class="table table-light" style="width: 100%">
                <thead class="mb-4">
                  <tr>
                    <th class="fw-bold text-center">Blog Title</th>
                    <th class="fw-bold text-center">Views</th>
                    <th class="fw-bold text-center">Date Published</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="blog in blogs.slice(0, 5)" :key="blog.id">
                    <td class="fw-bold text-center">
                      {{ blog.title }}
                    </td>
                    <td class="fw-bold text-center">
                      <span>{{ blog.views }} views</span>
                    </td>
                    <td class="fw-bold text-center">
                      {{ blog.date | formatTransDate }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import VueApexCharts from "vue-apexcharts";
export default {
  components: {
    VueApexCharts,
  },
  data() {
    return {
      admin_name: "",
      blogs: [],
      filteredBlogs: [],
      is_loading: false,
      datatable: null,
      page_data: [],
      recent_transactions: [],
      filteredDonators: [],
      donators: [],
      chartOptionsPage: {
        chart: {
          type: "bar",
          toolbar: {
            show: false,
          },
        },
        plotOptions: {
          bar: {
            horizontal: true,
          },
        },
        dataLabels: {
          enabled: false,
        },
        xaxis: {
          categories: [],
        },
        colors: ["#800f2f"],
      },
      seriesPage: [
        {
          data: [],
        },
      ],
      chartOptionsDonate: {
        chart: {
          type: "bar",
          toolbar: {
            show: false,
          },
        },
        plotOptions: {
          bar: {
            horizontal: false,
          },
        },
        dataLabels: {
          enabled: false,
        },
        xaxis: {
          categories: [],
        },
        colors: ["#f49508"],
      },
      seriesDonate: [
        {
          data: [],
        },
      ],
    };
  },

  async created() {
    await this.onPopulateData();
  },

  methods: {
    async onPopulateData() {
      this.is_loading = true;
      await this.$admin_queries("admin_dashboard", {
        action_type: "get_admin_dashboard_data",
      })
        .then((res) => {
          this.is_loading = false;
          const response = res.data.data.administrator[0];
          this.admin_name = this.formatFullname(response.firstname, response.lastname);
          this.page_data = response.pages;
          this.filteredBlogs = response.blogs;
          this.recent_transactions = response.transactions;
          this.filteredDonators = response.donators;

          const pageViews = this.page_data.map((data) => data.views);
          const pageTitle = this.page_data.map((data) => data.title);
          this.chartOptionsPage.xaxis.categories = pageTitle;
          this.seriesPage[0].data = pageViews;

          const donateAmount = this.recent_transactions.map((data) => data.amount);
          const donateDate = this.recent_transactions.map((data) => this.onFormatDateTime(data.created_at));
          this.chartOptionsDonate.xaxis.categories = donateDate;
          this.seriesDonate[0].data = donateAmount;
        })
        .catch((err) => {
          this.is_loading = false;
          console.log(err);
          Swal.fire("Error!", this.global_error_message, "error");
        });
    },
  },

  watch: {
    blogs() {
      this.$nextTick(() => {
        this.datatable = this.onDatatable("#blogs_table", false);
        // hide pagination
        $(".dt--top-section").remove();
        $(".dt--bottom-section").remove();
      });
    },
    filteredBlogs: function (value) {
      $("#blogs_table").DataTable().destroy();
      this.blogs = this.filteredBlogs;
    },

    donators() {
      this.$nextTick(() => {
        this.datatable = this.onDatatable("#donators_table", false);
        // hide pagination
        $(".dt--top-section").remove();
        $(".dt--bottom-section").remove();
      });
    },
    filteredDonators: function (value) {
      $("#donators_table").DataTable().destroy();
      this.donators = this.filteredDonators;
    },
  },
};
</script>