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

    <section class="event-page pt-120 pb-120">
      <div class="container">
        <div class="block-title text-center">
          <h4 class="text-success ms-3"><img class="me-3" src="/public/front/assets/images/shapes/heart-2-1.png" width="15" alt="Heart Icon" /> {{ pages?.description?.title }}</h4>
          <h3 class="text-center w-50 mx-auto">
            {{ pages?.description?.sub_title }}
          </h3>
        </div>
        <div class="event-grid">
          <div class="event-card">
            <div class="event-card-inner">
              <div class="event-card-image">
                <div class="event-card-image-inner">
                  <img src="/public/front/assets/images/events/event-1-1.jpg" alt="" />
                  <span>20 May</span>
                </div>
                <!-- /.event-card-image-inner -->
              </div>
              <!-- /.event-card-image -->
              <div class="event-card-content">
                <h3><a href="event-details.html">Funding for Food</a></h3>
                <ul class="event-card-list">
                  <li>
                    <i class="azino-icon-clock"></i>
                    <strong>Time:</strong> 9:00am 02:00pm
                  </li>
                  <li>
                    <i class="azino-icon-pin1"></i>
                    <strong>Location:</strong> New York
                  </li>
                </ul>
                <!-- /.event-card-list -->
              </div>
              <!-- /.event-card-content -->
            </div>
            <!-- /.event-card-inner -->
          </div>
          <!-- /.event-card -->
          <div class="event-card">
            <div class="event-card-inner">
              <div class="event-card-image">
                <div class="event-card-image-inner">
                  <img src="/public/front/assets/images/events/event-1-2.jpg" alt="" />
                  <span>20 May</span>
                </div>
                <!-- /.event-card-image-inner -->
              </div>
              <!-- /.event-card-image -->
              <div class="event-card-content">
                <h3><a href="event-details.html">Help for needy people</a></h3>
                <ul class="event-card-list">
                  <li>
                    <i class="azino-icon-clock"></i>
                    <strong>Time:</strong> 9:00am 02:00pm
                  </li>
                  <li>
                    <i class="azino-icon-pin1"></i>
                    <strong>Location:</strong> New York
                  </li>
                </ul>
                <!-- /.event-card-list -->
              </div>
              <!-- /.event-card-content -->
            </div>
            <!-- /.event-card-inner -->
          </div>
          <!-- /.event-card -->
          <div class="event-card">
            <div class="event-card-inner">
              <div class="event-card-image">
                <div class="event-card-image-inner">
                  <img src="/public/front/assets/images/events/event-1-3.jpg" alt="" />
                  <span>20 May</span>
                </div>
                <!-- /.event-card-image-inner -->
              </div>
              <!-- /.event-card-image -->
              <div class="event-card-content">
                <h3><a href="event-details.html">Education for children</a></h3>
                <ul class="event-card-list">
                  <li>
                    <i class="azino-icon-clock"></i>
                    <strong>Time:</strong> 9:00am 02:00pm
                  </li>
                  <li>
                    <i class="azino-icon-pin1"></i>
                    <strong>Location:</strong> New York
                  </li>
                </ul>
                <!-- /.event-card-list -->
              </div>
              <!-- /.event-card-content -->
            </div>
            <!-- /.event-card-inner -->
          </div>
          <!-- /.event-card -->
          <div class="event-card">
            <div class="event-card-inner">
              <div class="event-card-image">
                <div class="event-card-image-inner">
                  <img src="/public/front/assets/images/events/event-1-4.jpg" alt="" />
                  <span>20 May</span>
                </div>
                <!-- /.event-card-image-inner -->
              </div>
              <!-- /.event-card-image -->
              <div class="event-card-content">
                <h3><a href="event-details.html">Rights of children</a></h3>
                <ul class="event-card-list">
                  <li>
                    <i class="azino-icon-clock"></i>
                    <strong>Time:</strong> 9:00am 02:00pm
                  </li>
                  <li>
                    <i class="azino-icon-pin1"></i>
                    <strong>Location:</strong> New York
                  </li>
                </ul>
                <!-- /.event-card-list -->
              </div>
              <!-- /.event-card-content -->
            </div>
            <!-- /.event-card-inner -->
          </div>
          <!-- /.event-card -->
          <div class="event-card">
            <div class="event-card-inner">
              <div class="event-card-image">
                <div class="event-card-image-inner">
                  <img src="/public/front/assets/images/events/event-1-5.jpg" alt="" />
                  <span>20 May</span>
                </div>
                <!-- /.event-card-image-inner -->
              </div>
              <!-- /.event-card-image -->
              <div class="event-card-content">
                <h3><a href="event-details.html">Donation Day for people</a></h3>
                <ul class="event-card-list">
                  <li>
                    <i class="azino-icon-clock"></i>
                    <strong>Time:</strong> 9:00am 02:00pm
                  </li>
                  <li>
                    <i class="azino-icon-pin1"></i>
                    <strong>Location:</strong> New York
                  </li>
                </ul>
                <!-- /.event-card-list -->
              </div>
              <!-- /.event-card-content -->
            </div>
            <!-- /.event-card-inner -->
          </div>
          <!-- /.event-card -->
          <div class="event-card">
            <div class="event-card-inner">
              <div class="event-card-image">
                <div class="event-card-image-inner">
                  <img src="/public/front/assets/images/events/event-1-6.jpg" alt="" />
                  <span>20 May</span>
                </div>
                <!-- /.event-card-image-inner -->
              </div>
              <!-- /.event-card-image -->
              <div class="event-card-content">
                <h3><a href="event-details.html">Donate for street child</a></h3>
                <ul class="event-card-list">
                  <li>
                    <i class="azino-icon-clock"></i>
                    <strong>Time:</strong> 9:00am 02:00pm
                  </li>
                  <li>
                    <i class="azino-icon-pin1"></i>
                    <strong>Location:</strong> New York
                  </li>
                </ul>
                <!-- /.event-card-list -->
              </div>
              <!-- /.event-card-content -->
            </div>
            <!-- /.event-card-inner -->
          </div>
          <!-- /.event-card -->
        </div>
        <!-- /.event-grid -->
        <ul class="list-unstyled post-pagination d-flex justify-content-center align-items-center">
          <li>
            <a href="#"><i class="far fa-angle-left"></i></a>
          </li>
          <li><a href="#">01</a></li>
          <li><a href="#">02</a></li>
          <li><a href="#">03</a></li>
          <li>
            <a href="#"><i class="far fa-angle-right"></i></a>
          </li>
        </ul>
        <!-- /.post-pagination -->
      </div>
      <!-- /.container -->
    </section>
    <!-- /.event-page -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      is_loading: false,
      pages: [],
    };
  },

  created() {
    this.onPopulateData();
  },

  methods: {
    onPopulateData() {
      this.is_loading = true;

      this.$front_queries("front_page_data", {
        action_type: "display_events_page",
      })
        .then((res) => {
          this.is_loading = false;
          let response = res.data.data.front;
          this.pages = response.pages;
          console.log("response", this.pages);
        })
        .catch((err) => {
          console.error("error:" + err);
        });
    },
  },
};
</script>