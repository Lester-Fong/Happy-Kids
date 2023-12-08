<template>
    <div>
        <div class="loader-gif" v-if="condition"></div>
        <section class="page-header">
            <div class="page-header__bg" style="background-image: url(/public/front/assets/images/backgrounds/page-header-1-1.jpg)"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <h2>Stories</h2>
                <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                    <li><router-link :to="{ name: 'HomePage' }">Home</router-link></li>
                    <li>-</li>
                    <li><span>Stories</span></li>
                </ul>
                <!-- /.thm-breadcrumb list-unstyled -->
            </div>
            <!-- /.container -->
        </section>
        <!-- /.page-header -->

        <section class="news-page pb-120 pt-120">
            <div class="container">
                <div class="news-3-col">
                    <div v-for="a in displayedBlogs" :key="a.id" class="blog-card">
                        <div class="blog-card__inner">
                            <div class="blog-card__image">
                                <img class="thumbnail-img" :src="`/public/uploads/blogs/thumbnail/${a.original_blogs_id}/medium/${a.thumbnail}`" :alt="a.thumbnail" />

                                <div class="blog-card__date">{{ a.date | formatTransDate2 }}</div>
                            </div>
                            <!-- /.blog-card__image -->
                            <div class="blog-card__content">
                                <div class="blog-card__meta">
                                    <router-link :to="{ name: 'StoriesDetailsPage' }"><i class="far fa-user-circle"></i>{{ formatFullname(a.author.firstname, a.author.lastname) }}</router-link>
                                </div>
                                <!-- /.blog-card__meta -->
                                <h3 class="mb-3">
                                    <router-link :to="{ name: 'StoriesDetailsPage' }">{{ a.title }}</router-link>
                                </h3>
                                <p class="mx-4">{{ truncate(a.description, 100) }}</p>
                                <router-link :to="{ name: 'StoriesDetailsPage', params: a.slug }" class="blog-card__more"><i class="far fa-angle-right"></i>Read More</router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5" v-if="blogs.length > 3">
                    <a @click="onClickSeeMore" href="javascript:void(0);" class="thm-btn dynamic-radius"> {{ is_see_more ? "Show Less Articles" : "See All Articles" }} </a>
                </div>
            </div>
            <!-- /.container -->
        </section>
        <!-- /.news-page -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            is_loading: false,
            is_finish_calling_api: false,
            blogs: [],
            cards: 1,
            pages: {},
            blog_card_limiter: 3,
            author: {},
            is_loading: false,
            author_profile_icon: "",
            img_default: "/public/assets/images/avatar/a-sm.jpg",
            is_see_more: false,
        };
    },

    created() {
        this.onPopulateData();
    },

    methods: {
        onPopulateData() {
            this.is_loading = true;

            this.$front_queries("display_data", {
                action_type: "display_all_blogs",
            })
                .then((res) => {
                    let response = res.data.data.front;
                    console.log(response);
                    // this.pages = response.page;
                    this.blogs = response.blogs;
                    this.is_loading = false;
                    this.is_finish_calling_api = true;
                    this.author = this.blogs.author;
                    this.author_profile_icon = `/public/uploads/administrator/${this.author?.administrator_regular_id}/large/${this.author?.image}`;
                })
                .catch(() => {
                    this.$swal("Error!", this.global_error_message, "error");
                });
        },
        onClickSeeMore() {
            this.is_see_more = !this.is_see_more;
        },
    },
    computed: {
        displayedBlogs() {
            if (this.is_see_more) {
                return this.blogs;
            } else {
                return this.blogs.slice(0, this.blog_card_limiter);
            }
        },
    },
};
</script>
