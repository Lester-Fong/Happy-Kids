<template>
  <div>
    <div class="loader" v-if="is_calling_api"></div>

    <h1>Create Page</h1>
    <div class="card card-bordered card-preview container px-4 py-2">
      <div class="card-inner">
        <div class="preview-block">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="exampleFormControlInput1">Title</label>
                <input type="text" class="form-control" v-model="title" id="exampleFormControlInput1" />
                <div class="text-danger">{{ title_error }}</div>
              </div>
            </div>
          </div>

          <ul class="nav nav-tabs my-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1">Header</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" data-bs-toggle="tab" href="#tabItem2">Meta Information</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tabItem1">
              <div class="row">
                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput2">Header</label>
                    <input type="text" class="form-control" v-model="header" id="exampleFormControlInput2" />
                    <div class="text-danger">{{ header_error }}</div>
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput3">Sub Header</label>
                    <input type="text" class="form-control" v-model="sub_header" id="exampleFormControlInput3" />
                    <div class="text-danger">{{ sub_header_error }}</div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="col-form-label" for="default-06">Background</label>
                    <div class="input-group mb-3">
                      <div class="custom-file">
                        <input class="form-control file-upload-input" @click="onFileChanged" type="file" id="formFile" />
                      </div>
                    </div>
                    <img class="mt-2" :src="background_image" alt="" v-if="is_background" width="100" />
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tabItem2">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="col-form-label" for="default-textarea">Title</label>
                    <textarea class="form-control no-resize servicio-textfield" id="default-textarea" v-model="meta_title"></textarea>
                    <div class="text-danger">{{ meta_title_error }}</div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="col-form-label" for="default-textarea">Description</label>
                    <textarea class="form-control no-resize servicio-textfield" id="default-textarea" v-model="meta_description"></textarea>
                    <div class="text-danger">{{ meta_description_error }}</div>
                  </div>
                </div>

                <div class="col-sm-6 mt-2">
                  <label class="col-form-label" for="default-textarea">Keywords</label>
                  <div class="form-group">
                    <textarea class="form-control no-resize servicio-textfield" id="default-textarea" v-model="meta_keywords"></textarea>
                    <div class="text-danger">{{ meta_keywords_error }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="button" name="button" class="btn btn-primary ms-auto mx-1 fw-bold" @click="onSave">Save</button>
        <button type="button" name="button" class="btn btn-secondary mx-1 fw-bold" @click="onCancel">Cancel</button>
      </div>
    </div>
  </div>
</template>
  
<script>
export default {
  metaInfo: {
    title: "Admin - Pages - New",
  },
  data() {
    return {
      title: "",
      slug: "",
      header: "",
      sub_header: "",
      meta_title: "",
      meta_keywords: "",
      meta_description: "",

      title_error: "",
      slug_error: "",
      header_error: "",
      sub_header_error: "",
      meta_title_error: "",
      meta_keywords_error: "",
      meta_description_error: "",
      is_error: false,

      selectedFile: "",
      is_background: false,
      background_image: "",

      is_calling_api: false,
    };
  },
  methods: {
    onCancel() {
      this.$router.replace({ name: "AdminPages" });
    },
    onSave() {
      this.onClearErrors();
      this.onCheckRequiredFields();

      if (this.is_error == false) {
        this.is_calling_api = true;

        this.$admin_queries("save_pages", {
          file: this.selectedFile,
          page: {
            title: this.title,
            header: this.header,
            sub_header: this.sub_header,
            meta_title: this.meta_title,
            meta_keywords: this.meta_keywords,
            meta_description: this.meta_description,
            action_type: "new_record",
          },
        })
          .then((res) => {
            console.log(res);
            this.is_calling_api = false;

            if (res.data.errors) {
              let errors = Object.values(res.data.errors[0].extensions.validation).flat();
              let errors_keys = Object.keys(res.data.errors[0].extensions.validation).flat();

              this.title_error = errors_keys.some((q) => q == "page.title") ? errors[errors_keys.indexOf("page.title")] : "";
              this.header_error = errors_keys.some((q) => q == "page.header") ? errors[errors_keys.indexOf("page.header")] : "";

              this.meta_title_error = errors_keys.some((q) => q == "page.meta_title") ? errors[errors_keys.indexOf("page.meta_title")] : "";
              this.meta_keywords_error = errors_keys.some((q) => q == "page.meta_keywords") ? errors[errors_keys.indexOf("page.meta_keywords")] : "";
              this.meta_description_error = errors_keys.some((q) => q == "page.meta_description") ? errors[errors_keys.indexOf("page.meta_description")] : "";
            } else {
              let response = res.data.data.pages;

              if (response.error == false) {
                Swal.fire("Success!", response.message, "success").then(() => {
                  this.$router.push("/admin/pages");
                });
              } else {
                Swal.fire("Error!", response.message, "error");
              }
            }
          })
          .catch(() => {
            this.is_calling_api = false;
            Swal.fire("Error!", this.global_error_message, "error");
          });
      }
    },
    onCheckRequiredFields() {
      let error_message = "Please enter page ";

      if (this.title == "") {
        this.title_error = error_message + "title";
        this.is_error = true;
      }

      // if(this.slug == "") {
      //   this.slug_error = error_message + "slug";
      //   this.is_error = true;
      // }

      if (this.header == "") {
        this.header_error = error_message + "header";
        this.is_error = true;
      }

      if (this.sub_header == "") {
        this.sub_header_error = error_message + "sub header";
        this.is_error = true;
      }

      if (this.meta_title == "") {
        this.meta_title_error = error_message + "meta title";
        this.is_error = true;
      }

      if (this.meta_keywords == "") {
        this.meta_keywords_error = error_message + "meta keywords";
        this.is_error = true;
      }

      if (this.meta_description == "") {
        this.meta_description_error = error_message + "meta description";
        this.is_error = true;
      }
    },
    onClearErrors() {
      this.is_error = false;
      this.title_error = "";
      this.slug_error = "";
      this.header_error = "";
      this.meta_title_error = "";
      this.meta_keywords_error = "";
      this.meta_description_error = "";
    },
    onFileChanged() {
      this.onDisplayUploadedImage(event);
      this.selectedFile = event.target.files[0];
    },
    onDisplayUploadedImage(e) {
      const file = e.target.files[0];
      this.background_image = URL.createObjectURL(file);
      this.is_background = true;
    },
  },
};
</script>