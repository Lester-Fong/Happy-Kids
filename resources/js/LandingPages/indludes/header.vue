<template>
  <div>
    <div class="main-header__two">
      <div class="main-header__top">
        <div class="container">
          <p>Welcome to non profit charity platform</p>

          <div class="main-header__social">
            <a href="#" aria-label="twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" aria-label="facebook"><i class="fab fa-facebook-square"></i></a>
            <a href="#" aria-label="linkedin"><i class="fab fa-linkedin"></i></a>
            <a href="#" aria-label="instagram"><i class="fab fa-instagram"></i></a>
          </div>
          <!-- /.main-header__social -->
        </div>
        <!-- /.container -->
      </div>
      <!-- /.main-header__top -->
      <div class="header-upper">
        <div class="container">
          <div class="logo-box">
            <h3>Happy Kids Logo</h3>
            <span class="fa fa-bars mobile-nav__toggler"></span>
          </div>
          <!-- /.logo-box -->

          <div class="header-info">
            <div class="header-info__box">
              <i class="azino-icon-email1"></i>
              <div class="header-info__box-content">
                <h3>Email</h3>
                <p><a href="javascript:void(0)">happykids@gmail.com</a></p>
              </div>
              <!-- /.header-info__box-content -->
            </div>
            <!-- /.header-info__box -->
            <div class="header-info__box">
              <i class="azino-icon-calling"></i>
              <div class="header-info__box-content">
                <h3>Phone</h3>
                <p><a href="tel:666-888-0000">098525471548</a></p>
              </div>
              <!-- /.header-info__box-content -->
            </div>
            <!-- /.header-info__box -->
            <div class="header-info__box">
              <i class="azino-icon-address"></i>
              <div class="header-info__box-content">
                <h3>Visit</h3>
                <p>Binan, Laguna</p>
              </div>
              <!-- /.header-info__box-content -->
            </div>
            <!-- /.header-info__box -->
          </div>
          <!-- /.header-info -->
        </div>
        <!-- /.container -->
      </div>
      <!-- /.header-upper -->
      <nav class="main-menu">
        <div class="container bg-transparent">
          <ul class="main-menu__list dynamic-radius d-flex align-items-center justify-content-around">
            <li><router-link :to="{ name: 'HomePage' }">Home</router-link></li>
            <li class="dropdown">
              <a href="javascript:void(0)">About</a>
              <ul>
                <li><router-link :to="{ name: 'AboutPage' }">Our Mission</router-link></li>
                <li><router-link :to="{ name: 'OurTeamPage' }">Our Team</router-link></li>
                <li><router-link :to="{ name: 'FAQPage' }">FAQs</router-link></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="javascript:void(0)">Our Program</a>
              <ul>
                <li><router-link :to="{ name: 'FeedingProgramPage' }">Feeding Program</router-link></li>
                <li><router-link :to="{ name: 'ScholarshipProgramPage' }">Scholarship Program</router-link></li>
                <li><router-link :to="{ name: 'EventsPage' }">Events</router-link></li>
              </ul>
            </li>
            <li><router-link :to="{ name: 'StoriesPage' }">Stories</router-link></li>
            <li><router-link :to="{ name: 'ContactPage' }">Contact Us</router-link></li>
          </ul>
          <!-- /.main-menu__list -->
          <a href="javascript:void(0)" class="thm-btn dynamic-radius">Donate Now</a>
          <!-- /.thm-btn dynamic-radius -->
        </div>
        <!-- /.container -->
      </nav>
      <!-- /.main-menu -->
    </div>
    <!-- /.main-header__two -->

    <div class="stricky-header stricked-menu stricky-header-two">
      <div class="container">
        <div class="logo-box">
          <a href="index.html"><img src="https://picsum.photos/200/300" width="50" alt="" /></a>
        </div>
        <!-- /.logo-box -->
        <div class="sticky-header__content">
          <ul class="main-menu__list dynamic-radius">
            <li><router-link :to="{ name: 'HomePage' }">Home</router-link></li>
            <li class="dropdown">
              <a href="javascript:void(0)">About</a>
              <ul>
                <li><router-link :to="{ name: 'AboutPage' }">Our Mission</router-link></li>
                <li><router-link :to="{ name: 'OurTeamPage' }">Our Team</router-link></li>
                <li><router-link :to="{ name: 'FAQPage' }">FAQs</router-link></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="javascript:void(0)">Our Program</a>
              <ul>
                <li><router-link :to="{ name: 'FeedingProgramPage' }">Feeding Program</router-link></li>
                <li><router-link :to="{ name: 'ScholarshipProgramPage' }">Scholarship Program</router-link></li>
                <li><router-link :to="{ name: 'EventsPage' }">Events</router-link></li>
              </ul>
            </li>
            <li><router-link :to="{ name: 'StoriesPage' }">Stories</router-link></li>
            <li><router-link :to="{ name: 'ContactPage' }">Contact Us</router-link></li>
          </ul>
          <!-- /.main-menu__list -->
          <a href="contact.html" class="thm-btn dynamic-radius">Donate Now</a>
        </div>
        <!-- /.sticky-header__content -->
      </div>
      <!-- /.container -->
    </div>
    <!-- /.stricky-header -->
  </div>
</template>