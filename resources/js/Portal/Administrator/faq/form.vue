<template>
  <div>
    <div v-if="is_loading" class="loader-gif"></div>
    <div class="modal fade show" tabindex="-1" id="faq_modal_add" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-light">
          <!-- HEADER -->
          <div class="modal-header">
            <h6 class="text-center">Frequently Asked Question</h6>
          </div>
          <form @submit.prevent="onSubmit">
            <!-- BODY -->
            <div class="modal-body">
              <div class="row">
                <div class="col-12 mb-2">
                  <label for="name" class="small-font">Question</label>
                  <span class="text-warning">*</span>
                  <input v-model="question" type="text" class="form-control form-control-sm" id="name" />
                  <span class="text-warning mb-0">{{ question_error }}</span>
                </div>
                <div class="col-12 my-2">
                  <label for="name" class="small-font">Answer</label>
                  <span class="text-warning">*</span>
                  <input v-model="answer" type="text" class="form-control form-control-sm" id="name" />
                  <span class="text-warning mb-0">{{ answer_error }}</span>
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
  props: ["faq_record", "is_edit"],
  data() {
    return {
      is_loading: false,
      question: "",
      answer: "",
      question_error: "",
      answer_error: "",
    };
  },
  methods: {
    onHideModal() {
      $("#faq_modal_add").modal("hide");
    },
    onCheckRequiredFields() {
      let error = false;

      if (this.question == "") {
        this.question_error = "Question is required";
        error = true;
      } else {
        this.question_error = "";
      }

      if (this.answer == "") {
        this.answer_error = "Answer is required";
        error = true;
      } else {
        this.answer_error = "";
      }

      return error;
    },
    onClearFieldsAndErrors() {
      this.question = "";
      this.answer = "";

      this.question_error = "";
      this.answer_error = "";
    },
    onSubmit() {
      if (this.onCheckRequiredFields()) return;

      this.$admin_queries("save_faq", {
        faq: {
          faq_question: this.question,
          faq_answer: this.answer,
          action_type: this.is_edit ? "update" : "add",
          faq_id: this.faq_id,
        },
      }).then((res) => {
        const response = res.data.data.faq;

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
  watch: {
    is_edit(value_is_true) {
      if (value_is_true) {
        this.question = this.faq_record.question;
        this.answer = this.faq_record.answer;
        this.faq_id = this.faq_record.faq_id;
      }
    },
  },
};
</script>