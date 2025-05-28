<template>
  <div class="page-wrapper">
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

    <section class="about-one pt-120 pb-40">
      <div class="container">
        <div class="row">
          <div class="about-one__award">
            <img src="/public/front/assets/images/shapes/about-bag-1-1.png" alt="" />
          </div>
          <!-- /.about-one__award -->
          <div class="col-lg-6">
            <img :src="`/public/uploads/pages/${pages.pages_id}/large/${pages.extras_image_1}`" alt="extras image 1" class="about_extras_img img-fluid" />
          </div>
          <!-- /.col-lg-6 -->
          <div class="col-lg-6">
            <img :src="`/public/uploads/pages/${pages.pages_id}/large/${pages.extras_image_2}`" alt="extras image 2" class="about_extras_img img-fluid" />
          </div>
          <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
      <div class="container">
        <div class="team-about__top mt-60">
          <div class="row">
            <div class="col-md-12 col-lg-4">
              <div class="block-title">
                <p><img src="/public/front/assets/images/shapes/heart-2-1.png" width="15" alt="" />{{ pages.description?.mission_intro_title }}</p>
                <h3>{{ pages.description?.mission_intro_section_title }}</h3>
              </div>
              <!-- /.block-title -->
            </div>
            <!-- /.col-md-12 col-lg-6 -->
            <div class="col-md-12 col-lg-8">
              <p class="team-about__top-text">{{ pages.description?.mission_intro_description }}</p>
            </div>
            <!-- /.col-md-12 col-lg-6 -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.team-about__top -->
      </div>
      <!-- /.container -->
    </section>
    <!-- /.about-one -->

    <section class="about-counter pt-120">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="block-title">
              <p><img src="/public/front/assets/images/shapes/heart-2-1.png" width="15" alt="" />{{ pages.description?.checklist_title }}</p>
              <h3>{{ pages.description?.checklist_subtitle }}</h3>
            </div>
            <!-- /.block-title -->
            <p class="about-counter__text pe-5">
              {{ pages.description?.checklist_description }}
            </p>
            <ul class="list-unstyled ul-list-one">
              <li>{{ pages.description?.checklist_checklist1 }}</li>
              <li>{{ pages.description?.checklist_checklist2 }}</li>
              <li>{{ pages.description?.checklist_checklist3 }}</li>
            </ul>
            <!-- /.list-unstyled list-style-one -->
            <div class="about-counter__count">
              <p class="text-center">{{ pages.description?.checklist_short_text }}</p>
            </div>
            <!-- /.about-counter__count -->
          </div>
          <!-- /.col-lg-6 -->
          <div class="col-lg-6">
            <div class="about-counter__image clearfix">
              <div class="about-counter__image-content">
                <img src="/public/front/assets/images/shapes/about-count-heart-1-1.png" alt="" />
                <p>We’re here to support you every step of the way.</p>
              </div>
              <!-- /.about-counter__image-content -->
              <img :src="`/public/uploads/pages/checklist_/our-mission/${pages.description?.checklist_image_webp}`" alt="float image left" class="float-left checklist-img" />
            </div>
            <!-- /.about-counter__image -->
          </div>
          <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.containerr -->
    </section>
    <!-- /.about-counter -->

    <section class="team-about pb-120 pt-120" :style="`background-image: url('/public/uploads/pages/volunteer_/our-mission/${pages.description?.volunteer_image_webp}')`">
      <div class="container">
        <div class="team-about__top">
          <div class="row align-items-center">
            <div class="col-md-12 col-lg-7">
              <div class="block-title">
                <p><img src="/public/front/assets/images/shapes/heart-2-1.png" width="15" alt="" />{{ pages.description?.volunteers_title }}</p>
                <h3 class="w-75 pe-5">
                  {{ pages.description?.volunteers_subtitle }}
                </h3>
              </div>
              <!-- /.block-title -->
            </div>
            <!-- /.col-md-12 col-lg-6 -->
            <div class="col-md-12 col-lg-5">
              <p class="team-about__top-text">{{ pages.description?.volunteers_description }}</p>
            </div>
            <!-- /.col-md-12 col-lg-6 -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.team-about__top -->
        <div class="team-4-col">
          <div class="team-card text-center content-bg-1" v-for="(a, i) in team" :key="i">
            <div class="team-card__image">
              <img :src="`/public/uploads/team/${a.original_team_id}/${a.image}`" :alt="a.name + 'profile'" />
            </div>
            <div class="team-card__social">
              <!-- <a href="javascript:void(0)" aria-label="facebook"><i class="fab fa-facebook-square"></i></a> -->
              <!-- <a href="javascript:void(0)" aria-label="linkedin"><i class="fab fa-linkedin"></i></a> -->
              <!-- <a href="javascript:void(0)" aria-label="instagram"><i class="fab fa-instagram"></i></a> -->
            </div>
            <div class="team-card__content">
              <h3>{{ a.name }}</h3>
              <p>{{ a.position }}</p>
            </div>
          </div>
        </div>
        <!-- /.team-4-col -->
      </div>
      <!-- /.container -->
    </section>
    <!-- /.team-about -->
    <section class="video-card">
      <div class="video-card__bg" :style="`background-image: url('/public/uploads/pages/video_/our-mission/${pages.description?.video_image_webp}')`"></div>
      <!-- /.video-card__bg -->
      <div class="container text-center pt-120 pb-120">
        <p><img src="/public/front/assets/images/shapes/heart-2-1.png" width="15" alt="" />{{ pages.description?.video_title }}</p>
        <h3 class="w-75 mx-auto text-center">
          {{ pages.description?.video_subtitle }}
        </h3>
        <div class="video-card__btn-block">
          <a href="javascript:void(0)" class="thm-btn dynamic-radius">Start Donating</a>
          <!-- /.thm-btn dynamic-radius -->
          <a :href="pages.description?.video_link" target="_blank" class="video-popup video-card__btn"><i class="fa fa-play"></i></a
          ><!-- /.video-card__btn -->
        </div>
        <!-- /.video-card__btn-block -->
      </div>
      <!-- /.container -->
    </section>
    <!-- /.video-card -->
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
        action_type: "display_about_page",
      })
        .then((res) => {
          this.is_loading = false;
          let response = res.data.data.front;
          this.pages = response.pages;
          this.team = response.team;
        })
        .catch((err) => {
          console.error("error:" + err);
        });
    },
  },
};
</script>