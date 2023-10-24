<template>
  <div>
    <form @submit.prevent="onResetPassword" class="form">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 mb-3">
              <h2>Password Reset</h2>
              <p>Enter your email to recover your ID</p>
            </div>
            <div class="col-md-12">
              <div class="mb-4">
                <label class="form-label">New Password</label>
                <input type="email" class="form-control" v-model="new_password" />
                <p class="text-warning">{{ new_password_error_message }}</p>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <input type="email" class="form-control" v-model="confirm_password" />
                <p class="text-warning">{{ confirm_password_error_message }}</p>
              </div>
            </div>

            <div class="col-12">
              <div class="mb-4">
                <button type="submit" class="btn btn-secondary w-100">RECOVER</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>


<script>
import VueSweetalert2 from "vue-sweetalert2";

export default {
  data() {
    return {
      new_password: "",
      confirm_password: "",
      security_code: this.$route.params.security,

      //errors
      confirm_password_error_message: "",
      new_password_error_message: "",
    };
  },
  created() {
    this.verifySecurityCode();
  },
  methods: {
    verifySecurityCode() {
      if (this.security_code == undefined || this.security_code == "") {
        this.$router.replace({ name: "Login" });
      } else {
        this.$admin_queries("admin_outside_action", {
          admin: {
            email: this.admin_email,
            security: this.security_code,
            action_type: "verify_security_code",
          },
        }).then((res) => {
          let response = res.data.data.administrator;
          if (response.error) {
            this.$router.replace({ name: "login" });
          }
        });
      }
    },
    onRequiredFields() {
      let is_error = false;

      if (this.new_password == "") {
        this.new_password_error_message = "Please enter your new password";
        is_error = true;
      }

      if (this.confirm_password == "") {
        this.confirm_password_error_message = "Please enter your confirm password";
        is_error = true;
      }

      if (this.new_password != this.confirm_password) {
        this.new_password_error_message = "Password does not match";
        this.confirm_password_error_message = "Password does not match";
        is_error = true;
      }

      return is_error;
    },

    onResetPassword() {
      if (this.onRequiredFields()) {
        return;
      }

      this.$admin_queries("admin_outside_action", {
        admin: {
          email: sessionStorage.getItem("email"),
          password: this.new_password,
          confirm_password: this.confirm_password,
          security: this.security_code,
          action_type: "reset_password",
        },
      }).then((res) => {
        let response = res.data.data.administrator;

        if (!response.error) {
          Swal.fire({
            icon: "success",
            title: "Success",
            text: response.message,
          }).then(() => {
            this.$router.replace({ name: "login" });
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
          }).then(() => {
            this.$router.replace({ name: "login" });
          });
        }
      });
    },
  },
};
</script>