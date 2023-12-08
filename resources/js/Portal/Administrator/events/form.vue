<template>
    <div>
        <div v-if="is_loading" class="loader-gif"></div>
        <div class="modal fade show" tabindex="-1" id="events_modal" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content bg-light">
                    <!-- HEADER -->
                    <div class="modal-header">
                        <h6 class="text-center">Events</h6>
                    </div>
                    <form @submit.prevent="onSubmit">
                        <!-- BODY -->
                        <div class="modal-body">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <label for="name" class="small-font">Title</label>
                                        <span class="text-warning">*</span>

                                        <input v-model="title" type="text" class="form-control form-control-sm" id="name" />
                                        <span class="text-warning mb-0">{{ title_error }}</span>
                                    </div>

                                    <div class="col-sm-6 mb-2">
                                        <div class="form-group">
                                            <label class="form-label">Date Start</label>
                                            <div class="form-control-wrap">
                                                <date-picker v-model="date_start" type="datetime" placeholder="Select datetime" format="MMM-DD-YYYY HH:mm:ss a" value-type="YYYY-MM-DD HH:mm:ss" :disabled-date="dateBeforeToday"></date-picker>
                                                <p class="text-warning mb-0">{{ date_start_error }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <div class="form-group">
                                            <label class="form-label">Date End</label>
                                            <div class="form-control-wrap">
                                                <date-picker v-model="date_end" type="datetime" placeholder="Select datetime" format="YYYY-MM-DD HH:mm:ss a" :disabled-date="disabledBeforeTimeStart" value-type="YYYY-MM-DD HH:mm:ss"></date-picker>
                                                <p class="text-warning mb-0">{{ date_end_error }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <div class="form-group">
                                            <label class="form-label">Location</label>
                                            <div class="form-control-wrap">
                                                <input v-model="location" type="text" class="form-control form-control-sm" id="location" />
                                                <span class="text-warning mb-0">{{ location_error }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-2">
                                        <div class="form-group">
                                            <label class="form-label" for="default-06"> Image</label>
                                            <div class="form-control-wrap">
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input" id="customFile" @change="onFileChanged" placeholder="Choose File" />
                                                    <!-- <label class="form-file-label" for="customFile">{{ selectedFile }}</label> -->
                                                </div>
                                            </div>
                                            <img class="mt-2" :src="events_image" alt="" v-if="is_image" width="100" />
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-2">
                                        <div class="form-group">
                                            <label class="form-label">Status</label>
                                            <div class="form-control-wrap">
                                                <div class="custom-control custom-control-sm custom-radio">
                                                    <input type="radio" id="customRadio7" class="custom-control-input" v-model="status" value="1" />
                                                    <label class="custom-control-label" for="customRadio7">Active</label>
                                                </div>
                                                <div class="custom-control custom-control-sm custom-radio">
                                                    <input type="radio" id="customRadio8" class="custom-control-input" v-model="status" value="0" />
                                                    <label class="custom-control-label" for="customRadio8">Inactive</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer border-0 pt-0">
                                <div class="d-flex align-items-center">
                                    <a @click="onHideModal" href="javaScript:void(0)" class="me-2">Cancel</a>

                                    <button type="submit" class="btn button--primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";

export default {
    props: ["is_edit", "selected_events"],

    components: { DatePicker },

    data() {
        return {
            is_loading: false,
            is_error: false,
            events_id: "",
            title: "",
            title_error: "",
            date_start: "",
            date_start_error: "",
            date_end: "",
            date_end_error: "",
            location: "",
            location_error: "",
            events_image: "",
            selectedFile: "",
            is_image: false,
            status: "",
            status_error: "",
        };
    },

    methods: {
        onSubmit() {
            this.onClearErrors();
            this.onCheckRequiredFields();
            if (this.is_error == false) {
                this.is_loading = true;

                this.$admin_queries("save_events", {
                    events: {
                        title: this.title,
                        date_start: this.date_start,
                        date_end: this.date_end,
                        location: this.location,
                        events_id: this.events_id,
                        status: this.status,
                        action_type: this.is_edit ? "update_record" : "new_record",
                    },
                    file: this.selectedFile,
                })
                    .then((res) => {
                        this.is_loading = false;

                        let response = res.data.data.events;
                        if (!response.error) {
                            this.onClearFields();
                            this.onClearErrors();
                            Swal.fire("Success!", response.message, "success").then(() => {
                                this.$emit("success");
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

        onFileChanged() {
            this.onDisplayUploadedImage(event);
            this.selectedFile = event.target.files[0];
        },

        onDisplayUploadedImage(e) {
            const file = e.target.files[0];
            this.events_image = URL.createObjectURL(file);
            this.is_image = true;
        },

        onClearErrors() {
            this.title_error = "";
            this.date_start_error = "";
            this.date_end_error = "";
            this.location_error = "";
            this.status_error = "";
        },

        onClearFields() {
            this.title = "";
            this.date_start = "";
            this.date_end = "";
            this.location = "";
            this.events_image = "";
            this.selectedFile = "";
            this.is_image = false;
            this.status = "";
        },

        onCheckRequiredFields() {
            let error_message = "Please enter page ";

            if (this.title == "") {
                this.title_error = error_message + "title.";
                this.is_error = true;
            }

            if (this.date_start == "") {
                this.date_start_error = error_message + "date start.";
                this.is_error = true;
            }

            if (this.date_end == "") {
                this.date_end_error = error_message + "date end.";
                this.is_error = true;
            }

            if (this.location == "") {
                this.location_error = error_message + "location.";
                this.is_error = true;
            }

            if (this.status == "") {
                this.status_error = error_message + "status.";
                this.is_error = true;
            }
        },

        onHideModal() {
            this.$emit("onHideModal");
            this.onClearFields();
            this.onClearErrors();
        },

        dateBeforeToday(date) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            return date < today;
        },

        disabledBeforeTimeStart(date) {
            const today = new Date(this.date_start);
            const yesterday = new Date();
            yesterday.setDate(today.getDate() - 1);

            return date <= yesterday;
        },
    },

    watch: {
        is_edit(val) {
            if (val) {
                this.events_id = this.selected_events.events_id;
                this.title = this.selected_events.title;
                this.date_start = this.selected_events.date_start;
                this.date_end = this.selected_events.date_end;
                this.location = this.selected_events.location;
                this.events_image = this.selected_events.events_image;
                this.status = this.selected_events.status == true ? "1" : "0";
                if (this.selected_events.image != "") {
                    this.events_image = "/public/uploads/events/" + this.selected_events.original_events_id + "/medium/" + this.selected_events.image;
                    this.is_image = true;
                }
            }
        },
    },
};
</script>
