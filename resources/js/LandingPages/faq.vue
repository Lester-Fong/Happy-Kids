<template>
  <div>
    <div class="loader-gif" v-if="is_loading"></div>
    <section class="page-header">
      <div class="page-header__bg" :style="`background-image: url('/public/uploads/pages/${pages.pages_id}/large/${pages.image}')`"></div>
      <!-- /.page-header__bg -->
      <div class="container">
        <h2>Frequently Asked Questions</h2>
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

    <section class="faq-one py-5">
      <div class="faq_one_container w-75 mx-auto">
        <div class="row">
          <div class="col-lg-12">
            <div class="faq-one__content px-0">
              <div class="block-title text-center">
                <h4 class="text-success ms-3"><img class="me-3" src="/public/front/assets/images/shapes/heart-2-1.png" width="15" alt="Heart Icon" /> {{ pages?.description?.title }}</h4>
                <h3 class="text-center w-50 mx-auto">
                  {{ pages?.description?.sub_title }}
                </h3>
              </div>
              <ul id="accordion" class="wow fadeInUp list-unstyled animated" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-name: fadeInUp">
                <li v-for="(a, index) in faq" :key="index">
                  <h2 class="para-title">
                    <span class="collapsed" role="button" data-toggle="collapse" :data-target="`#collapse${index}`" aria-expanded="false" :aria-controls="`collapse${index}`">
                      {{ a.question }}
                    </span>
                  </h2>
                  <div :id="`collapse${index}`" :class="{ show: index == 0 }" class="collapse" role="button" :aria-labelledby="`collapse${index}`" data-parent="#accordion">
                    <p>{{ a.answer }}</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
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
      faq: [],
    };
  },

  created() {
    this.onPopulateData();
  },

  methods: {
    onPopulateData() {
      this.is_loading = true;

      this.$front_queries("front_page_data", {
        action_type: "display_faq_page",
      })
        .then((res) => {
          this.is_loading = false;
          let response = res.data.data.front;
          this.pages = response.pages;
          this.faq = response.faq;
        })
        .catch((err) => {
          console.error("error:" + err);
        });
    },
  },
};
</script>