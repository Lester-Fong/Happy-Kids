<template>
  <div>
    <div class="loader-gif" v-if="is_loading"></div>
    <h1>Pages Page</h1>

    <div class="row layout-top-spacing">
      <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
          <table id="Pages_table" class="table table-striped dt-table-hover" style="width: 100%">
            <thead class="mb-4">
              <tr>
                <th>Page Name</th>
                <th>Slug</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(a, index) in pages" :key="index">
                <td>{{ a.title }}</td>
                <td>{{ a.slug }}</td>
                <td class="text-center dropdown">
                  <a class="dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                      <circle cx="12" cy="12" r="1"></circle>
                      <circle cx="19" cy="12" r="1"></circle>
                      <circle cx="5" cy="12" r="1"></circle>
                    </svg>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                    <router-link :to="{ name: 'AdminPagesEdit', params: { slug: a.slug } }" class="dropdown-item">Edit</router-link>
                    <a class="dropdown-item" href="javascript:void(0);" @click="onDeleteRecord(a.encrypted_pages_id)">Delete</a>
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
  metaInfo: {
        title: "Admin - Pages",
    },
  
  data() {
    return {
      is_loading: false,
      filtered_pages: [],
      data: [
        {
          image: "https://picsum.photos/200",
          name: "Tiger Nixon",
          position: "System Architect",
          office: "Edinburgh",
          age: "61",
          start_date: "2011/04/25",
          salary: "$320,800",
        },
        {
          image: "https://picsum.photos/200",
          name: "Garrett Winters",
          position: "Accountant",
          office: "Tokyo",
          age: "63",
          start_date: "2011/07/25",
          salary: "$170,750",
        },
        {
          image: "https://picsum.photos/200",
          name: "Ashton Cox",
          position: "Junior Technical Author",
          office: "San Francisco",
          age: "66",
          start_date: "2009/01/12",
          salary: "$86,000",
        },
        {
          image: "https://picsum.photos/200",
          name: "Cedric Kelly",
          position: "Senior Javascript Developer",
          office: "Edinburgh",
          age: "22",
          start_date: "2012/03/29",
          salary: "$433,060",
        },
        {
          image: "https://picsum.photos/200",
          name: "Airi Satou",
          position: "Accountant",
          office: "Tokyo",
          age: "33",
          start_date: "2008/11/28",
          salary: "$162,700",
        },
        {
          image: "https://picsum.photos/200",
          name: "Brielle Williamson",
          position: "Integration Specialist",
          office: "New York",
          age: "61",
          start_date: "2012/12/02",
          salary: "$372,000",
        },
        {
          image: "https://picsum.photos/200",
          name: "Herrod Chandler",
          position: "Sales Assistant",
          office: "San Francisco",
          age: "59",
          start_date: "2012/08/06",
          salary: "$137,500",
        },
        {
          image: "https://picsum.photos/200",
          name: "Rhona Davidson",
          position: "Integration Specialist",
          office: "Tokyo",
          age: "55",
          start_date: "2010/10/14",
          salary: "$327,900",
        },
        {
          image: "https://picsum.photos/200",
          name: "Colleen Hurst",
          position: "Javascript Developer",
          office: "San Francisco",
          age: "39",
          start_date: "2009/09/15",
          salary: "$205,500",
        },
        {
          image: "https://picsum.photos/200",
          name: "Sonya Frost",
          position: "Software Engineer",
          office: "Edinburgh",
          age: "23",
          start_date: "2008/12/13",
        },
      ],
      pages: [],
      count: 0,
    };
  },

  created() {
    this.onPopulateData();
  },

  methods: {
    onPopulateData() {
      this.is_loading = true;
      this.$admin_queries("pages", {
        action_type: "display_all_pages",
      }).then((res) => {
        this.filtered_pages = res.data.data.pages;
        this.is_loading = false;
      });
    },
    onCreateRecord() {
      this.$router.push({ name: "AdminPagesCreate" });
    },
    onDeleteRecord(encrypted_pages_id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        confirmButtonColor: "#3b3f5c",
        cancelButtonColor: "#d33",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$admin_queries("save_pages", {
            page: {
              action_type: "delete_record",
              pages_id: encrypted_pages_id,
            },
          }).then((res) => {
            if (!res.data.data.error) {
              Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success",
                confirmButtonColor: "#3b3f5c",
              }).then((result) => {
                if (result.isConfirmed) {
                  this.onPopulateData();
                }
              });
            }
          });
        }
      });
    },
  },

  watch: {
    pages() {
      this.$nextTick(() => {
        this.datatable = this.onDatatable("#Pages_table", true);
      });
    },

    filtered_pages: function (value) {
      $("#Pages_table").DataTable().destroy();
      this.pages = this.filtered_pages;
    },
  },
};
</script>