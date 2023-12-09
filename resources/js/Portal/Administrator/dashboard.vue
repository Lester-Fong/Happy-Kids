<template>
  <div>
    <h1 class="fw-bold">Dashboard</h1>
    <div class="row">
      <div class="col-md-12 card-group">
        <div class="card">
          <div class="card-header">
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
</template>


<script>
export default {
  data() {
    return {
      blogs: [],
      filteredBlogs: [],
      is_loading: false,
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