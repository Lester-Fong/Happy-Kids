<template>
    <div>
        <div class="loader-gif" v-if="is_loading"></div>
        <!-- INTRO HEADER PART 1 -->
        <section class="main-slider main-slider__two">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="image-layer" :style="`background-image: url('/public/uploads/pages/${pages.pages_id}/large/${pages.image}')`"></div>
                        <!-- /.image-layer -->
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-xl-6 col-lg-12 text-left">
                                    <h2>{{ pages.description?.title }}</h2>
                                    <p>{{ pages.description?.sub_title }}</p>
                                    <a href="#" data-target=".donate-options" class="scroll-to-target thm-btn dynamic-radius" @click="onDonate">Start Donating</a>
                                    <!-- /.thm-btn dynamic-radius -->
                                </div>
                                <!-- /.col-lg-6 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container -->
                    </div>
                    <!-- /.swiper-slide -->
                    <div class="swiper-slide">
                        <div class="image-layer" :style="`background-image: url('/public/uploads/pages/${pages.pages_id}/large/${pages.extras_image_1}')`"></div>
                        <!-- /.image-layer -->
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-xl-6 col-lg-12 text-left">
                                    <h2>{{ pages.description?.title }}</h2>
                                    <p>{{ pages.description?.sub_title }}</p>
                                    <a href="#" data-target=".donate-options" class="scroll-to-target thm-btn dynamic-radius" @click="onDonate">Start Donating</a>
                                    <!-- /.thm-btn dynamic-radius -->
                                </div>
                                <!-- /.col-lg-6 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container -->
                    </div>
                    <!-- /.swiper-slide -->
                    <div class="swiper-slide">
                        <div class="image-layer" :style="`background-image: url('/public/uploads/pages/${pages.pages_id}/large/${pages.extras_image_2}')`"></div>
                        <!-- /.image-layer -->
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-xl-6 col-lg-12 text-left">
                                    <h2>{{ pages.description?.title }}</h2>
                                    <p>{{ pages.description?.sub_title }}</p>
                                    <a href="#" data-target=".donate-options" class="scroll-to-target thm-btn dynamic-radius" @click="onDonate">Start Donating</a>
                                    <!-- /.thm-btn dynamic-radius -->
                                </div>
                                <!-- /.col-lg-6 -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container -->
                    </div>
                    <!-- /.swiper-slide -->
                </div>
                <!-- /.swiper-wrapper -->
                <div class="swiper-pagination" id="main-slider-pagination"></div>
            </div>
            <!-- /.swiper-container thm-swiper__slider -->
        </section>
        <!-- /.main-slider -->

        <!-- THREE OPTIONS PART 2 -->
        <section class="service-two">
            <div class="container">
                <div class="swiper-container thm-swiper__slider">
                    <div class="swiper-wrapper row mx-0">
                        <div class="mx-auto col-lg-4 col-md-6 col-12" v-for="(item, i) in pages.description?.objective_description" :key="i">
                            <div class="service-two__box wow fadeInUp" data-wow-duration="1500ms" :class="i == 0 ? ' background-primary' : i == 1 ? ' background-secondary' : 'background-base'" :style="`background-image: url('${onNameImage(i)}')`">
                                <div class="service-two__box-inner">
                                    <img src="/public/front/assets/images/shapes/heart-2-2.png" width="15" alt="" />
                                    <p>{{ item }}</p>
                                    <h3 class="w-75" v-for="(sub_item, index) in pages.description?.objective_sub_description" :key="index">
                                        <a href="javascript:void(0)" v-if="index == i">{{ sub_item }}</a>
                                    </h3>
                                    <router-link :to="{ name: 'ContactPage' }" class="service-two__box-link"><i class="fas fa-angle-right"></i></router-link>
                                    <!-- /.service-two__link -->
                                </div>
                                <!-- /.service-two__box-inner -->
                            </div>
                            <!-- /.service-two__box -->
                        </div>
                        <!-- /.swiper-slide -->
                        <!-- <div class="mx-auto col-lg-4 col-md-6 col-12">
              <div class="service-two__box background-secondary wow fadeInDown" data-wow-duration="1500ms" data-wow-delay="100ms" style="background-image: url('/public/front/assets/images/backgrounds/card-volunteers.jpg')">
                <div class="service-two__box-inner">
                  <img src="/public/front/assets/images/shapes/heart-2-2.png" width="15" alt="" />
                  <p>Let’s Join</p>
                  <h3>
                    <a href="become-volunteer.html"
                      >Join our <br />
                      volunteers</a
                    >
                  </h3>
                  <a href="become-volunteer.html" class="service-two__box-link"><i class="fas fa-angle-right"></i></a>
                </div>
              </div>
            </div>
            <div class="mx-auto col-lg-4 col-md-6 col-12">
              <div class="service-two__box background-base wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="200ms" style="background-image: url('/public/front/assets/images/backgrounds/card-childeduc.jpg')">
                <div class="service-two__box-inner">
                  <img src="/public/front/assets/images/shapes/heart-2-2.png" width="15" alt="" />
                  <p>Quick Funding</p>
                  <h3>
                    <a href="contact.html"
                      >Poor childs <br />
                      education</a
                    >
                  </h3>
                  <a href="contact.html" class="service-two__box-link"><i class="fas fa-angle-right"></i></a>
                </div>
              </div>
            </div> -->
                    </div>
                </div>
                <!-- /.causes-col__3 -->
            </div>
            <!-- /.container -->
        </section>
        <!-- /.service-two -->

        <!-- ABOUT PART 3 -->
        <section class="about-two pt-120 pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="about-two__image wow fadeInLeft" data-wow-duration="1500ms">
                            <img :src="`/public/uploads/pages/about_/homepage/${pages.description?.about_image_webp}`" alt="about us image." class="about-two__image_left" />
                            <div class="about-two__award">
                                <img src="/public/front/assets/images/shapes/about-bag-1-2.png" alt="" />
                            </div>
                            <!-- /.about-two__award -->
                        </div>
                        <!-- /.about-two__image -->
                    </div>
                    <!-- /.col-lg-6 -->
                    <div class="col-xl-6">
                        <div class="about-two__content">
                            <div class="block-title mb-4">
                                <p><img src="/public/front/assets/images/shapes/heart-2-1.png" width="15" alt="" /> {{ pages.description?.about_main_title }}</p>
                                <h3>{{ pages.description?.about_subtitle }}</h3>
                            </div>
                            <!-- /.block-title -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="about-two__box my-1" v-for="(a, i) in pages.description?.about_title" :key="i">
                                        <h3><i class="azino-icon-confirmation"></i> {{ a }}</h3>
                                        <p v-for="(b, ind) in pages.description?.about_description" :key="ind">{{ ind == i ? b : "" }}</p>
                                    </div>
                                </div>
                                <!-- /.col-md-6 -->
                            </div>
                            <!-- /.row -->
                            <router-link :to="{ name: 'AboutPage' }" class="thm-btn dynamic-radius">Discover More</router-link>
                            <!-- /.thm-btn dynamic-radius -->
                        </div>
                        <!-- /.about-two__content -->
                    </div>
                    <!-- /.col-lg-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </section>
        <!-- /.about-two -->

        <!-- HELP VIDEO SECTION PART 4-->
        <section class="video-card">
            <div class="video-card__bg" :style="`background-image: url('/public/uploads/pages/video_/homepage/${pages.description?.video_image_webp}')`"></div>
            <!-- /.video-card__bg -->
            <div class="container text-center pt-120 pb-120">
                <p class="text-info"><img src="/public/front/assets/images/shapes/heart-2-1.png" width="15" alt="" />{{ pages.description?.video_title }}</p>
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

        <!-- <section class="causes-page causes-home pt-120 pb-120">
        <div class="container">
          <div class="row align-items-start align-items-md-center flex-column flex-md-row mb-60">
            <div class="col-lg-7">
              <div class="block-title">
                <p><img src="https://picsum.photos/200/300" width="15" alt="" />Popular Causes</p>
                <h3>
                  Donate to charity causes <br />
                  around the world.
                </h3>
              </div>
            </div>
            <div class="col-lg-5 d-flex">
              <div class="my-auto">
                <p class="block-text pr-10 mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Have you done google research which works all the time.</p>
              </div>
            </div>
          </div>
          <div
            class="swiper-container thm-swiper__slider"
            data-swiper-options='{"slidesPerView": 3, "spaceBetween": 30,
        "breakpoints": {
            "0": {
                "slidesPerView": 1,
                "spaceBetween": 30
            },
            "375": {
                "slidesPerView": 1,
                "spaceBetween": 30
            },
            "575": {
                "slidesPerView": 1,
                "spaceBetween": 30
            },
            "768": {
                "slidesPerView": 1,
                "spaceBetween": 30
            },
            "991": {
                "slidesPerView": 2,
                "spaceBetween": 30
            },
            "1199": {
                "slidesPerView": 2,
                "spaceBetween": 30
            },
            "1200": {
                "slidesPerView": 3,
                "spaceBetween": 30
            }
        }
        }'
          >
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="cause-card">
                  <div class="cause-card__inner">
                    <div class="cause-card__image">
                      <img src="https://picsum.photos/200/300" alt="" />
                    </div>
                    <div class="cause-card__content">
                      <div class="cause-card__top">
                        <div class="cause-card__progress">
                          <span style="width: 23%" class="wow cardProgress" data-wow-duration="1500ms">
                            <b><i>23</i>%</b>
                          </span>
                        </div>
                        <div class="cause-card__goals">
                          <p><strong>Raised:</strong> $25,270</p>
                          <p><strong>Goal:</strong> $30,000</p>
                        </div>
                      </div>
                      <h3><a href="cause-details.html">Our donation is hope for poor childrens</a></h3>
                      <p>Lorem Ipsum simply dummy text of printng and type industry.</p>
                      <div class="cause-card__bottom">
                        <a href="cause-details.html" class="thm-btn dynamic-radius">Donate Now</a>
                        <a href="#" class="cause-card__share" aria-label="share postr"><i class="azino-icon-share"></i></a
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="cause-card">
                  <div class="cause-card__inner">
                    <div class="cause-card__image">
                      <img src="https://picsum.photos/200/300" alt="" />
                    </div>
                    <div class="cause-card__content">
                      <div class="cause-card__top">
                        <div class="cause-card__progress">
                          <span style="width: 65%" class="wow cardProgress" data-wow-duration="1500ms">
                            <b><i>65</i>%</b>
                          </span>
                        </div>
                        <div class="cause-card__goals">
                          <p><strong>Raised:</strong> $25,270</p>
                          <p><strong>Goal:</strong> $30,000</p>
                        </div>
                      </div>
                      <h3><a href="cause-details.html">Education for Poor Children</a></h3>
                      <p>Lorem Ipsum simply dummy text of printng and type industry.</p>
                      <div class="cause-card__bottom">
                        <a href="cause-details.html" class="thm-btn dynamic-radius">Donate Now</a>
                        <a href="#" class="cause-card__share" aria-label="share postr"><i class="azino-icon-share"></i></a
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="cause-card">
                  <div class="cause-card__inner">
                    <div class="cause-card__image">
                      <img src="https://picsum.photos/200/300" alt="" />
                    </div>
                    <div class="cause-card__content">
                      <div class="cause-card__top">
                        <div class="cause-card__progress">
                          <span style="width: 55%" class="wow cardProgress" data-wow-duration="1500ms">
                            <b><i>55</i>%</b>
                          </span>
                        </div>
                        <div class="cause-card__goals">
                          <p><strong>Raised:</strong> $25,270</p>
                          <p><strong>Goal:</strong> $30,000</p>
                        </div>
                      </div>
                      <h3><a href="cause-details.html">Promoting The Rights of Children</a></h3>
                      <p>Lorem Ipsum simply dummy text of printng and type industry.</p>
                      <div class="cause-card__bottom">
                        <a href="cause-details.html" class="thm-btn dynamic-radius">Donate Now</a>
                        <a href="#" class="cause-card__share" aria-label="share postr"><i class="azino-icon-share"></i></a
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section> -->

        <!-- <section class="featured-cause">
        <div class="container">
          <div class="inner-container background-secondary wow fadeInUp" data-wow-duration="1500ms">
            <div class="row">
              <div class="col-lg-4">
                <img src="https://picsum.photos/200/300" class="img-fluid" alt="" />
              </div>
              <div class="col-lg-8 d-flex">
                <div class="my-auto">
                  <h3>Urgent help needed now</h3>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                  <div class="cause-card__top">
                    <div class="cause-card__progress">
                      <span style="width: 85%" class="wow cardProgress" data-wow-duration="1500ms">
                        <b><i>85</i>%</b>
                      </span>
                    </div>
                    <div class="cause-card__goals">
                      <p><strong>Raised:</strong> $25,270</p>
                      <p><strong>Goal:</strong> $30,000</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section> -->

        <!-- FAQ SECTION PART 5 -->
        <section class="faq-one pt-120">
            <div class="container faq_one_container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="faq-one__content">
                            <div class="block-title">
                                <p><img src="/public/front/assets/images/shapes/heart-2-1.png" width="15" alt="Heart Icon" />{{ pages.description?.faq_title }}</p>
                                <h3 class="w-75">
                                    {{ pages.description?.faq_subtitle }}
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
                    <div class="col-lg-6">
                        <div class="about-counter__image clearfix">
                            <div class="about-counter__image-content">
                                <img src="/public/front/assets/images/shapes/about-count-heart-1-1.png" alt="about-count-heart-1-1" />
                                <p>We’re here to support you every step of the way.</p>
                            </div>
                            <img :src="`/public/uploads/pages/faq_/homepage/${pages.description?.faq_image_webp}`" alt="charity people" class="float-left part-five__image_right" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TESTIMONIALS SECTION PART 6 -->
        <section class="testimonials-one pt-120 pb-90" :style="`background-image: url('/public/uploads/pages/testimonial_/homepage/${pages.description?.testimonial_image_webp}')`">
            <div class="container">
                <div class="team-about__top">
                    <div class="row align-items-center">
                        <div class="col-md-12 col-lg-7">
                            <div class="block-title">
                                <p><img src="/public/front/assets/images/shapes/heart-2-1.png" width="15" alt="" />{{ pages.description?.testimonial_title }}</p>
                                <h3 class="w-75 pe-5">
                                    {{ pages.description?.testimonial_subtitle }}
                                </h3>
                            </div>
                            <!-- /.block-title -->
                        </div>
                        <!-- /.col-md-12 col-lg-6 -->
                        <div class="col-md-12 col-lg-5">
                            <p class="team-about__top-text">{{ pages.description?.testimonial_description }}</p>
                        </div>
                        <!-- /.col-md-12 col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.team-about__top -->
                <div class="thm-swiper__slider swiper-container swiper">
                    <div class="row swiper-wrapper">
                        <div class="col mx-auto card-group swiper-slider" v-for="(a, i) in testimonials" :key="i">
                            <div class="testimonials-one__single card">
                                <div class="testimonials-one__image">
                                    <img :src="`/public/uploads/testimonials/${a.original_testimonial_id}/${a.image}`" :alt="a.name + ' picture'" class="testimonial_profile_image" />
                                </div>
                                <p>{{ a.description }}</p>
                                <h3>{{ a.name }}</h3>
                                <span>{{ a.position }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </section>

        <!-- PRICE SECTION PART 7 -->
        <!-- <section class="price-one">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5">
                        <div class="price-one__main">
                            <div class="block-title">
                                <p class="text-info"><img src="/public/front/assets/images/shapes/heart-2-1.png" width="15" alt="" /> {{ pages.description?.donate_title }}</p>
                                <h3>
                                    {{ pages.description?.donate_subtitle }}
                                </h3>
                            </div>
                            <p>{{ pages.description?.donate_description }}</p>
                            <div class="price-one__image-box">
                                <img :src="`/public/uploads/pages/donate_/homepage/${pages.description?.donate_image_webp}`" alt="children-hands" />
                                <div class="price-one__image-box-content">
                                    <h3><i class="fa fa-check"></i> {{ pages.description?.donate_purpose_title }}</h3>
                                    <p>{{ pages.description?.donate_purpose_description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="price-one__single wow flipInY" data-wow-duration="1500ms">
                                    <i class="fa fa-paper-plane"></i>
                                    <p>Silver Package</p>
                                    <h3>$30.00</h3>
                                    <ul class="price-one__list">
                                        <li>Free text goes here</li>
                                        <li>Write here anything</li>
                                        <li>Above mention it</li>
                                        <li>Say once again</li>
                                    </ul>
                                    <a href="#" class="thm-btn dynamic-radius">Choose Plan</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="price-one__single gold wow flipInY" data-wow-duration="1500ms">
                                    <i class="fa fa-plane"></i>
                                    <p>Gold Package</p>
                                    <h3>$60.00</h3>
                                    <ul class="price-one__list">
                                        <li>Free text goes here</li>
                                        <li>Write here anything</li>
                                        <li>Above mention it</li>
                                        <li>Say once again</li>
                                    </ul>
                                    <a href="#" class="thm-btn dynamic-radius">Choose Plan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!-- /.price-one -->

        <!-- GALLERY SECTION PART 8 -->
        <!-- <section class="gallery-home-two pt-120 pb-120">
      <div class="container">
        <img src="/public/front/assets/images/shapes/video-dot-1-1.png" alt="" class="gallery-home-two__dots" />
        <div class="thm-swiper__slider swiper-container swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide" v-for="index in 8" :key="index">
              <div class="gallery-card">
                <img src="https://picsum.photos/200/300" class="img-fluid w-100" alt="" />
                <div class="gallery-content">
                  <a href="https://picsum.photos/200/300" class="img-popup" aria-label="open image"><i class="fas fa-plus"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->

        <!-- LATEST EVENT SECTION PART 9 -->
        <section class="event-home-two py-5" :style="`background-image: url('/public/uploads/pages/event_/homepage/${pages.description?.event_image_webp}')`">
            <div class="container">
                <div class="row align-items-start align-items-md-center flex-column flex-md-row mb-60">
                    <div class="col-lg-7">
                        <div class="block-title">
                            <p><img src="/public/front/assets/images/shapes/heart-2-1.png" width="15" alt="" />{{ pages.description?.events_title }}</p>
                            <h3 class="w-75 pe-5">
                                {{ pages.description?.events_description }}
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-5 d-flex">
                        <div class="my-auto">
                            <p class="block-text pr-10 mb-0">
                                {{ pages.description?.events_subtitle }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="event-grid">
                    <div v-for="a in events" :key="a.id" class="event-card">
                        <div class="event-card-inner">
                            <div v-if="a.is_expired" class="expired-ribbon">Done</div>
                            <div class="event-card-image">
                                <div class="event-card-image-inner">
                                    <!-- <img src="https://picsum.photos/200/300" alt="" class="latest_event_img" /> -->
                                    <img :src="`/public/uploads/events/${a.original_events_id}/medium/${a.image}`" :alt="a.image" class="latest_event_img" />
                                    <span>{{ a.date_start | formatTransDate3 }}</span>
                                </div>
                            </div>
                            <div class="event-card-content">
                                <!-- <h3><a href="event-details.html">{{ a.title }}</a></h3> -->
                                <h3>
                                    <router-link :to="{ name: 'EventsPage' }">{{ a.title }}</router-link>
                                </h3>
                                <ul class="event-card-list">
                                    <li>
                                        <i class="azino-icon-clock"></i>
                                        <strong>Time:</strong>{{ onDisplayTimeSpan(a.date_start, a.date_end) }}
                                    </li>
                                    <li>
                                        <i class="azino-icon-pin1"></i>
                                        <strong>Location:</strong> {{ a.location }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- <section class="news__top news-home pt-120" style="background-image: url(https://picsum.photos/200/300)">
        <div class="container">
          <div class="row align-items-start align-items-md-center flex-column flex-md-row">
            <div class="col-lg-7">
              <div class="block-title">
                <p><img src="https://picsum.photos/200/300" width="15" alt="" />Popular Causes</p>
                <h3>
                  Donate to charity causes <br />
                  around the world.
                </h3>
              </div>
            </div>
            <div class="col-lg-5 d-flex">
              <div class="my-auto">
                <p class="block-text pr-10 mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Have you done google research which works all the time.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="news-page pb-120">
        <div class="container">
          <div
            class="swiper-container thm-swiper__slider"
            data-swiper-options='{"slidesPerView": 3, "spaceBetween": 30,
        "breakpoints": {
            "0": {
                "slidesPerView": 1,
                "spaceBetween": 0
            },
            "375": {
                "slidesPerView": 1,
                "spaceBetween": 30
            },
            "575": {
                "slidesPerView": 1,
                "spaceBetween": 30
            },
            "768": {
                "slidesPerView": 1,
                "spaceBetween": 30
            },
            "991": {
                "slidesPerView": 2,
                "spaceBetween": 30
            },
            "1199": {
                "slidesPerView": 2,
                "spaceBetween": 30
            },
            "1200": {
                "slidesPerView": 3,
                "spaceBetween": 30
            }
        }
        }'
          >
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="0ms">
                  <div class="blog-card">
                    <div class="blog-card__inner">
                      <div class="blog-card__image">
                        <img src="https://picsum.photos/200/300" alt="" />
                        <div class="blog-card__date">20 May</div>
                      </div>
                      <div class="blog-card__content">
                        <div class="blog-card__meta">
                          <a href="news-details.html"><i class="fas fa-user-circle"></i> Admin</a>
                          <a href="news-details.html"><i class="fas fa-comments"></i> 2 Comments</a>
                        </div>
                        <h3><a href="news-details.html">Our donation is hope for poor childrens</a></h3>
                        <p>Lorem ipsum is simply free text used by copytyping refreshing.</p>
                        <a href="news-details.html" class="blog-card__more"><i class="fas fa-angle-right"></i>Read More</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="wow fadeInDown" data-wow-duration="1500ms" data-wow-delay="100ms">
                  <div class="blog-card">
                    <div class="blog-card__inner">
                      <div class="blog-card__image">
                        <img src="https://picsum.photos/200/300" alt="" />
                        <div class="blog-card__date">20 May</div>
                      </div>
                      <div class="blog-card__content">
                        <div class="blog-card__meta">
                          <a href="news-details.html"><i class="fas fa-user-circle"></i> Admin</a>
                          <a href="news-details.html"><i class="fas fa-comments"></i> 2 Comments</a>
                        </div>
                        <h3><a href="news-details.html">Education for Poor Children</a></h3>
                        <p>Lorem ipsum is simply free text used by copytyping refreshing.</p>
                        <a href="news-details.html" class="blog-card__more"><i class="fas fa-angle-right"></i>Read More</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="wow fadeInRight" data-wow-duration="1500ms" data-wow-delay="200ms">
                  <div class="blog-card">
                    <div class="blog-card__inner">
                      <div class="blog-card__image">
                        <img src="https://picsum.photos/200/300" alt="" />
                        <div class="blog-card__date">20 May</div>
                      </div>
                      <div class="blog-card__content">
                        <div class="blog-card__meta">
                          <a href="news-details.html"><i class="fas fa-user-circle"></i> Admin</a>
                          <a href="news-details.html"><i class="fas fa-comments"></i> 2 Comments</a>
                        </div>
                        <h3><a href="news-details.html">Promoting The Rights of Children</a></h3>
                        <p>Lorem ipsum is simply free text used by copytyping refreshing.</p>
                        <a href="news-details.html" class="blog-card__more"><i class="fas fa-angle-right"></i>Read More</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section> -->

        <!-- PARTNER AND SPONSOR SECTION PART 10 -->
        <!-- <div class="client-carousel py-5 client-carousel__has-border-top part-10">
      <h2 class="text-center mb-5">Sponsors &nbsp; <img src="/public/front/assets/images/shapes/heart-2-1.png" width="50" alt="favicon heart" /></h2>
      <div class="container">
        <div class="thm-swiper__slider swiper-container swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide" v-for="index in 7" :key="index">
              <img src="https://picsum.photos/250/75" alt="" />
            </div>
          </div>
        </div>
      </div>
    </div> -->
    </div>
</template>

<script>
import DonateModal from "./indludes/donate_modal.vue";

export default {
    name: "Home",

    components: { DonateModal },

    data() {
        return {
            is_loading: false,
            pages: [],
            testimonials: [],
            faq: [],
            events: [],
        };
    },
    mounted() {
        this.initSwiper();
    },

    created() {
        this.onPopulateData();
    },

    methods: {
        onPopulateData() {
            this.is_loading = true;

            this.$front_queries("front_page_data", {
                action_type: "display_homepage",
            })
                .then((res) => {
                    this.is_loading = false;
                    let response = res.data.data.front;
                    this.pages = response.pages;
                    this.testimonials = response.testimonials;
                    this.faq = response.faq;
                    this.events = response.events;

                    this.events.sort((a, b) => {
                        if (a.is_expired === true && b.is_expired !== true) {
                            return 1; // a should be after b
                        } else if (a.is_expired !== true && b.is_expired === true) {
                            return -1; // a should be before b
                        } else {
                            return 0; // order remains unchanged
                        }
                    });
                })
                .catch((err) => {
                    console.error("error:" + err);
                });
        },

        onNameImage(index) {
            // Check if pages.description is defined
            if (this.pages.description) {
                // Construct the property name dynamically using square bracket notation
                let propertyName = `obj_files_webp_${index}`;

                // Check if the property exists in pages.description before attempting to access it
                if (propertyName in this.pages.description) {
                    let name = `/public/uploads/pages/objectives_${index}/homepage/${this.pages.description[propertyName]}`;
                    return name;
                }
            }

            return ""; // or any default value you prefer if the data is not available
        },

        initSwiper() {
            new Swiper(".main-slider .swiper", {
                slidesPerView: 1,
                loop: true,
                effect: "fade",
                pagination: {
                    el: "#main-slider-pagination",
                    type: "bullets",
                    clickable: true,
                },
                autoplay: {
                    delay: 5000,
                },
            });
            new Swiper(".gallery-home-two .swiper", {
                slidesPerView: 5,
                spaceBetween: 100,
                autoplay: { delay: 5000 },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    },
                    375: {
                        slidesPerView: 1,
                        spaceBetween: 30,
                    },
                    575: {
                        slidesPerView: 1,
                        spaceBetween: 30,
                    },
                    768: {
                        slidesPerView: 1,
                        spaceBetween: 30,
                    },
                    991: {
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    1199: {
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    1200: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                },
            });
            new Swiper(".testimonials-one .swiper", {
                slidesPerView: 3,
                spaceBetween: 150,
                autoplay: { delay: 5000 },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    },
                    375: {
                        slidesPerView: 1,
                        spaceBetween: 30,
                    },
                    575: {
                        slidesPerView: 1,
                        spaceBetween: 30,
                    },
                    768: {
                        slidesPerView: 1,
                        spaceBetween: 30,
                    },
                    991: {
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    1199: {
                        slidesPerView: 2,
                        spaceBetween: 100,
                    },
                    1200: {
                        slidesPerView: 3,
                        spaceBetween: 100,
                    },
                },
            });
            new Swiper(".part-10 .swiper", {
                spaceBetween: 100,
                slidesPerView: 5,
                autoplay: { delay: 5000 },
                breakpoints: {
                    0: {
                        spaceBetween: 30,
                        slidesPerView: 2,
                    },
                    375: {
                        spaceBetween: 30,
                        slidesPerView: 2,
                    },
                    575: {
                        spaceBetween: 30,
                        slidesPerView: 3,
                    },
                    767: {
                        spaceBetween: 50,
                        slidesPerView: 4,
                    },
                    991: {
                        spaceBetween: 50,
                        slidesPerView: 5,
                    },
                    1199: {
                        spaceBetween: 100,
                        slidesPerView: 5,
                    },
                },
            });
        },

        onDonate() {
            $("#donate_modal").modal("show");
            $("#donate_modal").appendTo("body");
        },

        onCancelForm() {
            $("#donate_modal").modal("hide");
        },

        onSuccess() {
            $("#donate_modal").modal("hide");
        },
    },
};
</script>
