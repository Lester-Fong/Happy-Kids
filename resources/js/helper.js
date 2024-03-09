import Vue from "vue";
import moment from "moment";

Vue.mixin({
    data: function () {
        return {
            global_error_message: "Internal server error. We've notified our engineers and hope to address this issue shortly",
        };
    },
    methods: {
        onOTPForm() {
            const inputs = document.querySelectorAll(".opt-input");
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener("keydown", function (event) {
                    if (event.key === "Backspace") {
                        if (inputs[i].value == "") {
                            if (i != 0) {
                                inputs[i - 1].focus();
                            }
                        } else {
                            inputs[i].value = "";
                        }
                    } else if (event.key === "ArrowLeft" && i !== 0) {
                        inputs[i - 1].focus();
                    } else if (event.key === "ArrowRight" && i !== inputs.length - 1) {
                        inputs[i + 1].focus();
                    } else if (event.key != "ArrowLeft" && event.key != "ArrowRight") {
                        inputs[i].setAttribute("type", "text");
                        inputs[i].value = ""; // Bug Fix: allow user to change a random otp digit after pressing it
                        setTimeout(function () {
                            inputs[i].setAttribute("type", "password");
                        }, 1000); // Hides the text after 1.5 sec
                    }
                });
                inputs[i].addEventListener("input", function () {
                    inputs[i].value = inputs[i].value.toUpperCase(); // Converts to Upper case. Remove .toUpperCase() if conversion isnt required.
                    if (i === inputs.length && inputs[i].value !== "") {
                        // console.log(i);
                        inputs[i].closest("form");
                        inputs[i].closest("form").querySelector(".btn-optin-confirm").disabled = false;
                        return true;
                    } else if (inputs[i].value !== "" && i != inputs.length - 1) {
                        inputs[i + 1].focus();
                    }
                });

                // console.log(inputs.length);
            }
        },

        onDevelopmentStatus() {
            var development_status = process.env.DEVELOPMENT_STATUS;

            if (development_status == "local") {
                return "/local/";
            } else if (development_status == "development") {
                return "/development/";
            } else if (development_status == "sandbox") {
                return "/sandbox/";
            } else if (development_status == "production") {
                return "/";
            } else {
                return "/local/";
            }
        },

        onDatatable: function (name, is_add, lengthDisplay = 10, padding = "pb-2") {
            $(name).DataTable({
                autoWidth: !1,
                // responsive: true,
                order: [],
                stateSave: true,
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 },
                ],
                // lengthMenu: [
                // [25, 10, 50, -1],
                // [25, 10, 50, "All"],
                // [lengthDisplay],
                // [25, 10, 50, "All"],
                // ],
                // dom: `<"row justify-between ${padding}"<"col-12 mt-2"f>><"datatable-wrap mb-4 rounded-0 border-0"t><"row coche-table-pagination-footer"<"col-12"p>>`,
                // language: {
                //     search: "",
                //     searchPlaceholder: "Type in to Search",
                //     lengthMenu: "<span class='d-none d-sm-inline-block'>Show</span><div class=''> _MENU_ </div>",
                //     info: "_START_ -_END_ of _TOTAL_ Entries",
                //     infoEmpty: "No records found",
                //     infoFiltered: "( Total _MAX_  )",
                //     paginate: {
                //         first: "First",
                //         last: "Last",
                //         next: `<em class="icon ni ni-chevron-right"></em>`,
                //         previous: `<em class="icon ni ni-chevron-left"></em>`,
                //     },
                // },

                // cork ------------------------------->
                dom:
                    "<'dt--top-section '<'row'<'col-12 col-sm-6 align-items-center d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center align-items-center mt-sm-0 mt-3'f>>>" +
                    "<'gl-table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                oLanguage: {
                    oPaginate: {
                        sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
                    },
                    sInfo: "Showing page _PAGE_ of _PAGES_",
                    sSearch: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    sSearchPlaceholder: "Search...",
                    sLengthMenu: "Results :  _MENU_",
                },
                stripeClasses: [],
                lengthMenu: [7, 10, 20, 50],
                pageLength: 7,
            });

            if (is_add) {
                $(".dataTables_filter").append('<button type="button" class="btn button--primary ms-4 new_record fw-bold">New Record</button>');
                $(".dataTables_filter").addClass("filter-title-container").children("label").children("input").addClass("border border-dark fs_12");
                $(".new_record").on("click", this.onCreateRecord);
            } else {
                $(".dataTables_filter").addClass("filter-title-container").children("label").children("input").addClass("border border-dark fs_12");
            }
        },

        onSummerNote: (name) => {
            $(name).summernote({
                placeholder: "",
                fontNames: ["Arial", "Arial Black", "Comic Sans MS", "Courier New"],
                tabsize: 2,
                height: 300,
                disableDragAndDrop: true,
                toolbar: [
                    ["style", ["style"]],
                    ["font", ["bold", "underline", "clear", "size"]],
                    ["fontsize", ["fontsize"]],
                    ["fontname", ["fontname"]],
                    ["color", ["color"]],
                    ["para", ["ul", "ol", "paragraph", "height"]],
                    ["table", ["table"]],
                    ["insert", ["link", "picture"]],
                    ["view", ["codeview"]],
                ],
                popover: {
                    image: [
                        ["image", ["resizeFull", "resizeHalf", "resizeQuarter", "resizeNone"]],
                        ["float", ["floatLeft", "floatRight", "floatNone"]],
                        ["remove", ["removeMedia"]],
                    ],
                    link: [["link", ["linkDialogShow", "unlink"]]],
                    table: [
                        ["add", ["addRowDown", "addRowUp", "addColLeft", "addColRight"]],
                        ["delete", ["deleteRow", "deleteCol", "deleteTable"]],
                    ],
                    air: [
                        ["color", ["color"]],
                        ["font", ["bold", "underline", "clear"]],
                        ["para", ["ul", "paragraph"]],
                        ["table", ["table"]],
                        ["insert", ["link", "picture"]],
                    ],
                },
                //styleTags: ['http://servicio.local/public/assets_front/css/custom.css'],

                // callbacks: {
                //   onImageUpload: function (data) {
                //     data.pop();
                //   },
                // },
            });
        },

        formatFullname: function (first_name, last_name) {
            return first_name + " " + last_name;
        },

        truncate(str, maxlength) {
            return str.length > maxlength ? str.substring(0, maxlength) + "..." : str;
        },

        // format date_start 2023-12-10 16:00:00 & date_end 2023-12-10 20:00:00 into 9:00am 02:00pm
        onDisplayTimeSpan(date_start, date_end) {
            let start = moment(date_start, "YYYY-MM-DD HH:mm:ss").format("h:mma");
            let end = moment(date_end, "YYYY-MM-DD HH:mm:ss").format("h:mma");
            return start + " - " + end;
        },

        onGetInitials: (first, last) => {
            return first.charAt(0).toUpperCase() + last.charAt(0).toUpperCase();
        },
    },
});
