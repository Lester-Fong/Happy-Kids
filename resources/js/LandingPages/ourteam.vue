<template>
  <div>
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

    <section class="team-page pt-120 pb-120">
      <div class="block-title text-center">
        <h4 class="text-success ms-3"><img class="me-3" src="/public/front/assets/images/shapes/heart-2-1.png" width="15" alt="Heart Icon" /> {{ pages?.description?.title }}</h4>
        <h3 class="text-center w-50 mx-auto">
          {{ pages?.description?.sub_title }}
        </h3>
      </div>
      <div class="container">
        <div class="team-3-col">
          <div class="team-card text-center content-bg-1" v-for="(a, i) in team" :key="i">
            <div class="team-card__image">
              <img :src="`/public/uploads/team/${a.original_team_id}/${a.image}`" :alt="a.name + 'profile'" />
            </div>
            <div class="team-card__social">
              <a href="javascript:void(0)" aria-label="twitter"><i class="fab fa-twitter"></i></a>
              <a href="javascript:void(0)" aria-label="facebook"><i class="fab fa-facebook-square"></i></a>
              <a href="javascript:void(0)" aria-label="linkedin"><i class="fab fa-linkedin"></i></a>
              <a href="javascript:void(0)" aria-label="instagram"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="team-card__content">
              <h3>{{ a.name }}</h3>
              <p>{{ a.position }}</p>
            </div>
          </div>
          <!-- <div class="team-card text-center content-bg-2">
            <div class="team-card__image">
              <img src="/public/front/assets/images/team/team-1-2.jpg" alt="" />
            </div>
            <div class="team-card__social">
              <a href="#" aria-label="twitter"><i class="fab fa-twitter"></i></a>
              <a href="#" aria-label="facebook"><i class="fab fa-facebook-square"></i></a>
              <a href="#" aria-label="pinterest"><i class="fab fa-pinterest-p"></i></a>
              <a href="#" aria-label="instagram"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="team-card__content">
              <h3>Zachary Pope</h3>
              <p>Student</p>
            </div>
          </div>
          <div class="team-card text-center content-bg-3">
            <div class="team-card__image">
              <img src="/public/front/assets/images/team/team-1-3.jpg" alt="" />
            </div>
            <div class="team-card__social">
              <a href="#" aria-label="twitter"><i class="fab fa-twitter"></i></a>
              <a href="#" aria-label="facebook"><i class="fab fa-facebook-square"></i></a>
              <a href="#" aria-label="pinterest"><i class="fab fa-pinterest-p"></i></a>
              <a href="#" aria-label="instagram"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="team-card__content">
              <h3>Cole Erickson</h3>
              <p>Student</p>
            </div>
          </div>
          <div class="team-card text-center content-bg-4">
            <div class="team-card__image">
              <img src="/public/front/assets/images/team/team-1-4.jpg" alt="" />
            </div>
            <div class="team-card__social">
              <a href="#" aria-label="twitter"><i class="fab fa-twitter"></i></a>
              <a href="#" aria-label="facebook"><i class="fab fa-facebook-square"></i></a>
              <a href="#" aria-label="pinterest"><i class="fab fa-pinterest-p"></i></a>
              <a href="#" aria-label="instagram"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="team-card__content">
              <h3>Violet Figueroa</h3>
              <p>Student</p>
            </div>
          </div>
          <div class="team-card text-center content-bg-5">
            <div class="team-card__image">
              <img src="/public/front/assets/images/team/team-1-5.jpg" alt="" />
            </div>
            <div class="team-card__social">
              <a href="#" aria-label="twitter"><i class="fab fa-twitter"></i></a>
              <a href="#" aria-label="facebook"><i class="fab fa-facebook-square"></i></a>
              <a href="#" aria-label="pinterest"><i class="fab fa-pinterest-p"></i></a>
              <a href="#" aria-label="instagram"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="team-card__content">
              <h3>Eleanor Russell</h3>
              <p>Student</p>
            </div>
          </div>
          <div class="team-card text-center content-bg-6">
            <div class="team-card__image">
              <img src="/public/front/assets/images/team/team-1-6.jpg" alt="" />
            </div>
            <div class="team-card__social">
              <a href="#" aria-label="twitter"><i class="fab fa-twitter"></i></a>
              <a href="#" aria-label="facebook"><i class="fab fa-facebook-square"></i></a>
              <a href="#" aria-label="pinterest"><i class="fab fa-pinterest-p"></i></a>
              <a href="#" aria-label="instagram"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="team-card__content">
              <h3>Scott Tate</h3>
              <p>Student</p>
            </div>
          </div> -->
        </div>
      </div>
    </section>
    <!-- /.team-page pt-120 -->
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
        action_type: "display_team_page",
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