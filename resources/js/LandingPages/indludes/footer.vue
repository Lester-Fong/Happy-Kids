<template>
    <div>
        <section class="site-footer">
            <div class="main-footer pt-142 pb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="footer-widget mb-40 footer-widget__about">
                                <!-- <h3 class="text-white">Happy Kids Logo</h3> -->
                                <img src="/public/images/happy_kids_logo.jpg" alt="happy_kids_logo" height="100" />
                                <p>
                                    <a href="https://trimexcolleges.edu.ph" target="_blank">Trimex Colleges</a><br />
                                    Happy Kids
                                </p>
                                <ul class="list-unstyled footer-widget__contact">
                                    <li>
                                        <a href="tel:0495119278"><i class="azino-icon-telephone"></i>(049) 511-9278</a>
                                    </li>
                                    <li class="d-flex">
                                        <a href="mailto:linkages@trimexcolleges.edu.ph"><i class="azino-icon-email"></i>linkages@trimexcolleges.edu.ph</a>
                                    </li>
                                    <li>
                                        <a href="https://www.google.com/maps/place/Trimex+Colleges/@14.339063,121.0763387,16z/data=!4m10!1m2!2m1!1sTrimex+Colleges,+Bi%C3%B1an,+Laguna!3m6!1s0x3397d9fb7cc36f43:0x8b917e497bdafc50!8m2!3d14.339063!4d121.0853509!15sCh9UcmltZXggQ29sbGVnZXMsIEJpw7FhbiwgTGFndW5hkgEPcHJpdmF0ZV9jb2xsZWdl4AEA!16s%2Fg%2F11bwqqh8kv?entry=ttu" target="_blank"
                                            ><i class="azino-icon-pin"></i>Trimex Colleges, Biñan, Laguna</a
                                        >
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
                                    <li><router-link :to="{ name: 'HomePage' }">Home</router-link></li>
                                    <li><router-link :to="{ name: 'AboutPage' }">Our Mission</router-link></li>
                                    <li><router-link :to="{ name: 'OurTeamPage' }">Our Team</router-link></li>
                                    <li><router-link :to="{ name: 'FAQPage' }">FAQ</router-link></li>
                                    <li><router-link :to="{ name: 'FeedingProgramPage' }">Feeding</router-link></li>
                                    <li><router-link :to="{ name: 'ScholarshipProgramPage' }">Scholarship</router-link></li>
                                    <li><router-link :to="{ name: 'EventsPage' }">Events</router-link></li>
                                    <li><router-link :to="{ name: 'StoriesPage' }">Stories</router-link></li>
                                    <li><router-link :to="{ name: 'ContactPage' }">Contact us</router-link></li>
                                    <!-- <li><a href="contact.html">Terms</a></li> -->
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="footer-widget mb-40 footer-widget__blog">
                                <h3 class="footer-widget__title">Blog</h3>
                                <ul class="list-unstyled footer-widget__blog">
                                    <li class="pointer" @click="onRedirectBlog(a)" v-for="a in blogs" :key="a.id">
                                        <!-- <img src="https://picsum.photos/68/70" alt="" /> -->
                                        <img class="footer-thumb" :src="'/public/uploads/blogs/' + a?.original_blogs_id + '/thumb/' + a?.image" alt="" />
                                        <p>{{ a.date | formatTransDate }}</p>
                                        <h3>
                                            <a href="javavascript:void(0);">{{ a.title }}</a>
                                        </h3>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="footer-widget mb-40 footer-widget__newsletter">
                                <h3 class="footer-widget__title">Newletter</h3>
                                <p>Signup now to get daily latest news & updates from us</p>
                                <form class="footer-widget__newsletter-form mc-form">
                                    <label for="mc-email" class="sr-only">Email Address</label>
                                    <input type="email" name="EMAIL" id="mc-email" class="dynamic-radius px-3" placeholder="Email address" />
                                    <div class="footer-widget__newsletter-btn-wrap d-flex justify-content-center">
                                        <button type="submit" class="btn btn-md btn-secondary text-warning">Subscribe Now</button>
                                    </div>
                                </form>
                                <div class="mc-form__response"></div>
                            </div>
                        </div> -->
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
                    <!-- <p>© Copyright 2023 by Layerdrops.com</p> -->
                    <p>© Copyright 2023</p>
                    <div class="footer-social">
                        <!-- <a href="#" aria-label="twitter"><i class="fab fa-twitter"></i></a> -->
                        <a target="_blank" href="https://www.facebook.com/TrimexCollegesHappyKids/" aria-label="facebook"><i class="fab fa-facebook-square"></i></a>
                        <!-- <a href="#" aria-label="pinterest"><i class="fab fa-pinterest-p"></i></a> -->
                        <a target="_blank" href="https://www.instagram.com/trimexcollegeshappykids/" aria-label="instagram"><i class="fab fa-instagram"></i></a>
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
    data() {
        return {
            blogs: [],
        };
    },

    methods: {
        scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        },

        onPopulateData() {
            this.$front_queries("blogs", {
                action_type: "take_2_blogs",
            })
                .then((res) => {
                    let response = res.data.data.blogs;
                    this.blogs = response;
                })
                .catch((err) => {
                    console.error("error footer:" + err);
                });
        },

        onRedirectBlog(data) {
            this.$router.push({ name: "StoriesDetailsPage", params: { slug: data.slug } }).catch(() => {});
        },
    },

    created() {
        this.onPopulateData();
    },
};
</script>
