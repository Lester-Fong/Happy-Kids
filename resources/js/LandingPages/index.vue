<template>
    <div>
        <div class="page-wrapper">
            <landing-header></landing-header>

            <router-view></router-view>

            <landing-footer></landing-footer>
        </div>

        <!-- <div class="mobile-nav__wrapper">
      <div class="mobile-nav__overlay mobile-nav__toggler"></div>
      <div class="mobile-nav__content">
        <span class="mobile-nav__close mobile-nav__toggler"><i class="fas fa-times"></i></span>

        <div class="logo-box">
          <a href="index.html" aria-label="logo image"><img src="https://picsum.photos/200/300" width="50" alt="" /></a>
        </div>
        <div class="mobile-nav__container"></div>

        <ul class="mobile-nav__contact list-unstyled">
          <li>
            <i class="azino-icon-email"></i>
            <a href="mailto:needhelp@azino.com">needhelp@azino.com</a>
          </li>
          <li>
            <i class="azino-icon-telephone"></i>
            <a href="tel:666-888-0000">666 888 0000</a>
          </li>
        </ul>
        <div class="mobile-nav__top">
          <div class="mobile-nav__language">
            <img src="https://picsum.photos/200/300" alt="" />
            <label class="sr-only" for="language-select">select language</label>
            <select class="selectpicker" id="language-select">
              <option value="english">English</option>
              <option value="arabic">Arabic</option>
            </select>
          </div>
          <div class="mobile-nav__social">
            <a href="#" aria-label="twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" aria-label="facebook"><i class="fab fa-facebook-square"></i></a>
            <a href="#" aria-label="pinterest"><i class="fab fa-pinterest-p"></i></a>
            <a href="#" aria-label="instagram"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
    </div> -->
    </div>
</template>

<script>
import LandingHeader from "./indludes/header.vue";
import LandingFooter from "./indludes/footer.vue";

export default {
    name: "App",
    components: {
        LandingHeader,
        LandingFooter,
    },
    data() {
        return {
            msg: "Welcome to Your Vue.js App",
        };
    },
};
</script>
