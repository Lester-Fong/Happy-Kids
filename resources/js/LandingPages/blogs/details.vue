<template>
    <div>
        <div v-if="is_calling_api" class="loader-gif"></div>
        <div v-else>
            <section class="page-header">
                <div class="page-header__bg" style="background-image: url(..//public/front/assets/images/backgrounds/page-header-1-1.jpg)"></div>
                <!-- /.page-header__bg -->
                <div class="container">
                    <h2>Story Title</h2>
                    <ul class="thm-breadcrumb list-unstyled dynamic-radius">
                        <li><a href="index.html">Home</a></li>
                        <li>-</li>
                        <li><span>Stories</span></li>
                    </ul>
                    <!-- /.thm-breadcrumb list-unstyled -->
                </div>
                <!-- /.container -->
            </section>
            <!-- /.page-header -->

            <section class="blog-details pt-120 pb-40">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-8">
                            <div class="blog-card__image">
                                <img :src="cover_image" :alt="blogs.image" class="cover-img" />
                                <div class="blog-card__date">{{ blogs.date | formatTransDate2 }}</div>
                                <!-- /.blog-card__date -->
                            </div>
                            <!-- /.blog-card__image -->
                            <div class="blog-card__meta d-flex justify-content-start mt-0 mb-0">
                                <a href="javascript:void(0);"><i class="far fa-user-circle"></i> {{ formatFullname(author_firstname ?? "", author_lastname ?? "") }}</a>
                            </div>
                            <!-- /.blog-card__meta -->
                            <h3>{{ blogs.title }}</h3>

                            <div v-html="blogs.description"></div>

                            <div class="blog-details__meta">
                                <!-- <ul class="list-unstyled blog-details__category">
                                    <li><span>Tags:</span></li>
                                    <li><a href="javascript:void(0);">charity</a></li>
                                    <li><a href="javascript:void(0);">donations</a></li>
                                    <li><a href="javascript:void(0);">savelives</a></li>
                                </ul> -->
                                <!-- /.list-unstyled blog-details__category -->
                                <ul class="list-unstyled blog-details__category">
                                    <li><span>Category:</span></li>
                                    <li>
                                        <a href="javascript:void(0);">{{ category_name }}</a>
                                    </li>
                                </ul>
                                <!-- /.list-unstyled blog-details__category -->
                            </div>
                            <!-- /.blog-details__meta -->
                            <div v-if="related_blogs.length > 0">
                                <h5>Related Stories</h5>
                                <div class="blog-navigations">
                                    <router-link v-for="a in related_blogs.slice(0, 1)" :key="a.id" :to="{ name: 'StoriesDetailsPage', params: { slug: a.slug } }">{{ a.title }}</router-link>
                                </div>
                            </div>
                        </div>
                        <!-- /.blog-navigations -->
                        <!-- /.col-md-12 -->
                        <div class="col-md-12 col-lg-4">
                            <div class="blog-sidebar">
                                <div class="blog-sidebar__single m-0">
                                    <h3>Latest Posts</h3>
                                    <ul class="list-unstyled blog-sidebar__post">
                                        <li v-for="a in latest_blogs" class="pointer" @click="onRedirectBlog(a)">
                                            <img class="blog-category-thumb" :src="'/public/uploads/blogs/' + a?.original_blogs_id + '/thumb/' + a?.image" />
                                            <h3>
                                                <a href="javascript:void(0);">{{ a.title }}</a>
                                            </h3>
                                        </li>
                                    </ul>
                                    <!-- /.blog-sidebar__post -->
                                </div>
                                <!-- /.blog-sidebar__single -->
                                <div class="blog-sidebar__single">
                                    <h3>Categories</h3>
                                    <ul class="list-unstyled blog-sidebar__category">
                                        <li v-for="a in blog_categories">
                                            <a href="javascript:void(0);">{{ a.name }}</a>

                                            <i class="bi bi-arrow-right-circle-fill"></i>
                                        </li>
                                    </ul>
                                    <!-- /.blog-sidebar__category -->
                                </div>
                                <!-- /.blog-sidebar__single -->
                                <!-- <div class="blog-sidebar__single">
                                    <h3>Tags</h3>
                                    <ul class="list-unstyled blog-sidebar__tags">
                                        <li v-for=""><a href="javascript:void(0);">Charity</a></li>
                                    </ul>
                                  </div> -->
                                <!-- /.blog-sidebar__category -->
                                <!-- /.blog-sidebar__single -->
                            </div>
                            <!-- /.blog-sidebar -->
                        </div>
                        <!-- /.col-md-12 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container -->
            </section>
            <!-- /.blog-details -->
        </div>
    </div>
