<template>
  <div>
    <form @submit.prevent="onVerifyEmail" class="form">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 mb-3">
              <h2>Forgot Password?</h2>
              <p>Enter your email to recover your ID</p>
            </div>
            <div class="col-md-12">
              <div class="mb-4">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" v-model="admin_email" />
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
export default {
  name: "ForgotPassword",
  data() {
    return {
      admin_email: "",
    };
  },

  methods: {
    onVerifyEmail() {
      this.$admin_queries("admin_outside_action", {
        admin: {
          email: this.admin_email,
          action_type: "verify_email",
        },
      }).then((res) => {
        let response = res.data.data.administrator;

        if (!response.error) {
          Swal.fire("Success", response.message, "success")
            .then(() => {
              sessionStorage.setItem("email", this.admin_email);
              this.$router.push({ name: "ForgotPasswordOTP" });
            })
            .catch((err) => {
              console.error(err);
            });
        } else {
          Swal.fire("Error", response.message, "error");
        }
      });
    },
  },
};
</script>