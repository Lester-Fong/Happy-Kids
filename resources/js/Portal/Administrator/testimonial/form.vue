<template>
  <div>
    <div v-if="is_loading" class="loader-gif"></div>
    <div class="modal fade show" tabindex="-1" id="testimonial_modal_add" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-light">
          <!-- HEADER -->
          <div class="modal-header">
            <h6 class="text-center">Testimonial</h6>
          </div>
          <form @submit.prevent="onSubmit">
            <!-- BODY -->
            <div class="modal-body">
              <div class="row">
                <div class="col-12 mb-2">
                  <label for="name1" class="small-font">Name</label>
                  <span class="text-warning">*</span>
                  <input v-model="name" type="text" class="form-control form-control-sm" id="name1" />
                  <span class="text-warning mb-0">{{ name_error }}</span>
                </div>
                <div class="col-12 mb-2">
                  <label for="name2" class="small-font">Position</label>
                  <span class="text-warning">*</span>
                  <input v-model="position" type="text" class="form-control form-control-sm" id="name2" />
                  <span class="text-warning mb-0">{{ position_error }}</span>
                </div>
                <div class="col-12 mb-2">
                  <label for="name3" class="small-font">Description</label>
                  <span class="text-warning">*</span>
                  <textarea v-model="description" type="text" class="form-control form-control-sm" id="name3"></textarea>
                  <span class="text-warning mb-0">{{ description_error }}</span>
                </div>
              </div>
              <div class="col-12 my-2">
                <label for="name2" class="small-font">Image</label>
                <span class="text-warning">*</span>
                <div class="input-group mb-3">
                  <div class="custom-file">
                    <input class="form-control file-upload-input" @change="onFileChanged($event)" type="file" id="feedingfile" />
                  </div>
                </div>
                <img class="mb-2" :src="show_file" alt="" v-if="is_show_file" width="100" />
              </div>
            </div>

            <div class="modal-footer border-0 pt-0">
              <div class="d-flex align-items-center">
                <a @click="onHideModal" href="javaScript:void(0)" class="me-2">Cancel</a>

                <button type="submit" class="btn button--primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["testimonial_record", "is_edit"],
  data() {
    return {
      is_loading: false,
      name: "",
      position: "",
      name_error: "",
      position_error: "",
      description: "",
      description_error: "",
      file: null,
      show_file: "",
      is_show_file: false,
      testimonial_id: "",
    };
  },
  methods: {
    onHideModal() {
      $("#testimonial_modal_add").modal("hide");
      this.onClearFieldsAndErrors();
    },
    onCheckRequiredFields() {
      let error = false;

      if (this.name == "") {
        this.name_error = "Name is required";
        error = true;
      } else {
        this.name_error = "";
      }

      if (this.position == "") {
        this.position_error = "Position is required";
        error = true;
      } else {
        this.position_error = "";
      }

      if (this.description == "") {
        this.description_error = "Description is required";
        error = true;
      } else {
        this.description_error = "";
      }

      return error;
    },
    onClearFieldsAndErrors() {
      this.name = "";
      this.position = "";
      this.description = "";
      this.file = null;
      this.show_file = "";
      this.is_show_file = false;
      this.testimonial_id = "";

      this.name_error = "";
      this.position_error = "";
      this.description_error = "";
    },
    onSubmit() {
      if (this.onCheckRequiredFields()) return;

      this.$admin_queries("save_testimonial", {
        testimonial: {
          name: this.name,
          position: this.position,
          action_type: this.is_edit ? "update" : "add",
          description: this.description,
          testimonial_id: this.testimonial_id,
        },
        file: this.file,
      }).then((res) => {
        const response = res.data.data.testimonial;

        if (response.error) {
          Swal.fire("Error", response.message, "error");
        } else {
          Swal.fire("Success", response.message, "success");
          this.onClearFieldsAndErrors();
          this.$emit("success");
        }
      });
    },
    onFileChanged(e) {
      this.file = e.target.files[0];
      this.show_file = this.onDisplayUploadedImage(e);
      this.is_show_file = true;
    },
    onDisplayUploadedImage(e) {
      const file = e.target.files[0];
      return URL.createObjectURL(file);
    },
  },
  watch: {
    is_edit(value_is_true) {
      if (value_is_true) {
        this.name = this.testimonial_record.name;
        this.position = this.testimonial_record.position;
        this.description = this.testimonial_record.description;
        this.testimonial_id = this.testimonial_record.testimonial_id;
        this.show_file = `/public/uploads/testimonials/${this.testimonial_record.original_testimonial_id}/${this.testimonial_record.image}`;
        this.is_show_file = true;
      }
    },
  },
};
</script>