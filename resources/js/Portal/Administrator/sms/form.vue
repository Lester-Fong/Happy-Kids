<template>
  <div>
    <div v-if="is_loading" class="loader-gif"></div>
    <div class="modal fade show" tabindex="-1" id="sms_modal_add" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-light">
          <!-- HEADER -->
          <div class="modal-header">
            <h6 class="text-center">Team</h6>
          </div>
          <form @submit.prevent="onSubmit">
            <!-- BODY -->
            <div class="modal-body">
              <div class="row">
                <div class="col-12 mb-2">
                  <label for="name1" class="small-font">Recipient Number/s</label>
                  <span class="text-warning">*</span>
                  <div class="form-control-wrap">
                    <!-- Use an input element for Tagify -->
                    <input id="tagify-input" @input="onValidateContactNumber" placeholder="Type and press Enter to add tags" class="form-control" />
                    <div class="text-danger">{{ contact_numbers_error }}</div>
                  </div>
                </div>

                <div class="col-12 mb-2">
                  <label for="name2" class="small-font">Message</label>
                  <span class="text-warning">*</span>
                  <textarea v-model="message" type="text" class="form-control form-control-sm" id="name2"></textarea>
                  <span class="text-warning mb-0">{{ message_error }}</span>
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
// import Tagify from "@yaireo/tagify/dist/tagify.min.js";
import "@yaireo/tagify/dist/tagify.css"; // Import Tagify styles
import Tagify from "@yaireo/tagify";
export default {
  data() {
    return {
      is_loading: false,
      message: "",
      contact_numbers: [],
      sms_id: "",
      tagifyInput: null,

      //error
      contact_numbers_error: "",
      message_error: "",
    };
  },
  mounted() {
    this.initializeTagify();
  },
  methods: {
    onValidateContactNumber(contactNumber) {
      let is_error = false;
      // validate if contact number is 11 digits and starts with 09
      const contactNumberValue = contactNumber;
      const regex = new RegExp("^(09)\\d{9}$");
      if (!regex.test(contactNumberValue)) {
        this.contact_numbers_error = "Invalid contact number";
        is_error = true;
      } else {
        this.contact_numbers_error = "";
        is_error = false;
      }

      return is_error;
    },

    initializeTagify() {
      this.tagifyInput = document.getElementById("tagify-input");
      var tagify = new Tagify(this.tagifyInput);

      tagify.on("add", (e) => {
        // validate contact number
        if (this.onValidateContactNumber(e.detail.data.value)) {
          // remove tag in the field if invalid
          tagify.removeTags(e.detail.tag);
        } else {
          this.contact_numbers.push(e.detail.data.value);
        }
      });
    },

    onHideModal() {
      $("#sms_modal_add").modal("hide");
      this.onClearFieldsAndErrors();
    },

    onCheckRequiredFields() {
      let error = false;

      if (this.contact_numbers.length == 0) {
        this.contact_numbers_error = "Recipient Number is required";
        error = true;
      } else {
        this.contact_numbers_error = "";
      }

      if (this.message == "") {
        this.message_error = "Message is required";
        error = true;
      } else {
        this.message_error = "";
      }

      return error;
    },

    onClearFieldsAndErrors() {
      this.contact_numbers = [];
      this.contact_numbers_error = "";
    },

    onSubmit() {
      if (this.onCheckRequiredFields()) return;
      this.$admin_queries("save_sms", {
        sms: {
          message: this.message,
          contact_numbers: this.contact_numbers,
          action_type: "create_message",
        },
      }).then((res) => {
        console.log(res);
        const response = res.data.data.sms;

        if (response.error) {
          Swal.fire("Error", response.message, "error");
        } else {
          Swal.fire("Success", response.message, "success");
          this.onClearFieldsAndErrors();
          this.$emit("success");
        }
      });
    },
  },
};
</script>