<template>
  <div>
    <nav id="sidebar">
      <div class="navbar-nav d-block d-lg-none">
        <div class="nav-item sidebar-toggle py-4">
          <div class="btn-toggle sidebarCollapse" @click="onToggleSidebar">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left">
              <polyline points="11 17 6 12 11 7"></polyline>
              <polyline points="18 17 13 12 18 7"></polyline>
            </svg>
          </div>
        </div>
      </div>

      <ul class="list-unstyled menu-categories" id="accordionExample">
        <li class="menu">
          <router-link :to="{ name: 'AdminDashboard' }" :class="activeMeta.isDashboard ? 'hk_active' : ''" aria-expanded="false" class="dropdown-toggle">
            <div class="">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-columns"><path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7m0-18H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7m0-18v18"></path></svg>
              <span>Dashboard</span>
            </div>
          </router-link>
        </li>

        <!---------- Pages ---------->
        <li class="menu">
          <router-link :to="{ name: 'AdminPages' }" :class="activeMeta.isPages ? 'hk_active' : ''" aria-expanded="false" class="dropdown-toggle">
            <div class="d-flex align-items-center">
              <i class="bi bi-sidebar bi-book h5 mb-0 me-2 pe-1"></i>
              <span>Pages</span>
            </div>
          </router-link>
        </li>
        <!---------- End of Pages ---------->

        <!---------- Posts ---------->
        <li class="menu">
          <a href="#home" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <div class="">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-hash">
                <line x1="4" y1="9" x2="20" y2="9"></line>
                <line x1="4" y1="15" x2="20" y2="15"></line>
                <line x1="10" y1="3" x2="8" y2="21"></line>
                <line x1="16" y1="3" x2="14" y2="21"></line>
              </svg>
              <span>Post</span>
            </div>
            <div>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </div>
          </a>
          <ul class="collapse submenu list-unstyled" id="home" data-bs-parent="#accordionExample">
            <li>
              <router-link :to="{ name: 'AdminEvents' }" :class="activeMeta.isEvents ? 'hk_active' : ''"> Events </router-link>
            </li>
            <li>
              <router-link :to="{ name: 'AdminBlogs' }" :class="activeMeta.isBlogs ? 'hk_active' : ''"> Blogs/Stories </router-link>
            </li>
            <li>
              <router-link :to="{ name: 'AdminBlogCategory' }" :class="activeMeta.isBlogsCategory ? 'hk_active' : ''"> Blog Category </router-link>
            </li>
            <li>
              <router-link :to="{ name: 'AdminFAQ' }" :class="activeMeta.isFAQ ? 'hk_active' : ''"> FAQs </router-link>
            </li>
            <li>
              <router-link :to="{ name: 'AdminTestimonials' }" :class="activeMeta.isTestimonial ? 'hk_active' : ''"> Testimonials </router-link>
            </li>
            <li>
              <router-link :to="{ name: 'AdminOurTeam' }" :class="activeMeta.isOurTeam ? 'hk_active' : ''"> Team </router-link>
            </li>
          </ul>
        </li>
        <!---------- End of Post ---------->

        <!---------- Administrator ---------->
        <li class="menu">
          <router-link :to="{ name: 'AdminAdministrator' }" :class="activeMeta.isAdmin ? 'hk_active' : ''" aria-expanded="false" class="dropdown-toggle">
            <div class="d-flex align-items-center">
              <i class="bi bi-sidebar bi-person-fill h5 mb-0 me-2 pe-1"></i>
              <span>Administrator</span>
            </div>
          </router-link>
        </li>
        <!---------- End of Administrator ---------->

        <!---------- SMS TRANSACTION ---------->
        <!-- <li class="menu">
          <router-link :to="{ name: 'AdminSMS' }" :class="activeMeta.isSMS ? 'hk_active' : ''" aria-expanded="false" class="dropdown-toggle">
            <div class="d-flex align-items-center">
              <i class="bi bi-sidebar bi-chat-square-text h5 mb-0 me-2 pe-1"></i>
              <span>SMS</span>
            </div>
          </router-link>
        </li> -->
        <!---------- End of SMS TRANSACTION ---------->

        <!---------- Donation ---------->
        <!-- <li class="menu">
          <router-link :to="{ name: 'AdminDonation' }" :class="activeMeta.isDonations ? 'hk_active' : ''" aria-expanded="false" class="dropdown-toggle">
            <div class="d-flex align-items-center">
              <i class="bi bi-sidebar bi-bag-heart h5 mb-0 me-2 pe-1"></i>
              <span>Donation</span>
            </div>
          </router-link>
        </li> -->
        <!---------- End of Donation ---------->

        <!---------- Supporters ---------->
        <li class="menu">
          <router-link :to="{ name: 'AdminDonators' }" :class="activeMeta.isDonator ? 'hk_active' : ''" aria-expanded="false" class="dropdown-toggle">
            <div class="d-flex align-items-center">
              <!-- <i class="bi bi-sidebar bi-person-fill h5 mb-0 me-2 pe-1"></i> -->
              <i class="bi bi-sidebar bi-person-vcard h5 mb-0 me-2 pe-1"></i>
              <span>Supporters</span>
            </div>
          </router-link>
        </li>

        <!---------- Transactions ---------->
        <li class="menu">
          <router-link :to="{ name: 'AdminTransactions' }" :class="activeMeta.isTransaction ? 'hk_active' : ''" aria-expanded="false" class="dropdown-toggle">
            <div class="d-flex align-items-center">
              <i class="bi bi-sidebar bi-clock-history h5 mb-0 me-2 pe-1"></i>
              <span>Transactions</span>
            </div>
          </router-link>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  data() {
    return {
      active: false,
    };
  },

  computed: {
    activeMeta() {
      return this.$route.meta;
    },
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
  },
};
</script>
