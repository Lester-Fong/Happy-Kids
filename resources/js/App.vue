<template>
  <div>
    <template v-if="is_portal">
      <!--  START HEADER NAVBAR  -->
      <div class="header-container">
        <header-admin></header-admin>
      </div>
      <!--  END HEADER NAVBAR  -->

      <!--  BEGIN MAIN CONTAINER  -->
      <div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">
          <sidebar-admin></sidebar-admin>
        </div>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
          <div class="layout-px-spacing">
            <div class="middle-content container-xxl p-0">
              <router-view></router-view>
              <!-- CONTENT AREA -->
            </div>
          </div>
        </div>
        <!--  END CONTENT AREA  -->
      </div>
      <!-- END MAIN CONTAINER -->
      <!-- <router-view></router-view>
      <h1 class="bg-secondary">Footer Here</h1> -->
    </template>
    <template v-else>
      <router-view></router-view>
    </template>
  </div>
</template>

<script>
import HeaderAdmin from "./Portal/Administrator/includes/header.vue";
import SidebarAdmin from "./Portal/Administrator/includes/sidebar.vue";
export default {
  components: {
    HeaderAdmin,
    SidebarAdmin,
  },
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