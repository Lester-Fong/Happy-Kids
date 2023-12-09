<template>
    <div>
        <div class="loader-gif" v-if="is_loading"></div>
        <h1>Events Page</h1>

        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <table id="events_table" class="table table-striped dt-table-hover" style="width: 100%">
                        <thead class="mb-4">
                            <tr>
                                <th>Title</th>
                                <th>Date (Start - End)</th>
                                <th>Time (Start - End)</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Expired</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="a in events" :key="a.id">
                                <td>
                                    {{ a.title }}
                                </td>
                                <td>
                                    <span>{{ a.date_start | formatTransDateWithTime }}</span>
                                    -
                                    <span>{{ a.date_end | formatTransDateWithTime }}</span>
                                </td>
                                <td>{{ onDisplayTimeSpan(a.date_start, a.date_end) }}</td>
                                <td>{{ a.location }}</td>
                                <td>
                                    <span class="badge" :class="badgeClass(a.status)">{{ badgeText(a.status) }}</span>
                                </td>
                                <td>
                                    <span class="badge" :class="doneClass(a.is_expired)">{{ doneText(a.is_expired) }}</span>
                                </td>
                                <td class="text-center dropdown">
                                    <a class="dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                        <a @click="onEditEvents(a)" class="dropdown-item" href="javascript:void(0);">Edit</a>
                                        <a @click="onDeleteEvents(a)" class="dropdown-item" href="javascript:void(0);">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <events-form @onHideModal="onHideModal" @success="onSuccess" :is_edit="is_edit" :selected_events="selected_events" />
    </div>
</template>

<script>
import EventsForm from "./events/form.vue";

export default {
    metaInfo: {
        title: "Admin - Events",
    },

    components: {
        EventsForm,
    },

    data() {
        return {
            is_loading: false,
            filteredEvents: [],
            events: [],
            is_edit: false,
            selected_events: {},
        };
    },

    created() {
        this.onCheckAndSetExpired();
    },

    mounted() {
        this.onPopulateData();
    },

    methods: {
        onPopulateData() {
            this.is_loading = true;
            this.$admin_queries("events", {
                action_type: "display_all",
            })
                .then((res) => {
                    this.is_loading = false;
                    this.filteredEvents = res.data.data.events;
                })
                .catch(() => {
                    this.is_loading = false;
                    Swal.fire("Error!", this.global_error_message, "error");
                });
        },

        onCheckAndSetExpired() {
            this.$admin_queries("events", {
                action_type: "check_and_set_expired",
            })
                .then((res) => {
                    let response = res.data.data.events;
                })
                .catch(() => {
                    Swal.fire("Error!", this.global_error_message, "error");
                });
        },

        onCreateRecord() {
            this.is_edit = false;
            $("#events_modal").modal("show");
        },

        onEditEvents(data) {
            this.is_edit = true;
            this.selected_events = data;
            $("#events_modal").modal("show");
        },

        onDeleteEvents(events) {
            Swal.fire({
                title: "Are you sure?",
                html: "You want to delete this record?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it",
                allowOutsideClick: false,
                allowEscapeKey: false,
            }).then((res) => {
                if (res.isConfirmed == true) {
                    this.is_loading = true;
                    this.$admin_queries("save_events", {
                        events: {
                            events_id: events.events_id,
                            action_type: "delete_record",
                        },
                    })
                        .then((res) => {
                            this.is_loading = false;

                            let response = res.data.data.events;

                            if (response.error == false) {
                                Swal.fire("Success!", response.message, "success");
                                this.onPopulateData();
                            } else {
                                Swal.fire("Error!", response.message, "error");
                            }
                        })
                        .catch(() => {
                            this.is_loading = false;
                            Swal.fire("Error!", this.global_error_message, "error");
                        });
                }
            });
        },

        badgeClass(status) {
            if (status == true) {
                return "badge-success";
            } else {
                return "badge-danger";
            }
        },

        badgeText(status) {
            if (status == true) {
                return "Active";
            } else {
                return "Inactive";
            }
        },

        onHideModal() {
            this.is_edit = false;
            $("#events_modal").modal("hide");
        },

        onSuccess() {
            this.is_edit = false;
            $("#events_modal").modal("hide");
            this.onPopulateData();
        },

        doneClass(is_expired) {
            if (is_expired == true) {
                return "badge-success";
            } else {
                return "badge-danger";
            }
        },

        doneText(is_expired) {
            if (is_expired == true) {
                return "Expired";
            } else {
                return "Not Yet";
            }
        },
    },

    watch: {
        events() {
            this.$nextTick(() => {
                this.datatable = this.onDatatable("#events_table", true);
            });
        },

        filteredEvents: function (value) {
            $("#events_table").DataTable().destroy();
            this.events = this.filteredEvents;
        },
    },
};
</script>
