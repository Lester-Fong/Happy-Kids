<template>
    <div>
        <div v-if="is_loading" class="loader-gif"></div>
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(/public/front/assets/images/backgrounds/page-header-1-1.jpg)"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <h2>Events Page</h2>
                <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                    <li><a href="index.html">Home</a></li>
                    <li>-</li>
                    <li><span>Events</span></li>
                </ul>
                <!-- /.thm-breadcrumb list-unstyled -->
            </div>
            <!-- /.container -->
        </section>
        <!-- /.page-header -->

        <section class="event-page pt-120 pb-120">
            <div class="container">
                <div class="block-title text-center">
                    <h4 class="text-success ms-3"><img class="me-3" src="/public/front/assets/images/shapes/heart-2-1.png" width="15" alt="Heart Icon" />Help People Now</h4>
                    <h3>
                        Charity for the people <br />
                        you care about.
                    </h3>
                </div>
                <div class="event-grid">
                    <div v-for="a in displayedEvents" :key="a.id" class="event-card">
                        <div class="event-card-inner">
                            <div v-if="a.is_expired" class="expired-ribbon">Done</div>
                            <div class="event-card-image">
                                <div class="event-card-image-inner">
                                    <img :src="`/public/uploads/events/${a.original_events_id}/medium/${a.image}`" :alt="a.image" />
                                    <span>{{ a.date_start | formatTransDate3 }}</span>
                                </div>
                                <!-- /.event-card-image-inner -->
                            </div>
                            <!-- /.event-card-image -->
                            <div class="event-card-content">
                                <h3>
                                    <a href="event-details.html">{{ a.title }}</a>
                                </h3>
                                <ul class="event-card-list">
                                    <li>
                                        <i class="azino-icon-clock"></i>
                                        <strong>Time:</strong> {{ onDisplayTimeSpan(a.date_start, a.date_end) }}
                                    </li>
                                    <li>
                                        <i class="azino-icon-pin1"></i>
                                        <strong>Location:</strong> {{ a.location }}
                                    </li>
                                </ul>
                                <!-- /.event-card-list -->
                            </div>
                            <!-- /.event-card-content -->
                        </div>
                        <!-- /.event-card-inner -->
                    </div>
                </div>
                <!-- /.event-grid -->

                <div class="mt-5" v-if="events.length > 9">
                    <a @click="onClickSeeMore" href="javascript:void(0);" class="thm-btn dynamic-radius"> {{ is_see_more ? "Show Less Articles" : "See All Articles" }} </a>
                </div>
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
            events: [],
            pages: {},
            events_card_limiter: 9,
            admin: {},
            is_loading: false,
            is_see_more: false,
        };
    },

    methods: {
        onPopulateData() {
            this.is_loading = true;

            this.$front_queries("display_data", {
                action_type: "display_all_events",
            })
                .then((res) => {
                    let response = res.data.data.front;
                    // this.pages = response.page;
                    this.events = response.events;
                    this.is_loading = false;
                    this.admin = this.events.author;

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
                .catch(() => {
                    Swal.fire("Error!", this.global_error_message, "error");
                });
        },

        onClickSeeMore() {
            this.is_see_more = !this.is_see_more;
        },

        onCheckAndSetExpired() {
            this.$front_queries("events", {
                action_type: "check_and_set_expired",
            })
                .then((res) => {
                    let response = res.data.data.events;
                })
                .catch(() => {
                    Swal.fire("Error!", this.global_error_message, "error");
                });
        },
    },

    created() {
        this.onCheckAndSetExpired();
    },

    mounted() {
        this.onPopulateData();
    },

    computed: {
        displayedEvents() {
            if (this.is_see_more) {
                return this.events;
            } else {
                return this.events.slice(0, this.events_card_limiter);
            }
        },
    },
};
</script>
