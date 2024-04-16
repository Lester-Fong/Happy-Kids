<template>
  <div>
    <div v-if="is_loading" class="loader-gif"></div>
    <div v-else>
      <h1 class="fw-bold">Dashboard</h1>
      <div class="row">
        <div class="col-md-12 card my-3 px-0">
          <div class="card-header hk_bg-primary">
            <h5 class="card-title m-0 px-0">Pages Engagement</h5>
          </div>
          <div id="chart" class="card-body">
            <VueApexCharts type="bar" height="300" :options="chartOptions" :series="series"></VueApexCharts>
          </div>
        </div>
        <div class="col-md-12 card-group px-0 mb-4">
          <div class="card">
            <div class="card-header hk_bg-primary">
              <h5 class="card-title m-0">Most Viewed Blogs</h5>
            </div>
            <div class="card-body">
              <table id="blogs_table" class="table table-striped dt-table-hover" style="width: 100%">
                <thead class="mb-4">
                  <tr>
                    <th class="fw-bold text-center">Blog TItle</th>
                    <th class="fw-bold text-center">Date Published</th>
                    <th class="fw-bold text-center">Views</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="blog in blogs.slice(0, 5)" :key="blog.id">
                    <td class="fw-bold text-center">
                      {{ blog.title }}
                    </td>
                    <td class="fw-bold text-center">
                      {{ blog.date | formatTransDate }}
                    </td>
                    <td class="fw-bold text-center">
                      <span>{{ blog.views }} views</span>
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
      blogs: [],
      filteredBlogs: [],
      is_loading: false,
      datatable: null,
      chartOptions: {
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
          categories: ["Home", "Our Mission", "Our Team", "FAQs", "Feeding", "Scholarship", "Events", "Stories", "Contact Us"],
        },
        colors: ["#800f2f"],
      },
      series: [
        {
          data: [30, 40, 45, 50, 49, 60, 70, 91, 125],
        },
      ],
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
          console.log(this.filteredBlogs);
        })
        .catch(() => {
          this.is_loading = false;
          Swal.fire("Error!", this.global_error_message, "error");
        });
    },
  },

  watch: {
    blogs() {
      this.$nextTick(() => {
        this.datatable = this.onDatatable("#blogs_table", false);
        // hide pagination
        $(".dt--bottom-section").remove().css("display", "none");
      });
    },

    filteredBlogs: function (value) {
      $("#blogs_table").DataTable().destroy();
      this.blogs = this.filteredBlogs;
    },
  },
};
</script>