</template>

<script>
export default {
    beforeRouteEnter(to, from, next) {
        next((vm) => {
            vm.onAddPageView();
        });
    },
    data() {
        return {
            is_calling_api: false,
            blogs: {},
            popular_blogs: [],
            related_blogs: [],
            latest_blogs: [],
            blog_categories: [],
            pages: {},
            author_firstname: "",
            author_lastname: "",
            minutes_read: "",
            author_profile_icon: "",
            slug: this.$route.params.slug,
            cover_image: "",
            category_name: "",
        };
    },
    created() {
        this.onPopulateData();
    },
    methods: {
        onPopulateData() {
            this.is_calling_api = true;

            this.$front_queries("display_data", {
                action_type: "display_by_blogs_slug",
                slug: this.slug,
            })
                .then((res) => {
                    this.is_calling_api = false;

                    let response = res.data.data.front;
                    // this.pages = response.page;
                    this.blogs = response.single_blog;
                    this.author_firstname = this.blogs.author.firstname ?? "";
                    this.author_lastname = this.blogs.author.lastname ?? "";
                    this.latest_blogs = response.latest_posts;
                    this.blog_categories = response.blog_category;
                    this.related_blogs = response.related_blogs;
                    // this.popular_blogs = response.blogs;
                    this.cover_image = `/public/uploads/blogs/${this.blogs?.original_blogs_id}/large/${this.blogs?.image}`;
                    this.category_name = this.blogs.blog_category?.name ?? "";
                })
                .catch((err) => {
                    console.log(err);
                    // Swal.fire("Error!", this.global_error_message, "error");
                });
        },

        onRedirectBlog(data) {
            this.$router.push({ name: "StoriesDetailsPage", params: { slug: data.slug } });
        },

        onAddPageView() {
            this.$front_queries("save_blogs", {
                blogs: {
                    action_type: "add_blog_views",
                    slug: this.slug,
                },
            })
                .then((res) => {
                    let response = res.data.data.blogs;
                    if (!response.error) {
                        // After the API request is complete, you can proceed to the route
                        next();
                    } else {
                        window.history.back();
                        return false;
                    }
                })
                .catch((err) => {
                    console.log("err: ", err);
                    // Swal.fire("Error!", this.global_error_message, "error");
                });
        },
    },
    metaInfo() {
        return {
            title: this.blogs && this.blogs.meta ? this.blogs.meta.title : "",
            meta: [
                { vmid: "description", name: "description", content: this.blogs && this.blogs.meta ? this.blogs.meta.description : "" },
                { vmid: "keywords", name: "keywords", content: this.blogs && this.blogs.meta ? this.blogs.meta.keywords : "" },
                { vmid: "og:title", name: "og:title", content: this.blogs && this.blogs.meta ? this.blogs.meta.title : "" },
                { vmid: "og:description", name: "og:description", content: this.blogs && this.blogs.meta ? this.blogs.meta.description : "" },
            ],
        };
    },
    watch: {
        slug(val) {
            if (val) {
                this.onPopulateData();
            }
        },

        $route(to, from) {
            this.slug = to.params.slug;
            this.onAddPageView();
        },
    },
};
</script>
