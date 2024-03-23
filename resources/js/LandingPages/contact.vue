<template>
  <div>
    <div class="loader-gif" v-if="is_loading"></div>
    <section class="page-header">
      <div class="page-header__bg" :style="`background-image: url('/public/uploads/pages/${pages.pages_id}/large/${pages.image}')`"></div>
      <!-- /.page-header__bg -->
      <div class="container">
        <h2>{{ pages?.title }}</h2>
        <ul class="thm-breadcrumb list-unstyled dynamic-radius">
          <li><router-link :to="{ name: 'HomePage' }">Home</router-link></li>
          <li>-</li>
          <li>
            <span>{{ pages?.title }}</span>
          </li>
        </ul>
        <!-- /.thm-breadcrumb list-unstyled -->
      </div>
      <!-- /.container -->
    </section>
    <!-- /.page-header -->

    <section class="contact-page pt-120 pb-80">
      <div class="container">
        <div class="row">
          <div class="col-lg-5">
            <div class="contact-page__content mb-40">
              <div class="block-title">
                <p><img src="/public/front/assets/images/shapes/heart-2-1.png" width="15" alt="" />{{ pages.description?.title }}</p>
                <h3>
                  {{ pages.description?.sub_title }}
                </h3>
              </div>
              <!-- /.block-title -->
              <p class="block-text mb-30 pr-10">{{ pages.description?.contact_description }}</p>
              <div class="footer-social black-hover">
                <!-- <a href="javascript:void(0)" aria-label="facebook"><i class="fab fa-facebook-square"></i></a> -->
                <!-- <a href="javascript:void(0)" aria-label="linkedin"><i class="fab fa-linkedin"></i></a> -->
                <!-- <a href="javascript:void(0)" aria-label="instagram"><i class="fab fa-instagram"></i></a> -->
              </div>
              <!-- /.footer-social -->
            </div>
            <!-- /.contact-page__content -->
          </div>
          <!-- /.col-lg-5 -->
          <div class="col-lg-7">
            <form @submit.prevent="onSubmit" class="contact-form-validated contact-page__form form-one mb-40">
              <div class="form-group">
                <div class="form-control">
                  <label for="name" class="sr-only">Name</label>
                  <input type="text" v-model="name" id="name" placeholder="Your Name" />
                  <small class="text-danger d-block">{{ name_error }}</small>
                </div>
                <!-- /.form-control -->
                <div class="form-control">
                  <label for="email" class="sr-only">email</label>
                  <input type="text" v-model="email" id="email" placeholder="Email Address" />
                  <small class="text-danger d-block">{{ email_error }}</small>
                </div>
                <!-- /.form-control -->
                <div class="form-control">
                  <label for="phone" class="sr-only">phone</label>
                  <input type="text" v-model="phone" id="phone" placeholder="Phone Number" />
                  <small class="text-danger d-block">{{ phone_error }}</small>
                </div>
                <!-- /.form-control -->
                <div class="form-control">
                  <label for="subject" class="sr-only">subject</label>
                  <input type="text" v-model="subject" id="subject" placeholder="Subject" />
                  <small class="text-danger d-block">{{ subject_error }}</small>
                </div>
                <!-- /.form-control -->
                <div class="form-control form-control-full">
                  <label for="message" class="sr-only">message</label>
                  <textarea v-model="message" placeholder="Write a Message" id="message"></textarea>
                  <small class="text-danger d-block">{{ message_error }}</small>
                </div>
                <!-- /.form-control -->
                <div class="form-control form-control-full mt-4">
                  <button type="submit" class="thm-btn dynamic-radius">Submit Message</button>
                  <!-- /.thm-btn dynamic-radius -->
                </div>
                <!-- /.form-control -->
              </div>
              <!-- /.form-group -->
            </form>
            <!-- /.contact-page__form -->
            <div class="result"></div>
            <!-- /.result -->
          </div>
          <!-- /.col-lg-7 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
    </section>
    <!-- /.contact-page -->

    <div class="google-map__contact">
      <iframe title="template google map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3865.52394025598!2d121.08277597507755!3d14.339062986116863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d9fb7cc36f43%3A0x8b917e497bdafc50!2sTrimex%20Colleges!5e0!3m2!1sen!2sph!4v1701584053000!5m2!1sen!2sph" class="map__contact" allowfullscreen></iframe>
    </div>
    <!-- /.google-map -->
  </div>
</template>


<script>
export default {
  data() {
    return {
      is_loading: false,
      pages: [],
      name: "",
      email: "",
      phone: "",
      subject: "",
      message: "",

      // error
      name_error: "",
      email_error: "",
      phone_error: "",
      subject_error: "",
      message_error: "",
    };
  },

  created() {
    this.onPopulateData();
  },

  methods: {
    onPopulateData() {
      this.is_loading = true;

      this.$front_queries("front_page_data", {
        action_type: "display_contact_page",
      })
        .then((res) => {
          this.is_loading = false;
          let response = res.data.data.front;
          this.pages = response.pages;
        })
        .catch((err) => {
          console.error("error:" + err);
        });
    },

    isFieldsValid() {
      let is_valid = true;

      if (this.name == "") {
        this.name_error = "Name is required";
        is_valid = false;
      } else {
        this.name_error = "";
      }

      if (this.email == "") {
        this.email_error = "Email is required";
        is_valid = false;
      } else {
        this.email_error = "";
      }

      if (this.phone == "") {
        this.phone_error = "Phone is required";
        is_valid = false;
      } else {
        this.phone_error = "";
      }

      if (this.subject == "") {
        this.subject_error = "Subject is required";
        is_valid = false;
      } else {
        this.subject_error = "";
      }

      if (this.message == "") {
        this.message_error = "Message is required";
        is_valid = false;
      } else {
        this.message_error = "";
      }

      return is_valid;
    },

    onClearFields() {
      this.name = "";
      this.email = "";
      this.phone = "";
      this.subject = "";
      this.message = "";
    },

    onSubmit() {
      if (this.isFieldsValid()) {
        this.is_loading = true;

        this.$front_queries("send_email", {
          front: {
            name: this.name,
            email: this.email,
            phone: this.phone,
            subject: this.subject,
            message: this.message,
            action_type: "send_email",
          },
        })
          .then((res) => {
            this.is_loading = false;
            let response = res.data.data.front;
            console.log("response", response);
            if (response.error) {
              Swal.fire("Error!", this.global_error_message, "error");
              return;
            }
            Swal.fire("Success!", response.message, "success");
            // this.onClearFields();
          })
          .catch((err) => {
            console.error("error:" + err);
          });
      }
    },
  },
};
</script>