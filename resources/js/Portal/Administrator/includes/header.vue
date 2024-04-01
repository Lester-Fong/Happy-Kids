<template>
  <div>
    <header class="header navbar navbar-expand-sm expand-header">
      <a href="javascript:void(0);" class="sidebarCollapse" @click="onToggleSidebar">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
      </a>

      <ul class="navbar-item flex-row ms-auto">
        <li class="nav-item dropdown user-profile-dropdown order-lg-0 order-1">
          <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="avatar-container">
              <div class="avatar avatar-sm avatar-indicators avatar-online bg-primary text-white rounded-circle d-flex justify-content-center align-items-center">
                <img v-if="admin_data.image !== null" :src="profile_pic" alt="Profile Image" />
                <span v-else class="fs-6 fw-bold">{{ firstname && lastname ? onGetInitials(firstname, lastname) : "" }}</span>
              </div>
            </div>
          </a>

          <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
            <div class="user-profile-section">
              <div class="media mx-auto">
                <img :src="profile_pic" class="img-fluid me-2" alt="avatar" />
                <div class="media-body">
                  <h5>{{ firstname && lastname ? formatFullname(firstname, lastname) : "" }}</h5>
                  <p>Administrator</p>
                </div>
              </div>
            </div>
            <div @click="onShowProfileModal" class="dropdown-item">
              <a href="javascript:void(0);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span>Profile</span>
              </a>
            </div>
            <!-- <div class="dropdown-item">
                            <a href="javascript:void(0);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox">
                                    <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                                    <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
                                </svg>
                                <span>Inbox</span>
                            </a>
                        </div> -->
            <!-- <div class="dropdown-item">
                            <a href="javascript:void(0);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <span>Lock Screen</span>
                            </a>
                        </div> -->
            <div @click="onLogout()" class="dropdown-item">
              <a href="javascript:void(0);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                  <polyline points="16 17 21 12 16 7"></polyline>
                  <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>Log Out</span>
              </a>
            </div>
          </div>
        </li>
      </ul>
    </header>
    <admin-profile v-on:onHideModal="onCancelForm" v-on:success="onSuccessForm" :admin_rec="admin" />
  </div>
</template>

<script>
import AdminProfile from "./profile.vue";

export default {
  props: ["admin_rec"],

  components: { AdminProfile },

  data() {
    return {
      administrator_id: "",
      firstname: "",
      lastname: "",
      email: "",
      profile_pic: "",
      admin: {},
      mobile: "",
      admin_data: {},
    };
  },

  methods: {
    onToggleSidebar() {
      // Get the element you want to check for the .sbar-open class
      var mainContainer = document.querySelector(".main-container");

      // Check if the .sbar-open class is active
      var isSbarOpenActive = mainContainer.classList.contains("sbar-open");

      if (isSbarOpenActive) {
        // .sbar-open is active
        mainContainer.classList.remove("sbar-open");
      } else {
        // add .sbar-open
        mainContainer.classList.add("sbar-open");
      }
    },

    onLogout() {
      sessionStorage.clear();
      this.$router.go({ name: "AdminLogin" });
    },

    onAssignData(val) {
      this.administrator_id = val.administrator_id;
      this.firstname = val.firstname;
      this.lastname = val.lastname;
      this.email = val.email;
      this.profile_pic = `/public/uploads/admin/${val.administrator_regular_id}/thumb/${val.image}`;
      this.mobile = val.mobile;
      this.admin_data = val;
    },

    onShowProfileModal() {
      this.admin = this.admin_data;
      $("#admin_profile_modal").modal("show");
      $("#admin_profile_modal").appendTo("body");
    },

    onCancelForm() {
      $("#admin_profile_modal").modal("hide");
    },

    onSuccessForm(val) {
      this.onAssignData(val);
      $("#admin_profile_modal").modal("hide");
    },
  },

  created() {
    this.onAssignData(this.admin_rec);
  },
};
</script>

<style scoped>
.open {
  width: 255px;
  left: 0;
}
</style>
