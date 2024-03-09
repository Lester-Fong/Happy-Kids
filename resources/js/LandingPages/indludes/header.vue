<template>
    <div>
        <div class="main-header__two">
            <div class="main-header__top">
                <div class="container">
                    <p>Welcome to non profit charity platform</p>

                    <div class="main-header__social">
                        <!-- <a href="#" aria-label="twitter"><i class="fab fa-twitter"></i></a> -->
                        <a target="_blank" href="https://www.facebook.com/TrimexCollegesHappyKids/" aria-label="facebook"><i class="fab fa-facebook-square"></i></a>
                        <!-- <a href="#" aria-label="pinterest"><i class="fab fa-pinterest-p"></i></a> -->
                        <a target="_blank" href="https://www.instagram.com/trimexcollegeshappykids/" aria-label="instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                    <!-- /.main-header__social -->
                </div>
                <!-- /.container -->
            </div>
            <!-- /.main-header__top -->
            <div class="header-upper">
                <div class="container">
                    <div class="logo-box d-flex align-items-center">
                        <img src="/public/images/happy_kids_logo.jpg" alt="happy_kids_logo" height="60" />
                        <span class="fa fa-bars mobile-nav__toggler"></span>
                        <div class="ml-2">
                            <a target="_blank" href="https://trimexcolleges.edu.ph/"><h4 class="fw-bold">Trimex Colleges</h4></a>
                            <h6 class="fw-bold">Happy Kids</h6>
                        </div>
                    </div>
                    <!-- /.logo-box -->

                    <div class="header-info">
                        <div class="header-info__box">
                            <i class="azino-icon-email1"></i>
                            <div class="header-info__box-content">
                                <h3>Email</h3>
                                <p><a href="mailto:linkages@trimexcolleges.edu.ph">linkages@trimexcolleges.edu.ph</a></p>
                            </div>
                            <!-- /.header-info__box-content -->
                        </div>
                        <!-- /.header-info__box -->
                        <div class="header-info__box">
                            <i class="azino-icon-calling"></i>
                            <div class="header-info__box-content">
                                <h3>Phone</h3>
                                <p><a href="tel:0495119278">(049) 511-9278</a></p>
                            </div>
                            <!-- /.header-info__box-content -->
                        </div>
                        <!-- /.header-info__box -->
                        <div class="header-info__box">
                            <i class="azino-icon-address"></i>
                            <div class="header-info__box-content">
                                <h3>Visit</h3>
                                <p>
                                    <a href="https://www.google.com/maps/place/Trimex+Colleges/@14.339063,121.0763387,16z/data=!4m10!1m2!2m1!1sTrimex+Colleges,+Bi%C3%B1an,+Laguna!3m6!1s0x3397d9fb7cc36f43:0x8b917e497bdafc50!8m2!3d14.339063!4d121.0853509!15sCh9UcmltZXggQ29sbGVnZXMsIEJpw7FhbiwgTGFndW5hkgEPcHJpdmF0ZV9jb2xsZWdl4AEA!16s%2Fg%2F11bwqqh8kv?entry=ttu" target="_blank"
                                        >Trimex Colleges, <br />
                                        Biñan, Laguna</a
                                    >
                                </p>
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
                                <li><router-link :to="{ name: 'FeedingProgramPage' }">Feeding </router-link></li>
                                <li><router-link :to="{ name: 'ScholarshipProgramPage' }">Scholarship </router-link></li>
                                <li><router-link :to="{ name: 'EventsPage' }">Events</router-link></li>
                            </ul>
                        </li>
                        <li><router-link :to="{ name: 'StoriesPage' }">Stories</router-link></li>
                        <li><router-link :to="{ name: 'ContactPage' }">Contact Us</router-link></li>
                    </ul>
                    <!-- /.main-menu__list -->
                    <a @click="onDonate" href="javascript:void(0)" class="thm-btn dynamic-radius">Donate Now</a>
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
                    <a href="javaScript:void(0);"><img src="/public/images/happy_kids_logo.jpg" width="50" alt="happy_kids_logo" /></a>
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
        <donate-modal @onHideModal="onCancelForm" @success="onSuccess" />
    </div>
</template>

<script>
import DonateModal from "./donate_modal.vue";
export default {
    components: { DonateModal },

    methods: {
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
