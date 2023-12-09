<template>
  <div>
    <header class="header navbar navbar-expand-sm expand-header">
      <a href="javascript:void(0);" class="sidebarCollapse">
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
              <div class="avatar avatar-sm avatar-indicators avatar-online">
                <img alt="avatar" src="/public/images/default-profile-icon.png" class="rounded-circle" />
              </div>
            </div>
          </a>

          <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
            <div class="user-profile-section">
              <div class="media mx-auto">
                <img src="/public/images/default-profile-icon.png" class="img-fluid me-2" alt="avatar" />
                <div class="media-body">
                  <h5>{{ user.firstname + " " + user.lastname }}</h5>
                  <p class="text-danger">Administrator</p>
                </div>
              </div>
            </div>
            <!-- <div class="dropdown-item">
                            <a href="javascript:void(0);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span>Profile</span>
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
  </div>
</template>

<script>
export default {
  props: ["admin_rec"],
  data() {
    return {
      user: {},
    };
  },

  methods: {
    onLogout() {
      sessionStorage.clear();
      this.$router.go({ name: "AdminLogin" });
    },
  },

  watch: {
    admin_rec() {
      this.user = this.admin_rec[0];
    },
  },
};
</script>
