<template>
  <div>
    <div v-if="is_loading" class="loader-gif"></div>

    <div class="modal fade show" tabindex="-1" id="admin_profile_modal" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content bg-light">
          <!-- HEADER -->
          <div class="modal-header">
            <h6 class="text-center">Administrator</h6>
          </div>
          <form @submit.prevent="onSubmit">
            <!-- BODY -->
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-6 mb-2">
                  <label for="name" class="small-font">Firstname</label>
                  <span class="text-warning">*</span>

                  <input v-model="firstname" type="text" class="form-control form-control-sm" id="firstname" />
                  <span class="text-warning mb-0">{{ firstname_error }}</span>
                </div>
                <div class="col-sm-6 mb-2">
                  <label for="name" class="small-font">Lastname</label>
                  <span class="text-warning">*</span>

                  <input v-model="lastname" type="text" class="form-control form-control-sm" id="lastname" />
                  <span class="text-warning mb-0">{{ lastname_error }}</span>
                </div>
                <div class="col-sm-6 mb-2">
                  <label for="name" class="small-font">Email</label>
                  <span class="text-warning">*</span>

                  <input v-model="email" type="email" class="form-control form-control-sm" id="email" />
                  <span class="text-warning mb-0">{{ email_error }}</span>
                </div>
                <div class="col-sm-6 mb-2">
                  <label for="name" class="small-font">Password</label>
                  <span class="text-warning">*</span>

                  <input v-model="password" type="password" class="form-control form-control-sm" id="password" />
                  <span class="text-warning mb-0">{{ password_error }}</span>
                </div>
                <div class="col-sm-6 mb-2">
                  <label for="name" class="small-font">Mobile Number</label>

                  <input v-model="mobile" type="text" class="form-control form-control-sm" id="mobile" />
                </div>
                <!-- Upload button -->
                <div class="col-sm-6 mb-2">
                  <label class="custom-file-label whiz-form-file-label" for="profile_image_reseller">{{ image_name ? image_name : "Choose Image" }}</label>

                  <div class="d-flex align-items-center">
                    <input type="file" class="form-control form-control-sm" id="profile_image_reseller" ref="profile" @change="onHandleUpload($event)" />
                  </div>
                  <img class="d-block text-center my-1" :src="display_profile_image" alt="" v-if="is_profile_image" width="100" />
                </div>
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
  props: ["admin_rec"],

  data() {
    return {
      is_loading: false,
      firstname: "",
      firstname_error: "",
      lastname: "",
      lastname_error: "",
      email: "",
      email_error: "",
      password: "",
      password_error: "",
      mobile: "",
      admin_id: "",
      display_profile_image: "",
      image_name: "",
      is_profile_image: false,
      profile_image: "",
    };
  },

  methods: {
    onHideModal() {
      this.$emit("onHideModal");
      this.onClearErrors();
    },
    onHandleUpload(e) {
      this.profile_image = this.$refs.profile.files[0];
      this.image_name = this.profile_image.name;
      this.display_profile_image = URL.createObjectURL(this.profile_image);
      this.is_profile_image = true;
    },
    onSubmit() {
      this.onClearErrors();
      this.is_loading = true;
      this.$admin_queries("save_admin", {
        admin: {
          firstname: this.firstname,
          lastname: this.lastname,
          email: this.email,
          password: this.password,
          mobile: this.mobile,
          administrator_id: this.admin_id,
          action_type: "update_record",
        },
        file: this.profile_image,
      })
        .then((res) => {
          this.is_loading = false;

          if (res.data.errors) {
            let errors = Object.values(res.data.errors[0].extensions.validation).flat();
            let errors_keys = Object.keys(res.data.errors[0].extensions.validation).flat();

            this.firstname_error = errors_keys.some((q) => q == "admin.firstname") ? errors[errors_keys.indexOf("admin.firstname")] : "";
            this.lastname_error = errors_keys.some((q) => q == "admin.lastname") ? errors[errors_keys.indexOf("admin.lastname")] : "";
            this.email_error = errors_keys.some((q) => q == "admin.email") ? errors[errors_keys.indexOf("admin.email")] : "";
            this.password_error = errors_keys.some((q) => q == "admin.password") ? errors[errors_keys.indexOf("admin.password")] : "";
          } else {
            let response = res.data.data.administrator;

            if (!response.error) {
              this.onClearFields();
              this.onClearErrors();
              Swal.fire("Success!", response.message, "success").then(() => {
                // this.$emit("success");
                this.$emit("success", response.admin);
              });
            } else {
              Swal.fire("Error!", "Record saving failed.", "error");
            }
          }
        })
        .catch(() => {
          this.is_loading = false;
          Swal.fire("Error!", this.global_error_message, "error");
        });
    },

    onClearErrors() {
      this.firstname_error = "";
      this.lastname_error = "";
      this.email_error = "";
      this.password_error = "";
    },

    onClearFields() {
      this.firstname = "";
      this.lastname = "";
      this.email = "";
      this.password = "";
      this.mobile = "";
      this.image_name = "";
    },
  },

  watch: {
    admin_rec(val) {
      if (val) {
        this.firstname = val.firstname;
        this.lastname = val.lastname;
        this.email = val.email;
        this.mobile = val.mobile;
        this.admin_id = val.administrator_id;
        this.display_profile_image = `/public/uploads/admin/${val.administrator_regular_id}/thumb/${val.image}`;
        this.is_profile_image = true;
      }
    },
  },
};
</script>
