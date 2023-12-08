<template>
    <div>
        <div v-if="is_loading" class="loader-gif"></div>
        <div class="card container px-4 py-2 card-bordered card-preview">
            <div class="card-inner mb-4">
                <div class="preview-block">
                    <div class="row gy-4">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="default-01">Title</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="default-01" placeholder="" v-model="title" />
                                    <div class="text-danger">{{ title_error }}</div>
                                    <router-link v-if="slug != ''" :to="'/blogs-details/' + slug" target="_blank">http://happy_kids.local/blogs/{{ slug }}</router-link>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="default-06">Category</label>
                                <div class="form-control-wrap">
                                    <select class="form-select" v-model="category">
                                        <option :value="a.original_category_id" v-for="a in blog_category_arr" :key="a.original_category_id">{{ a.name }}</option>
                                    </select>
                                    <div class="text-danger">{{ category_error }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <textarea id="summernote_blog" v-model="description"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="default-06">Header Image</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" class="form-file-input" id="customFile" @change="onFileChanged" placeholder="Choose File" />
                                        <!-- <label class="form-file-label" for="customFile">{{ selectedFile }}</label> -->
                                    </div>
                                </div>
                                <img class="mt-2" :src="header_image" alt="" v-if="is_image" width="100" />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="default-06">Thumbnail</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" class="form-file-input" id="customFile" @change="onFileChangedThumbnail" placeholder="Choose File" />
                                        <!-- <label class="form-file-label" for="customFile">{{ selectedFileThumb }}</label> -->
                                    </div>
                                </div>
                                <img class="mt-2" :src="front_image" alt="" v-if="is_front" width="100" />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Date</label>
                                <div class="form-control-wrap">
                                    <date-picker v-model="blog_date" valueType="format" class="col-sm-12"></date-picker>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">Minutes read</label>
                                    <div class="form-control-wrap">
                                        <input type="number" min="0" max="60" class="form-control" v-model="minutes_read" />
                                    </div>
                                </div>
                            </div> -->

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <div class="form-control-wrap">
                                    <div class="custom-control custom-control-sm custom-radio">
                                        <input type="radio" id="customRadio7" class="custom-control-input" v-model="status" value="1" />
                                        <label class="custom-control-label" for="customRadio7">Live</label>
                                    </div>
                                    <div class="custom-control custom-control-sm custom-radio">
                                        <input type="radio" id="customRadio8" class="custom-control-input" v-model="status" value="2" />
                                        <label class="custom-control-label" for="customRadio8">Draft</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr />

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="default-textarea">Meta Title</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control no-resize" id="default-textarea" v-model="meta_title"></textarea>
                                    <div class="text-danger">{{ meta_title_error }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="default-textarea">Meta Description</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control no-resize" id="default-textarea" v-model="meta_description"></textarea>
                                    <div class="text-danger">{{ meta_description_error }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-sm-6 mt-2">
                            <div class="form-group">
                                <label class="form-label" for="default-textarea">Meta Keywords</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control no-resize" id="default-textarea" v-model="meta_keywords"></textarea>
                                    <div class="text-danger">{{ meta_keywords_error }}</div>
                                </div>
                            </div>
                        </div> -->
                        <div class="col-sm-6 mt-2">
                            <div class="form-group">
                                <label class="form-label" for="tagify-input">Meta Keywords</label>
                                <div class="form-control-wrap">
                                    <!-- Use an input element for Tagify -->
                                    <input id="tagify-input" placeholder="Type and press Enter to add tags" class="form-control" />
                                    <div class="text-danger">{{ meta_keywords_error }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex align-center justify-content-end">
                <div class="px-2">
                    <button type="button" name="button" class="btn button--secondary t-dark" @click="onCancel">Cancel</button>
                </div>
                <button type="submit" name="button" class="btn button--primary t-dark" @click="onSubmit">Save</button>
            </div>
        </div>
        <!-- nk-block -->
    </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
// import Tagify from "@yaireo/tagify/dist/tagify.min.js";
import "@yaireo/tagify/dist/tagify.css"; // Import Tagify styles
import Tagify from "@yaireo/tagify";

export default {
    metaInfo: {
        title: "Admin - Blogs - New",
    },
    components: { DatePicker },
    data() {
        return {
            title: "",
            description: "",
            blog_date: "",
            category: "",

            meta_title: "",
            meta_keywords: [],
            meta_description: "",

            title_error: "",
            slug_error: "",
            header_error: "",
            meta_title_error: "",
            meta_keywords_error: "",
            meta_description_error: "",
            category_error: "",
            is_error: false,

            selectedFile: "",
            header_image: "",
            is_image: false,

            is_loading: false,
            is_edit: false,
            blogs_id: "",
            blogs: {},
            blog_category_arr: [],

            front_image: "",
            is_front: false,
            selectedFileThumb: "",
            slug: "",
            status: "2",
            tagify: null,
            tagifyInput: null,
            // minutes_read: "",
        };
    },
    created() {
        let _this = this;
        this.$nextTick(function () {
            _this.onSummerNote("#summernote_blog", 600, this.onUploadImage);
            $("#summernote_blog").summernote("code", "");
            this.initializeTagify();
        });
        if (this.$route.params.id) {
            this.blogs_id = this.$route.params.id;
            this.is_edit = true;
        }
        this.onPopulateCategory();
    },
    methods: {
        initializeTagify() {
            this.tagifyInput = document.getElementById("tagify-input");
            var tagify = new Tagify(this.tagifyInput);

            tagify.on("add", (e) => {
                this.meta_keywords.push(e.detail.data.value);
            });
        },
        onPopulateCategory() {
            this.$admin_queries("blog_category", {
                action_type: "display_all",
            })
                .then((res) => {
                    this.is_loading = false;
                    this.blog_category_arr = res.data.data.blog_category;
                    console.log("onPopulateCategory: ", res);
                })
                .catch((err) => {
                    Swal.fire("Error!", this.global_error_message, "error");
                });
        },
        onUploadImage(file) {
            this.is_loading = true;

            this.$query_administrator("save_blogs", {
                file1: file,
                blogs: {
                    action_type: "upload_image_to_editor",
                },
            })
                .then((res) => {
                    this.is_loading = false;

                    if (res.data.errors) {
                        let errors = Object.values(res.data.errors[0].extensions.validation).flat();
                        let errors_keys = Object.keys(res.data.errors[0].extensions.validation).flat();

                        this.title_error = errors_keys.some((q) => q == "blogs.title") ? errors[errors_keys.indexOf("blogs.title")] : "";
                    } else {
                        let response = res.data.data.blogs;

                        if (response.error == false) {
                            $("#summernote_blog").summernote("insertImage", "/" + response.filename);
                        } else {
                            Swal.fire("Error!", response.message, "error");
                        }
                    }
                })
                .catch(() => {
                    this.is_loading = false;
                    Swal.fire("Error!", this.global_error_message, "error");
                });
        },
        onCancel() {
            this.$router.replace("/admin/blogs");
        },
        onSubmit() {
            this.onClearErrors();
            this.onCheckRequiredFields();
            if (this.is_error == false) {
                this.is_loading = true;

                this.$admin_queries("save_blogs", {
                    blogs: {
                        title: this.title,
                        description: $("#summernote_blog").summernote("code"),
                        date: this.blog_date,
                        meta_title: this.meta_title,
                        meta_keywords: this.meta_keywords,
                        meta_description: this.meta_description,
                        blogs_id: this.blogs_id,
                        category_id: this.category,
                        status: this.status,
                        action_type: this.is_edit ? "update" : "add",
                    },
                    file: this.selectedFile,
                    thumbnail: this.selectedFileThumb,
                })
                    .then((res) => {
                        this.is_loading = false;

                        let response = res.data.data.blogs;
                        if (!response.error) {
                            Swal.fire("Success!", response.message, "success").then(() => {
                                this.$router.push({ name: "AdminBlogs" });
                            });
                        } else {
                            Swal.fire("Error!", response.message, "error");
                        }
                    })
                    .catch(() => {
                        this.is_loading = false;
                        Swal.fire("Error!", this.global_error_message, "error");
                    });
            }
        },
        onCheckRequiredFields() {
            let error_message = "Please enter page ";

            if (this.title == "") {
                this.title_error = error_message + "title";
                this.is_error = true;
            }

            if (this.meta_title == "") {
                this.meta_title_error = error_message + "meta title";
                this.is_error = true;
            }

            if (this.meta_keywords == "") {
                this.meta_keywords_error = error_message + "meta keywords";
                this.is_error = true;
            }

            if (this.meta_description == "") {
                this.meta_description_error = error_message + "meta description";
                this.is_error = true;
            }

            if (this.category == "") {
                this.category_error = "Please select category";
                this.is_error = true;
            }
        },
        onClearErrors() {
            this.is_error = false;
            this.title_error = "";

            this.meta_title_error = "";
            this.meta_keywords_error = "";
            this.meta_description_error = "";
            this.category_error = "";
        },
        onFileChanged() {
            this.onDisplayUploadedImage(event);
            this.selectedFile = event.target.files[0];
        },
        onFileChangedThumbnail() {
            this.onDisplayUploadedThumbnailImage(event);
            this.selectedFileThumb = event.target.files[0];
        },
        onDisplayUploadedImage(e) {
            const file = e.target.files[0];
            this.header_image = URL.createObjectURL(file);
            this.is_image = true;
        },
        onDisplayUploadedThumbnailImage(e) {
            const file = e.target.files[0];
            this.front_image = URL.createObjectURL(file);
            this.is_front = true;
        },

        onPopulateData() {
            this.is_loading = true;

            this.$admin_queries("blogs", {
                action_type: "display_by_id",
                blog_id: this.blogs_id,
            })
                .then((res) => {
                    this.is_loading = false;
                    console.log(res);
                    this.blogs = res.data.data.blogs[0];

                    this.title = this.blogs.title;
                    if (this.blogs.image != "") {
                        this.header_image = "/public/uploads/blogs/" + this.blogs.original_blogs_id + "/medium/" + this.blogs.image;
                        this.is_image = true;
                    }

                    if (this.blogs.thumbnail != "") {
                        this.front_image = "/public/uploads/blogs/thumbnail/" + this.blogs.original_blogs_id + "/medium/" + this.blogs.thumbnail;
                        this.is_front = true;
                    }

                    $("#summernote_blog").summernote("code", this.blogs.description);

                    if (this.blogs.meta) {
                        this.meta_title = this.blogs.meta && this.blogs.meta.title ? this.blogs.meta.title : "";
                        this.meta_keywords = this.blogs.meta && this.blogs.meta.keywords ? this.blogs.meta.keywords : "";

                        var tagify = new Tagify(this.tagifyInput);
                        tagify.addTags(this.meta_keywords);

                        this.meta_description = this.blogs.meta && this.blogs.meta.description ? this.blogs.meta.description : "";
                    }

                    this.blog_date = this.blogs.date;
                    this.category = this.blogs.category_id;
                    console.log("this.blogs: ", this.blogs);
                    this.slug = this.blogs.slug;
                    this.status = this.blogs.status;
                    // this.minutes_read = this.blogs.minutes_read;
                })
                .catch((err) => {
                    Swal.fire("Error!", this.global_error_message, "error");
                });
        },
    },
    watch: {
        is_edit: function (val) {
            if (val == true) {
                this.onPopulateData();
            }
        },
    },
};
</script>
