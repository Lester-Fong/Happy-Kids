<template>
  <div class="auth-container d-flex">
    <div class="container mx-auto align-self-center">
      <div class="row">
        <div class="col-6 d-lg-flex d-none h-100 my-auto top-0 start-0 text-center justify-content-center flex-column">
          <div class="auth-cover-bg-image"></div>
          <div class="auth-overlay"></div>

          <div class="auth-cover">
            <div class="position-relative">
              <img src="/public/src/assets/img/auth-cover.svg" alt="auth-img" />
              <h2 class="mt-5 text-white font-weight-bolder px-2">
                Happy Kids Content Management <br />
                Web Application
              </h2>
              <p class="text-white px-2">It is easy to setup with great customer experience. Start your 7-day free trial</p>
            </div>
          </div>
        </div>

        <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center ms-lg-auto me-lg-0 mx-auto">
          <router-view />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "",
    };
  },
  methods: {
    submitForm() {
      // Handle form submission here
    },
  },
};
</script>
