<template>
  <div>
    <!-- Start page-header -->
    <div class="loader-gif" v-if="is_loading"></div>
    <section class="page-header">
      <div class="page-header__bg" :style="`background-image: url('/public/uploads/pages/${pages.pages_id}/large/${pages.image}')`"></div>
      <!-- /.page-header__bg -->
      <div class="container">
        <h2>{{ pages?.title }}</h2>
        <ul class="thm-breadcrumb list-unstyled dynamic-radius">
          <li><router-link :to="{ name: 'HomePage' }">Home</router-link></li>
          <li>-</li>
          <li>
            <span>{{ pages?.title }}</span>
          </li>
        </ul>
        <!-- /.thm-breadcrumb list-unstyled -->
      </div>
      <!-- /.container -->
    </section>
    <!-- /.page-header -->

    <section class="event-details pt-120">
      <div class="container">
        <div class="block-title text-center">
          <h4 class="text-success ms-3"><img class="me-3" src="/public/front/assets/images/shapes/heart-2-1.png" width="15" alt="Heart Icon" /> {{ pages?.description?.title }}</h4>
          <h3 class="text-center w-50 mx-auto text-info">
            {{ pages?.description?.sub_title }}
          </h3>
        </div>
        <div class="row">
          <div class="col-md-12 col-lg-6">
            <h3>{{ pages?.description?.program_intro_title }}</h3>
            <p>
              {{ pages?.description?.program_intro_description }}
            </p>
          </div>
          <!-- /.col-md-12 -->
          <div class="col-md-12 col-lg-6">
            <img :src="`/public/uploads/pages/program_/scholarship-program/${pages.description?.program_image_webp}`" :alt="pages?.description?.program_intro_title" class="img-fluid program_img" />
          </div>
          <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
    </section>

    <!-- About scholars -->
    <section class="pt-120 pb-120 bg-light">
      <div class="w-70 mx-auto">
        <h1 class="text-center mb-5">{{ pages?.description?.program_about_title }}</h1>
        <p>
          {{ pages?.description?.program_about_description }}
        </p>
      </div>
    </section>

    <!-- Meet The Scholars -->
    <section class="team-page pt-120 pb-120 bg-success">
      <h1 class="text-center mb-5 text-white">Meet the Trimex Colleges FAC Scholars</h1>
      <div class="container">
        <div class="team-3-col">
          <div class="team-card text-center content-bg-1" v-for="(a, i) in team" :key="i">
            <div class="team-card__image">
              <img :src="`/public/uploads/team/${a.original_team_id}/${a.image}`" :alt="a.name + 'profile'" />
            </div>
            <div class="team-card__social">
              <a href="javascript:void(0)" aria-label="facebook"><i class="fab fa-facebook-square"></i></a>
              <a href="javascript:void(0)" aria-label="linkedin"><i class="fab fa-linkedin"></i></a>
              <a href="javascript:void(0)" aria-label="instagram"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="team-card__content">
              <h3>{{ a.name }}</h3>
              <p>{{ a.position }}</p>
            </div>
          </div>
        </div>
        <!-- /.team-3-col -->
      </div>
      <!-- /.container -->
    </section>

    <!-- Overview -->
    <section class="pt-120 pb-120 w-70 mx-auto">
      <h1 class="text-center mb-5">{{ pages?.description?.program_overview_title }}</h1>
      <p>
        {{ pages?.description?.program_overview_description }}
      </p>
    </section>
  </div>
</template>


<script>
export default {
  data() {
    return {
      is_loading: false,
      pages: [],
      team: [],
    };
  },

  created() {
    this.onPopulateData();
  },

  methods: {
    onPopulateData() {
      this.is_loading = true;

      this.$front_queries("front_page_data", {
        action_type: "display_scholar_program_page",
      })
        .then((res) => {
          this.is_loading = false;
          let response = res.data.data.front;
          this.pages = response.pages;
          this.team = response.team;
          console.log("response", this.pages);
        })
        .catch((err) => {
          console.error("error:" + err);
        });
    },
  },
};
</script>