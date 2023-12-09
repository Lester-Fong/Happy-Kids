<template>
  <div>
    <section class="site-footer">
      <div class="main-footer pt-142 pb-80">
        <div class="container">
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="footer-widget mb-40 footer-widget__about">
                <h3 class="text-white">Happy Kids Logo</h3>
                <p>Lorem ipsum dolor sit amet consect etur adi pisicing elit sed.</p>
                <ul class="list-unstyled footer-widget__contact">
                  <li>
                    <a href="#"><i class="azino-icon-telephone"></i>666 888 0000</a>
                  </li>
                  <li>
                    <a href="#"><i class="azino-icon-email"></i>needhelp@azino.com</a>
                  </li>
                  <li>
                    <a href="#"><i class="azino-icon-pin"></i>88 Broklyn Golden Street, USA</a>
                  </li>
                </ul>
                <!-- /.footer-widget__contact -->
              </div>
              <!-- /.footer-widget footer-widget__about -->
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="footer-widget footer-widget__link mb-40">
                <h3 class="footer-widget__title">Explore</h3>
                <ul class="list-unstyled footer-widget__link-list">
                  <li>
                    <router-link :to="{ name: 'HomePage' }">Home</router-link>
                  </li>
                  <li>
                    <router-link :to="{ name: 'AboutPage' }">Our Mission</router-link>
                  </li>
                  <li>
                    <router-link :to="{ name: 'OurTeamPage' }">Our Team</router-link>
                  </li>
                  <li>
                    <router-link :to="{ name: 'FAQPage' }">FAQs</router-link>
                  </li>
                  <li>
                    <router-link :to="{ name: 'FeedingProgramPage' }">Feeding Program</router-link>
                  </li>
                  <li>
                    <router-link :to="{ name: 'ScholarshipProgramPage' }">Scholarship Program</router-link>
                  </li>
                  <li>
                    <router-link :to="{ name: 'EventsPage' }">Events</router-link>
                  </li>
                  <li>
                    <router-link :to="{ name: 'StoriesPage' }">Stories</router-link>
                  </li>
                  <li>
                    <router-link :to="{ name: 'ContactPage' }">Contact Us</router-link>
                  </li>
                </ul>
              </div>
            </div>

            <div class="col-lg-5 col-md-6 col-sm-12">
              <div class="footer-widget mb-40 footer-widget__newsletter">
                <h3 class="footer-widget__title">Newletter</h3>
                <p>Signup now to get daily latest news & updates from us</p>
                <form class="footer-widget__newsletter-form mc-form">
                  <label for="mc-email" class="sr-only">Email Address</label>
                  <input type="email" name="EMAIL" id="mc-email" class="dynamic-radius px-3" placeholder="Email address" />
                  <div class="footer-widget__newsletter-btn-wrap d-flex justify-content-center">
                    <button type="submit" class="btn btn-md btn-secondary text-warning">Subscribe Now</button>
                  </div>
                  <!-- /.footer-widget__newsletter-btn-wrap -->
                  <!-- /.thm-btn -->
                </form>
                <!-- /.footer-widget__newsletter-form -->
                <div class="mc-form__response"></div>
                <!-- /.mc-form__response -->
              </div>
              <!-- /.footer-widget footer-widget__newsletter -->
            </div>
            <!-- /.col-lg-3 col-md-6 col-sm-12 -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container -->
      </div>
      <!-- /.main-footer -->
      <div class="footer-bottom">
        <div class="container">
          <span class="scroll-to-top scroll-to-target" @click="scrollToTop"><i class="fas fa-angle-up"></i></span>
          <p>© Copyright 2021 by Layerdrops.com</p>
          <div class="footer-social">
            <a href="#" aria-label="twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" aria-label="facebook"><i class="fab fa-facebook-square"></i></a>
            <a href="#" aria-label="pinterest"><i class="fab fa-pinterest-p"></i></a>
            <a href="#" aria-label="instagram"><i class="fab fa-instagram"></i></a>
          </div>
          <!-- /.footer-social -->
        </div>
        <!-- /.container -->
      </div>
      <!-- /.footer-bottom -->
    </section>
    <!-- /.site-footer -->
  </div>
</template>

<script>
export default {
  methods: {
    scrollToTop() {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    },
  },
};
</script>