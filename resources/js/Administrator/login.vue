<template>
  <div>
    <form class="container my-4" @submit.prevent="onSubmitForm">
      <div class="row">
        <div class="col-12">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" v-model="admin_email" />
        </div>
        <div class="col-12">
          <label class="form-label">Password</label>
          <input type="password" v-model="admin_password" class="form-control" />
        </div>

        <button class="btn btn-primary">Login</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      admin_email: "",
      admin_password: "",
    };
  },
  methods: {
    onSubmitForm() {
      this.$admin_queries("admin_outside_action", {
        admin: {
          email: this.admin_email,
          password: this.admin_password,
          action_type: "login",
        },
      }).then((res) => {
        console.log(res);
      });
    },
  },
};
</script>