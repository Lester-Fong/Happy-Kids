<template>
  <div>
    <template v-if="is_portal">
      <h1 class="bg-info">Header Here!!!</h1>
      <router-view></router-view>
      <h1 class="bg-secondary">Footer Here</h1>
    </template>
    <template v-else>
      <router-view></router-view>
    </template>
  </div>
</template>

<script>
export default {
  data() {
    return {
      is_portal: false,
      is_admin: false,
      adminLoggedIn: false,
      admin_rec: {},
      is_calling_api: false,
    };
  },
  created() {
    this.$appEvents.$on("admin-login", () => {
      this.is_admin = true;
      this.adminLoggedIn = true;
      this.is_portal = true;
    });

    this.$appEvents.$on("admin-logout", () => {
      this.is_admin = false;
      this.adminLoggedIn = false;
      this.is_portal = false;
    });

    if (sessionStorage.getItem("admin_api_token")) {
      //ADMIN
      if (sessionStorage.getItem("login_type") === "admin") {
        this.adminLoggedIn = true;
        this.is_admin = true;
        this.is_portal = true;

        this.onPopulateAdminData();
      }
    }
  },

  methods: {
    onPopulateAdminData() {
      this.$admin_queries("get_admin", {
        action_type: "get_current_admin",
      })
        .then((res) => {
          let response = res.data.data.administrator;
          console.log(res);
          if (!response.error) {
            this.admin_rec = response;
            this.is_portal = true;
          } else {
            Swal.fire("Error!", response.message, "error");
          }
        })
        .catch(() => {
          this.is_calling_api = false;
        });
    },
  },
};
</script>