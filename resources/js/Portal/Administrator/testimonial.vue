<template>
  <div>
    <div class="loader-gif" v-if="is_loading"></div>
    <h1>Testimonials Page</h1>

    <div class="row layout-top-spacing">
      <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8">
          <table id="testimonial_table" class="table table-striped dt-table-hover" style="width: 100%">
            <thead class="mb-4">
              <tr>
                <th>Name</th>
                <th>Position</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(a, index) in pages" :key="index">
                <td>{{ a.name }}</td>
                <td>{{ a.position }}</td>
                <td class="text-center dropdown">
                  <a class="dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                      <circle cx="12" cy="12" r="1"></circle>
                      <circle cx="19" cy="12" r="1"></circle>
                      <circle cx="5" cy="12" r="1"></circle>
                    </svg>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                    <a class="dropdown-item" href="javascript:void(0);" @click="onEditRecord(a)">Edit</a>
                    <a class="dropdown-item" href="javascript:void(0);" @click="onDeleteRecord(a.testimonial_id)">Delete</a>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <testimonial-modal v-on:cancel="onCancel" v-on:success="onSuccessForm" :is_edit="is_edit" :testimonial_record="testimonial_record"></testimonial-modal>
  </div>
</template>

<script>
import TestimonialModal from "./testimonial/form.vue";
export default {
  metaInfo: {
        title: "Admin - Testimonials",
    },
  
  components: {
    TestimonialModal,
  },
  data() {
    return {
      is_loading: false,
      filtered_pages: [],
      testimonial_record: {},
      pages: [],
      is_edit: false,
    };
  },

  created() {
    this.onPopulateData();
  },

  methods: {
    onPopulateData() {
      this.is_loading = true;
      this.$admin_queries("testimonial", {
        action_type: "display_all",
      }).then((res) => {
        this.filtered_pages = res.data.data.testimonial;
        this.is_loading = false;
      });
    },
    onCreateRecord() {
      $("#testimonial_modal_add").modal("show");
    },
    onEditRecord(rec) {
      this.is_edit = true;
      this.testimonial_record = rec;
      $("#testimonial_modal_add").modal("show");
    },
    onCancel() {
      this.is_edit = false;
      $("#testimonial_modal_add").modal("hide");
    },
    onSuccessForm() {
      this.is_edit = false;
      $("#testimonial_modal_add").modal("hide");
      this.onPopulateData();
    },
    onDeleteRecord(encrypted_testimonial_id) {
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
          this.$admin_queries("save_testimonial", {
            testimonial: {
              action_type: "delete_record",
              testimonial_id: encrypted_testimonial_id,
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
        this.datatable = this.onDatatable("#testimonial_table", true);
      });
    },

    filtered_pages: function (value) {
      $("#testimonial_table").DataTable().destroy();
      this.pages = this.filtered_pages;
    },
  },
};
</script>