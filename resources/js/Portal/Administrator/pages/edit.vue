<template>
  <div>
    <div class="loader-gif" v-if="is_calling_api"></div>

    <h1>Create Page</h1>
    <div class="card card-bordered card-preview container px-4 py-2">
      <div class="card-inner">
        <div class="preview-block">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="pageTitle">Select Page</label>
                <select type="text" disabled class="form-control text-dark" v-model="title" id="pageTitle">
                  <option selected default hidden value="">Choose One</option>
                  <option v-for="(option, i) in options" :key="i" :value="option.name">{{ option.name }}</option>
                </select>
                <div class="text-danger">{{ title_error }}</div>
              </div>
            </div>
          </div>

          <ul class="nav nav-tabs my-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" data-bs-toggle="tab" href="#header">Header</a>
            </li>
            <!--------------- HOMEPAGE NAVS ------------->
            <li class="nav-item" role="presentation" v-if="title == 'Homepage'">
              <a class="nav-link" data-bs-toggle="tab" href="#objectives">Objectives</a>
            </li>
            <li class="nav-item" role="presentation" v-if="title == 'Homepage'">
              <a class="nav-link" data-bs-toggle="tab" href="#about">About</a>
            </li>
            <li class="nav-item" role="presentation" v-if="title == 'Homepage'">
              <a class="nav-link" data-bs-toggle="tab" href="#video">Video</a>
            </li>
            <li class="nav-item" role="presentation" v-if="title == 'Homepage'">
              <a class="nav-link" data-bs-toggle="tab" href="#faq">FAQ</a>
            </li>
            <li class="nav-item" role="presentation" v-if="title == 'Homepage'">
              <a class="nav-link" data-bs-toggle="tab" href="#testimonials">Testimonials</a>
            </li>
            <li class="nav-item" role="presentation" v-if="title == 'Homepage'">
              <a class="nav-link" data-bs-toggle="tab" href="#donate">Donate</a>
            </li>
            <li class="nav-item" role="presentation" v-if="title == 'Homepage'">
              <a class="nav-link" data-bs-toggle="tab" href="#latestEvents">Latest Events</a>
            </li>

            <!--------------- OUR MISSION NAVS ------------->
            <li class="nav-item" role="presentation" v-if="title == 'Our Mission'">
              <a class="nav-link" data-bs-toggle="tab" href="#missionIntro">Page Intro</a>
            </li>
            <li class="nav-item" role="presentation" v-if="title == 'Our Mission'">
              <a class="nav-link" data-bs-toggle="tab" href="#checklist">Checklist</a>
            </li>
            <li class="nav-item" role="presentation" v-if="title == 'Our Mission'">
              <a class="nav-link" data-bs-toggle="tab" href="#volunteers">Volunteers</a>
            </li>
            <li class="nav-item" role="presentation" v-if="title == 'Our Mission'">
              <a class="nav-link" data-bs-toggle="tab" href="#video">Video</a>
            </li>

            <!--------------- PROGRAM NAVS ------------->
            <li class="nav-item" role="presentation" v-if="title == 'Feeding Program' || title == 'Scholarship Program'">
              <a class="nav-link" data-bs-toggle="tab" href="#feedIntro">Page Intro</a>
            </li>
            <li class="nav-item" role="presentation" v-if="title == 'Feeding Program' || title == 'Scholarship Program'">
              <a class="nav-link" data-bs-toggle="tab" href="#feedAbout">About Program</a>
            </li>
            <li class="nav-item" role="presentation" v-if="title == 'Feeding Program' || title == 'Scholarship Program'">
              <a class="nav-link" data-bs-toggle="tab" href="#feedOverview">Program Overview</a>
            </li>

            <li class="nav-item" role="presentation">
              <a class="nav-link" data-bs-toggle="tab" href="#meta">Meta Information</a>
            </li>
          </ul>

          <!-------------------------- TAB SECTIONS/CONTENTS ---------------------------->
          <div class="tab-content">
            <!------------------- HEADER ------------------>
            <div class="tab-pane active" id="header">
              <div class="row">
                <div class="col-sm-6 my-3" v-if="title !== 'Our Mission'">
                  <div class="form-group">
                    <label for="exampleFormControlInput2">Header</label>
                    <input type="text" class="form-control" v-model="header" id="exampleFormControlInput2" />
                    <div class="text-danger">{{ header_error }}</div>
                  </div>
                </div>

                <div class="col-sm-6 my-3" v-if="title !== 'Our Mission'">
                  <div class="form-group">
                    <label for="exampleFormControlInput3">Sub Header</label>
                    <input type="text" class="form-control" v-model="sub_header" id="exampleFormControlInput3" />
                    <div class="text-danger">{{ sub_header_error }}</div>
                  </div>
                </div>

                <div class="col-sm-6 my-3" v-if="title == 'Contact Us'">
                  <div class="form-group">
                    <label for="exampleFormControlInput30">Description</label>
                    <textarea class="form-control" v-model="contact_description" id="exampleFormControlInput30"></textarea>
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="col-form-label" for="formFile1">Background</label>
                    <div class="input-group mb-3">
                      <div class="custom-file">
                        <input class="form-control file-upload-input" @change="onFileChanged($event)" type="file" id="formFile1" />
                      </div>
                    </div>
                    <img class="mb-2" :src="background_image" alt="" v-if="is_background" width="100" />
                  </div>
                </div>
                <div class="col-sm-4" v-if="title == 'Homepage' || title == 'Our Mission'">
                  <div class="form-group">
                    <label class="col-form-label" for="formFile2">Image 1</label>
                    <div class="input-group mb-3">
                      <div class="custom-file">
                        <input class="form-control file-upload-input" @change="onFile2Changed($event)" type="file" id="formFile2" />
                      </div>
                    </div>
                    <img class="mb-2" :src="background_image_2" alt="" v-if="is_background_2" width="100" />
                  </div>
                </div>
                <div class="col-sm-4" v-if="title == 'Homepage' || title == 'Our Mission'">
                  <div class="form-group">
                    <label class="col-form-label" for="formFile3">Image 2</label>
                    <div class="input-group mb-3">
                      <div class="custom-file">
                        <input class="form-control file-upload-input" @change="onFile3Changed($event)" type="file" id="formFile3" />
                      </div>
                    </div>
                    <img class="mb-2" :src="background_image_3" alt="" v-if="is_background_3" width="100" />
                  </div>
                </div>
              </div>
            </div>

            <!------------------- OBJECTIVES ------------------>
            <div class="tab-pane" id="objectives" v-if="title == 'Homepage'">
              <div class="d-flex flex-wrap justify-content-between align-items-start">
                <div class="row w-50 my-2 rounded bg-light" v-for="index in 3" :key="index">
                  <div class="col-sm-6 my-3">
                    <div class="form-group">
                      <label for="sample1">Description</label>
                      <input type="text" class="form-control" v-model="objective_desc[index - 1]" id="sample1" />
                    </div>
                  </div>

                  <div class="col-sm-6 my-3">
                    <div class="form-group">
                      <label for="sample2">Sub description</label>
                      <input type="text" class="form-control" v-model="objective_sub_desc[index - 1]" id="sample2" />
                    </div>
                  </div>

                  <div class="col-sm-12">
                    <div class="form-group">
                      <label class="col-form-label" for="formFile1">Background</label>
                      <div class="input-group mb-3">
                        <div class="custom-file">
                          <input class="form-control file-upload-input" @change="onFileChangedObjectives($event, index - 1)" type="file" :id="`formFile${index}`" />
                        </div>
                      </div>
                      <img class="mb-2" :src="objective_background_image_1" alt="" v-if="is_objective_background_image_1 && index == 1" width="100" />
                      <img class="mt-2" :src="objective_background_image_2" alt="" v-if="is_objective_background_image_2 && index == 2" width="100" />
                      <img class="mt-2" :src="objective_background_image_3" alt="" v-if="is_objective_background_image_3 && index == 3" width="100" />
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!------------------- ABOUT ------------------>
            <div class="tab-pane" id="about" v-if="title == 'Homepage'">
              <div class="row">
                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput9">Title</label>
                    <input type="text" class="form-control" v-model="about.title" id="exampleFormControlInput9" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput10">Sub Title</label>
                    <input type="text" class="form-control" v-model="about.subtitle" id="exampleFormControlInput10" />
                  </div>
                </div>

                <hr class="mt-3" />
                <div class="col-6 row mx-auto" v-for="index in 2" :key="index">
                  <div class="col-sm-12 my-3">
                    <div class="form-group">
                      <label for="exampleFormControlInput2">List Item {{ index }}</label>
                      <input type="text" class="form-control" v-model="about_title[index - 1]" id="exampleFormControlInput4" />
                    </div>
                  </div>

                  <div class="col-sm-12 my-3">
                    <div class="form-group">
                      <label for="exampleFormControlInput3">Description {{ index }}</label>
                      <textarea type="text" class="form-control" v-model="about_description[index - 1]" id="exampleFormControlInput0"></textarea>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="col-form-label" for="formFile1">Background</label>
                    <div class="input-group mb-3">
                      <div class="custom-file">
                        <input class="form-control file-upload-input" @change="onFile4Changed($event)" type="file" id="formFile1" />
                      </div>
                    </div>
                    <img class="mb-2" :src="about_background_image" alt="" v-if="is_about_background_image" width="100" />
                  </div>
                </div>
              </div>
            </div>

            <!------------------- VIDEO ------------------>
            <div class="tab-pane" id="video" v-if="title == 'Homepage' || title == 'Our Mission'">
              <div class="row">
                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput6">Title</label>
                    <input type="text" class="form-control" v-model="video.title" id="exampleFormControlInput6" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput7">Sub Title</label>
                    <input type="text" class="form-control" v-model="video.subtitle" id="exampleFormControlInput7" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="link">Video Link</label>
                    <input type="text" class="form-control" v-model="video.link" id="link" />
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="col-form-label" for="firmfile2">Background</label>
                    <div class="input-group mb-3">
                      <div class="custom-file">
                        <input class="form-control file-upload-input" @change="onFile5Changed($event)" type="file" id="firmfile2" />
                      </div>
                    </div>
                    <img class="mb-2" :src="video_background_image" alt="" v-if="is_video_background_image" width="100" />
                  </div>
                </div>
              </div>
            </div>

            <!------------------- FAQs ------------------>
            <div class="tab-pane" id="faq" v-if="title == 'Homepage'">
              <div class="row">
                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput9">Title</label>
                    <input type="text" class="form-control" v-model="faq.title" id="exampleFormControlInput9" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput10">Sub Title</label>
                    <input type="text" class="form-control" v-model="faq.subtitle" id="exampleFormControlInput10" />
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="col-form-label" for="faqfile">Right Panel Image</label>
                    <div class="input-group mb-3">
                      <div class="custom-file">
                        <input class="form-control file-upload-input" @change="onFile6Changed($event)" type="file" id="faqfile" />
                      </div>
                    </div>
                    <img class="mb-2" :src="faq_background_image" alt="" v-if="is_faq_background_image" width="100" />
                  </div>
                </div>
              </div>
            </div>

            <!------------------- TESTIMONIALS ------------------>
            <div class="tab-pane" id="testimonials" v-if="title == 'Homepage'">
              <div class="row">
                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput90">Title</label>
                    <input type="text" class="form-control" v-model="testimonial.title" id="exampleFormControlInput90" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput101">Sub Title</label>
                    <input type="text" class="form-control" v-model="testimonial.subtitle" id="exampleFormControlInput101" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput102">Description</label>
                    <input type="text" class="form-control" v-model="testimonial.description" id="exampleFormControlInput102" />
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="col-form-label" for="testimonialFile">Background Image</label>
                    <div class="input-group mb-3">
                      <div class="custom-file">
                        <input class="form-control file-upload-input" @change="onFile7Changed($event)" type="file" id="testimonialFile" />
                      </div>
                    </div>
                    <img class="mb-2" :src="testimonial_background_image" alt="" v-if="is_testimonial_background_image" width="100" />
                  </div>
                </div>
              </div>
            </div>

            <!------------------- DONATION ------------------>
            <div class="tab-pane" id="donate" v-if="title == 'Homepage'">
              <div class="row">
                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput901">Title</label>
                    <input type="text" class="form-control" v-model="donate.title" id="exampleFormControlInput901" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput1012">Sub Title</label>
                    <input type="text" class="form-control" v-model="donate.subtitle" id="exampleFormControlInput1012" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput1022">Description</label>
                    <input type="text" class="form-control" v-model="donate.description" id="exampleFormControlInput1022" />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="donatepurposetitle">Purpose Title</label>
                    <input type="text" class="form-control" v-model="donate.purpose_title" id="donatepurposetitle" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="donatepurposedesc">Purpose Description</label>
                    <input type="text" class="form-control" v-model="donate.purpose_description" id="donatepurposedesc" />
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="col-form-label" for="donateFile">Background Image</label>
                    <div class="input-group mb-3">
                      <div class="custom-file">
                        <input class="form-control file-upload-input" @change="onFile8Changed($event)" type="file" id="donateFile" />
                      </div>
                    </div>
                    <img class="mb-2" :src="donate_background_image" alt="" v-if="is_donate_background_image" width="100" />
                  </div>
                </div>
              </div>
            </div>

            <!------------------- LATEST EVENTS ------------------>
            <div class="tab-pane" id="latestEvents" v-if="title == 'Homepage'">
              <div class="row">
                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput901">Title</label>
                    <input type="text" class="form-control" v-model="events.title" id="exampleFormControlInput901" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput1014">Sub Title</label>
                    <input type="text" class="form-control" v-model="events.subtitle" id="exampleFormControlInput1014" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="0testsample">Description</label>
                    <input type="text" class="form-control" v-model="events.description" id="0testsample" />
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="col-form-label" for="eventsfile">Background Image</label>
                    <div class="input-group mb-3">
                      <div class="custom-file">
                        <input class="form-control file-upload-input" @change="onFile9Changed($event)" type="file" id="eventsfile" />
                      </div>
                    </div>
                    <img class="mb-2" :src="events_background_image" alt="" v-if="is_events_background_image" width="100" />
                  </div>
                </div>
              </div>
            </div>

            <!------------------- MISSION INTRO ------------------>
            <div class="tab-pane" id="missionIntro" v-if="title == 'Our Mission'">
              <div class="row">
                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput9012">Section Title</label>
                    <input type="text" class="form-control" v-model="mission_intro.section_title" id="exampleFormControlInput9012" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput1012">Title</label>
                    <input type="text" class="form-control" v-model="mission_intro.title" id="exampleFormControlInput1012" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput10122">Description</label>
                    <input type="text" class="form-control" v-model="mission_intro.description" id="exampleFormControlInput10122" />
                  </div>
                </div>
              </div>
            </div>

            <!------------------- CHECKLIST ------------------>
            <div class="tab-pane" id="checklist" v-if="title == 'Our Mission'">
              <div class="row">
                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput912">Title</label>
                    <input type="text" class="form-control" v-model="checklist.title" id="exampleFormControlInput912" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput1044">Sub Title</label>
                    <input type="text" class="form-control" v-model="checklist.subtitle" id="exampleFormControlInput1044" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput10151">Description</label>
                    <input type="text" class="form-control" v-model="checklist.description" id="exampleFormControlInput10151" />
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="col-form-label" for="checklistfile">Right Panel Image</label>
                    <div class="input-group mb-3">
                      <div class="custom-file">
                        <input class="form-control file-upload-input" @change="onFile10Changed($event)" type="file" id="checklistfile" />
                      </div>
                    </div>
                    <img class="mb-2" :src="checklist_background_image" alt="" v-if="is_checklist_background_image" width="100" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput104">Short Text</label>
                    <input type="text" class="form-control" placeholder="Short text here. Ex: Quotes" v-model="checklist.short_text" id="exampleFormControlInput104" />
                  </div>
                </div>
                <div class="col-sm-6 my-3"></div>
                <div class="col-sm-4 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput102">Checklist 1</label>
                    <input type="text" class="form-control" v-model="checklist.checklist1" id="exampleFormControlInput102" />
                  </div>
                </div>
                <div class="col-sm-4 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput103">Checklist 2</label>
                    <input type="text" class="form-control" v-model="checklist.checklist2" id="exampleFormControlInput103" />
                  </div>
                </div>
                <div class="col-sm-4 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput104">Checklist 3</label>
                    <input type="text" class="form-control" v-model="checklist.checklist3" id="exampleFormControlInput104" />
                  </div>
                </div>
              </div>
            </div>

            <!------------------- VOLUNTEERS ------------------>
            <div class="tab-pane" id="volunteers" v-if="title == 'Our Mission'">
              <div class="row">
                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput9091">Title</label>
                    <input type="text" class="form-control" v-model="volunteers.title" id="exampleFormControlInput9091" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput1019">Sub Title</label>
                    <input type="text" class="form-control" v-model="volunteers.subtitle" id="exampleFormControlInput1019" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput1027">Description</label>
                    <input type="text" class="form-control" v-model="volunteers.description" id="exampleFormControlInput1027" />
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="col-form-label" for="volunteersFile">Background Image</label>
                    <div class="input-group mb-3">
                      <div class="custom-file">
                        <input class="form-control file-upload-input" @change="onFile11Changed($event)" type="file" id="volunteersFile" />
                      </div>
                    </div>
                    <img class="mb-2" :src="volunteers_background_image" alt="" v-if="is_volunteers_background_image" width="100" />
                  </div>
                </div>
              </div>
            </div>

            <!------------------- FEEDING PROGRAM INTRO ------------------>
            <div class="tab-pane" id="feedIntro" v-if="title == 'Feeding Program' || title == 'Scholarship Program'">
              <div class="row">
                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput9">Title</label>
                    <input type="text" class="form-control" v-model="program.title" id="exampleFormControlInput9" />
                  </div>
                </div>

                <div class="col-sm-6 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput10">Description</label>
                    <textarea class="form-control" v-model="program.subtitle" id="exampleFormControlInput10"></textarea>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="col-form-label" for="feedingfile">Right Panel Image</label>
                    <div class="input-group mb-3">
                      <div class="custom-file">
                        <input class="form-control file-upload-input" @change="onFile12Changed($event)" type="file" id="feedingfile" />
                      </div>
                    </div>
                    <img class="mb-2" :src="feeding_background_image" alt="" v-if="is_feeding_background_image" width="100" />
                  </div>
                </div>
              </div>
            </div>

            <!------------------- FEEDING PROGRAM INTRO ------------------>
            <div class="tab-pane" id="feedAbout" v-if="title == 'Feeding Program' || title == 'Scholarship Program'">
              <div class="row">
                <div class="col-sm-12 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput99">About Title</label>
                    <input type="text" class="form-control" v-model="program.program_title" id="exampleFormControlInput99" />
                  </div>
                </div>

                <div class="col-sm-12 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput190">About Description</label>
                    <textarea class="form-control" v-model="program.program_description" id="exampleFormControlInput190"></textarea>
                  </div>
                </div>
              </div>
            </div>

            <!------------------- PROGRAM OVERVIEW INTRO ------------------>
            <div class="tab-pane" id="feedOverview" v-if="title == 'Feeding Program' || title == 'Scholarship Program'">
              <div class="row">
                <div class="col-sm-12 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput929">Overview Title</label>
                    <input type="text" class="form-control" v-model="program.overview_title" id="exampleFormControlInput992" />
                  </div>
                </div>

                <div class="col-sm-12 my-3">
                  <div class="form-group">
                    <label for="exampleFormControlInput197">Overview Description</label>
                    <textarea class="form-control" v-model="program.overview_description" id="exampleFormControlInput197"></textarea>
                  </div>
                </div>
              </div>
            </div>

            <!------------------- META ------------------>
            <div class="tab-pane" id="meta">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="col-form-label" for="default-textarea">Title</label>
                    <textarea class="form-control no-resize servicio-textfield" id="default-textarea" v-model="meta_title"></textarea>
                    <div class="text-danger">{{ meta_title_error }}</div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="col-form-label" for="default-textarea">Description</label>
                    <textarea class="form-control no-resize servicio-textfield" id="default-textarea" v-model="meta_description"></textarea>
                    <div class="text-danger">{{ meta_description_error }}</div>
                  </div>
                </div>

                <div class="col-sm-6 mt-2">
                  <label class="col-form-label" for="default-textarea">Keywords</label>
                  <div class="form-group">
                    <textarea class="form-control no-resize servicio-textfield" id="default-textarea" v-model="meta_keywords"></textarea>
                    <div class="text-danger">{{ meta_keywords_error }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="button" name="button" class="btn btn-primary ms-auto mx-1 fw-bold" @click="onSave">Save</button>
        <button type="button" name="button" class="btn btn-secondary mx-1 fw-bold" @click="onCancel">Cancel</button>
      </div>
    </div>
  </div>
</template>
    
  <script>
import homepageVue from "../../../LandingPages/homepage.vue";
export default {
  metaInfo: {
    title: "Admin - Pages - New",
  },
  data() {
    return {
      title: "",
      slug: this.$route.params.slug,
      header: "",
      sub_header: "",
      meta_title: "",
      meta_keywords: "",
      meta_description: "",
      selected_page: "",

      title_error: "",
      slug_error: "",
      header_error: "",
      sub_header_error: "",
      meta_title_error: "",
      meta_keywords_error: "",
      meta_description_error: "",
      is_error: false,

      selectedFile: "",
      selectedFile2: "",
      selectedFile3: "",
      is_background: false,
      is_background_2: false,
      is_background_3: false,
      background_image: "",
      background_image_2: "",
      background_image_3: "",

      is_calling_api: false,

      //objectives
      objective_desc: [],
      objective_sub_desc: [],
      selectedFileObjectives: [],
      objective_background_image_1: "",
      is_objective_background_image_1: false,
      objective_background_image_2: "",
      is_objective_background_image_2: false,
      objective_background_image_3: "",
      is_objective_background_image_3: false,

      //about
      selectedFile4: "",
      about: {
        title: "",
        subtitle: "",
      },
      about_title: [],
      about_description: [],
      about_background_image: "",
      is_about_background_image: false,

      //video
      selectedFile5: "",
      video: {
        title: "",
        subtitle: "",
        link: "",
      },
      video_background_image: "",
      is_video_background_image: false,

      //faq
      selectedFile6: "",
      faq: {
        title: "",
        subtitle: "",
      },
      faq_background_image: "",
      is_faq_background_image: false,

      //testimonials
      selectedFile7: "",
      testimonial: {
        title: "",
        subtitle: "",
        description: "",
      },
      testimonial_background_image: "",
      is_testimonial_background_image: false,

      // donate
      selectedFile8: "",
      donate: {
        title: "",
        subtitle: "",
        description: "",
        purpose_title: "",
        purpose_description: "",
      },
      donate_background_image: "",
      is_donate_background_image: false,

      // Latest Events
      selectedFile9: "",
      events: {
        title: "",
        subtitle: "",
        description: "",
      },
      events_background_image: "",
      is_events_background_image: false,

      // Mission Intro
      mission_intro: {
        section_title: "",
        title: "",
        description: "",
      },

      // Checklist
      checklist: {
        title: "",
        subtitle: "",
        description: "",
        short_text: "",
        checklist1: "",
        checklist2: "",
        checklist3: "",
      },
      checklist_background_image: "",
      is_checklist_background_image: false,
      selectedFile10: "",

      // Volunteers
      selectedFile11: "",
      volunteers: {
        title: "",
        subtitle: "",
        description: "",
      },
      volunteers_background_image: "",
      is_volunteers_background_image: false,

      // Feeding Program
      selectedFile12: "",
      program: {
        title: "",
        subtitle: "",
        program_title: "",
        program_description: "",
        overview_title: "",
        overview_description: "",
      },
      feeding_background_image: "",
      is_feeding_background_image: false,

      // Contact Us
      contact_description: "",

      options: [{ name: "Homepage" }, { name: "Our Mission" }, { name: "Our Team" }, { name: "FAQs" }, { name: "Feeding Program" }, { name: "Scholarship Program" }, { name: "Events" }, { name: "Stories" }, { name: "Contact Us" }],
      page: [],
    };
  },
  created() {
    this.onConvertSlugtoTitle();
    this.onPopulateData();
  },
  methods: {
    onPopulateData() {
      this.is_loading = true;
      this.$admin_queries("pages", {
        action_type: "display_single_page",
        title: this.title,
      }).then((res) => {
        this.page = res.data.data.pages[0];
        console.log(this.page);
        this.is_loading = false;

        this.onPopulateFields();
      });
    },
    onPopulateFields() {
      this.title = this.page.title;
      this.slug = this.page.slug;
      this.header = this.page.description && this.page.description.title ? this.page.description.title : "";
      this.sub_header = this.page.description && this.page.description.sub_title ? this.page.description.sub_title : "";
      this.meta_title = this.page.meta && this.page.meta.title ? this.page.meta.title : "";
      this.meta_keywords = this.page.meta && this.page.meta.keywords ? this.page.meta.keywords : "";
      this.meta_description = this.page.meta && this.page.meta.description ? this.page.meta.description : "";

      if (this.page) {
        if (this.page.title == "Homepage") {
          this.objective_desc = this.page.description && this.page.description.objective_description ? this.page.description.objective_description : [];
          this.objective_sub_desc = this.page.description && this.page.description.objective_sub_description ? this.page.description.objective_sub_description : [];
          this.objective_background_image_1 = this.page.description && this.page.description.obj_files_webp_0 ? "/public/uploads/pages/objectives_0/homepage/" + this.page.description?.obj_files_webp_0 : "";
          this.is_objective_background_image_1 = this.page.description && this.page.description.obj_files_webp_0 ? true : false;
          this.objective_background_image_2 = this.page.description && this.page.description.obj_files_webp_1 ? "/public/uploads/pages/objectives_1/homepage/" + this.page.description?.obj_files_webp_1 : "";
          this.is_objective_background_image_2 = this.page.description && this.page.description.obj_files_webp_1 ? true : false;
          this.objective_background_image_3 = this.page.description && this.page.description.obj_files_webp_2 ? "/public/uploads/pages/objectives_2/homepage/" + this.page.description?.obj_files_webp_2 : "";
          this.is_objective_background_image_3 = this.page.description && this.page.description.obj_files_webp_2 ? true : false;

          this.about.title = this.page.description && this.page.description.about_main_title ? this.page.description.about_main_title : "";
          this.about.subtitle = this.page.description && this.page.description.about_subtitle ? this.page.description.about_subtitle : "";
          this.about_title = this.page.description && this.page.description.about_title ? this.page.description.about_title : [];
          this.about_description = this.page.description && this.page.description.about_description ? this.page.description.about_description : [];
          this.about_background_image = this.page.description && this.page.description.about_image_webp ? "/public/uploads/pages/about_/homepage/" + this.page.description.about_image_webp : "";
          this.is_about_background_image = this.page.description && this.page.description.about_image_webp ? true : false;

          this.video.title = this.page.description && this.page.description.video_title ? this.page.description.video_title : "";
          this.video.subtitle = this.page.description && this.page.description.video_subtitle ? this.page.description.video_subtitle : "";
          this.video.link = this.page.description && this.page.description.video_link ? this.page.description.video_link : "";
          this.video_background_image = this.page.description && this.page.description.video_image_webp ? "/public/uploads/pages/video_/homepage/" + this.page.description.video_image_webp : "";
          this.is_video_background_image = this.page.description && this.page.description.video_image_webp ? true : false;

          this.faq.title = this.page.description && this.page.description.faq_title ? this.page.description.faq_title : "";
          this.faq.subtitle = this.page.description && this.page.description.faq_subtitle ? this.page.description.faq_subtitle : "";
          this.faq_background_image = this.page.description && this.page.description.faq_image_webp ? "/public/uploads/pages/faq_/homepage/" + this.page.description.faq_image_webp : "";
          this.is_faq_background_image = this.page.description && this.page.description.faq_image_webp ? true : false;

          this.testimonial.title = this.page.description && this.page.description.testimonial_title ? this.page.description.testimonial_title : "";
          this.testimonial.subtitle = this.page.description && this.page.description.testimonial_subtitle ? this.page.description.testimonial_subtitle : "";
          this.testimonial.description = this.page.description && this.page.description.testimonial_description ? this.page.description.testimonial_description : "";
          this.testimonial_background_image = this.page.description && this.page.description.testimonial_image_webp ? "/public/uploads/pages/testimonial_/homepage/" + this.page.description.testimonial_image_webp : "";
          this.is_testimonial_background_image = this.page.description && this.page.description.testimonial_image_webp ? true : false;

          this.donate.title = this.page.description && this.page.description.donate_title ? this.page.description.donate_title : "";
          this.donate.subtitle = this.page.description && this.page.description.donate_subtitle ? this.page.description.donate_subtitle : "";
          this.donate.description = this.page.description && this.page.description.donate_description ? this.page.description.donate_description : "";
          this.donate.purpose_title = this.page.description && this.page.description.donate_purpose_title ? this.page.description.donate_purpose_title : "";
          this.donate.purpose_description = this.page.description && this.page.description.donate_purpose_description ? this.page.description.donate_purpose_description : "";
          this.donate_background_image = this.page.description && this.page.description.donate_image_webp ? "/public/uploads/pages/donate_/homepage/" + this.page.description.donate_image_webp : "";
          this.is_donate_background_image = this.page.description && this.page.description.donate_image_webp ? true : false;

          this.events.title = this.page.description && this.page.description.events_title ? this.page.description.events_title : "";
          this.events.subtitle = this.page.description && this.page.description.events_subtitle ? this.page.description.events_subtitle : "";
          this.events.description = this.page.description && this.page.description.events_description ? this.page.description.events_description : "";
          this.events_background_image = this.page.description && this.page.description.event_image_webp ? "/public/uploads/pages/event_/homepage/" + this.page.description.event_image_webp : "";
          this.is_events_background_image = this.page.description && this.page.description.event_image_webp ? true : false;
        } else if (this.page.title == "Our Mission") {
          this.mission_intro.section_title = this.page.description && this.page.description.mission_intro_section_title ? this.page.description.mission_intro_section_title : "";
          this.mission_intro.title = this.page.description && this.page.description.mission_intro_title ? this.page.description.mission_intro_title : "";
          this.mission_intro.description = this.page.description && this.page.description.mission_intro_description ? this.page.description.mission_intro_description : "";

          this.checklist.title = this.page.description && this.page.description.checklist_title ? this.page.description.checklist_title : "";
          this.checklist.subtitle = this.page.description && this.page.description.checklist_subtitle ? this.page.description.checklist_subtitle : "";
          this.checklist.description = this.page.description && this.page.description.checklist_description ? this.page.description.checklist_description : "";
          this.checklist.short_text = this.page.description && this.page.description.checklist_short_text ? this.page.description.checklist_short_text : "";
          this.checklist.checklist1 = this.page.description && this.page.description.checklist_checklist1 ? this.page.description.checklist_checklist1 : "";
          this.checklist.checklist2 = this.page.description && this.page.description.checklist_checklist2 ? this.page.description.checklist_checklist2 : "";
          this.checklist.checklist3 = this.page.description && this.page.description.checklist_checklist3 ? this.page.description.checklist_checklist3 : "";
          this.checklist_background_image = this.page.description && this.page.description.checklist_image_webp ? "/public/uploads/pages/checklist_/our-mission/" + this.page.description.checklist_image_webp : "";
          this.is_checklist_background_image = this.page.description && this.page.description.checklist_image_webp ? true : false;

          this.volunteers.title = this.page.description && this.page.description.volunteers_title ? this.page.description.volunteers_title : "";
          this.volunteers.subtitle = this.page.description && this.page.description.volunteers_subtitle ? this.page.description.volunteers_subtitle : "";
          this.volunteers.description = this.page.description && this.page.description.volunteers_description ? this.page.description.volunteers_description : "";
          this.volunteers_background_image = this.page.description && this.page.description.volunteer_image_webp ? "/public/uploads/pages/volunteer_/our-mission/" + this.page.description.volunteer_image_webp : "";
          this.is_volunteers_background_image = this.page.description && this.page.description.volunteer_image_webp ? true : false;

          this.video.title = this.page.description && this.page.description.video_title ? this.page.description.video_title : "";
          this.video.subtitle = this.page.description && this.page.description.video_subtitle ? this.page.description.video_subtitle : "";
          this.video.link = this.page.description && this.page.description.video_link ? this.page.description.video_link : "";
          this.video_background_image = this.page.description && this.page.description.video_image_webp ? "/public/uploads/pages/video_/our-mission/" + this.page.description.video_image_webp : "";
          this.is_video_background_image = this.page.description && this.page.description.video_image_webp ? true : false;
        } else if (this.page.title == "Feeding Program" || this.page.title == "Scholarship Program") {
          this.program.title = this.page.description && this.page.description.program_intro_title ? this.page.description.program_intro_title : "";
          this.program.subtitle = this.page.description && this.page.description.program_intro_description ? this.page.description.program_intro_description : "";
          this.program.program_title = this.page.description && this.page.description.program_about_title ? this.page.description.program_about_title : "";
          this.program.program_description = this.page.description && this.page.description.program_about_description ? this.page.description.program_about_description : "";
          this.program.overview_title = this.page.description && this.page.description.program_overview_title ? this.page.description.program_overview_title : "";
          this.program.overview_description = this.page.description && this.page.description.program_overview_description ? this.page.description.program_overview_description : "";
          this.feeding_background_image = this.page.description && this.page.description.program_image_webp ? "/public/uploads/pages/program_/" + this.slug + "/" + this.page.description.program_image_webp : "";
          this.is_feeding_background_image = this.page.description && this.page.description.program_image_webp ? true : false;
        } else if (this.page.title == "Contact Us") {
          this.contact_description = this.page.description && this.page.description.contact_description ? this.page.description.contact_description : "";
        }
      }
      //     if (this.page.description.why_image) {
      //       this.is_background_choose = true;

      //       this.background_image_choose = "/public/uploads/pages/why/" + this.page.pages_id + "/medium/" + this.page.description.why_image;
      //     }

      //     if (this.page.description.how_image) {
      //       this.is_background_why = true;
      //       this.background_image_why = "/" + this.page.description.how_image.medium;
      //     }

      //     if (this.page.description.how_files_0) {
      //       this.icon_how_1 = "/public/uploads/pages/how_0/" + this.page.pages_id + "/medium/" + this.page.description.how_files_0;
      //       this.is_display_icon_1 = true;
      //     }

      //     if (this.page.description.how_files_1) {
      //       this.icon_how_2 = "/public/uploads/pages/how_1/" + this.page.pages_id + "/medium/" + this.page.description.how_files_1;
      //       this.is_display_icon_2 = true;
      //     }

      //     if (this.page.description.how_files_2) {
      //       this.icon_how_3 = "/public/uploads/pages/how_2/" + this.page.pages_id + "/medium/" + this.page.description.how_files_2;
      //       this.is_display_icon_3 = true;
      //     }

      //     if (this.page.description.how_files_3) {
      //       this.icon_how_4 = "/public/uploads/pages/how_3/" + this.page.pages_id + "/medium/" + this.page.description.how_files_3;
      //       this.is_display_icon_4 = true;
      //     }

      //     // Roles
      //     if (this.page.pages_id == 10) {
      //       if (this.page.description.roles_files_0) {
      //         this.icon_roles_1 = "/public/uploads/pages/roles_0/" + this.page.pages_id + "/medium/" + this.page.description.roles_files_0;
      //         this.is_display_roles_img_1 = true;
      //       }

      //       if (this.page.description.roles_files_1) {
      //         this.icon_roles_2 = "/public/uploads/pages/roles_1/" + this.page.pages_id + "/medium/" + this.page.description.roles_files_1;
      //         this.is_display_roles_img_2 = true;
      //       }

      //       if (this.page.description.roles_files_2) {
      //         this.icon_roles_3 = "/public/uploads/pages/roles_2/" + this.page.pages_id + "/medium/" + this.page.description.roles_files_2;
      //         this.is_display_roles_img_3 = true;
      //       }

      //       if (this.page.description.roles_files_3) {
      //         this.icon_roles_4 = "/public/uploads/pages/roles_3/" + this.page.pages_id + "/medium/" + this.page.description.roles_files_3;
      //         this.is_display_roles_img_4 = true;
      //       }
      //       if (this.page.description.roles_files_4) {
      //         this.icon_roles_5 = "/public/uploads/pages/roles_4/" + this.page.pages_id + "/medium/" + this.page.description.roles_files_4;
      //         this.is_display_roles_img_5 = true;
      //       }
      //     }
      //   }

      //   if (this.page.pages_id == 2) {
      //     this.content = this.page.description && this.page.description.content ? this.page.description.content : [];
      //     this.sub_title = this.page.description && this.page.description.content ? this.page.description.sub_content : [];
      //     // this.why_us_title = this.page.description && this.page.description.why_us_title ? this.page.description.why_us_title : [];
      //     // this.why_us_description = this.page.description && this.page.description.why_us_description ? this.page.description.why_us_description : [];
      //     // this.how_title = this.page.description && this.page.description.how_title ? this.page.description.how_title : [];
      //     // this.how_description = this.page.description && this.page.description.how_description ? this.page.description.how_description : [];
      //     this.mission_title = this.page.description && this.page.description.mission_title ? this.page.description.mission_title : "";
      //     this.mission_description = this.page.description && this.page.description.mission_description ? this.page.description.mission_description : "";
      //     this.vision_title = this.page.description && this.page.description.vision_title ? this.page.description.vision_title : "";
      //     this.vision_description = this.page.description && this.page.description.vision_description ? this.page.description.vision_description : "";

      //     this.core_title = this.page.description && this.page.description.core_title ? this.page.description.core_title : [];
      //     this.core_description = this.page.description && this.page.description.core_description ? this.page.description.core_description : [];

      //     this.onLoadEditor();

      //     if (this.page.description.why_image) {
      //       this.is_background_choose = true;
      //       // console.log("/public/uploads/pages/why/"+this.page.pages_id+"/medium/"+this.page.description.why_image);
      //       // this.background_image_choose = "/public/uploads/pages/why/"+this.page.pages_id+"/medium/"+this.page.description.why_image;
      //     }

      //     if (this.page.description.how_image) {
      //       this.is_background_why = true;
      //       this.background_image_why = "/" + this.page.description.how_image.medium;
      //     }

      //     if (this.page.description.about_image1) {
      //       this.is_background_1 = true;
      //       this.background_image_1 = "/public/uploads/pages/about/" + this.page.pages_id + "/medium/" + this.page.description.about_image1;
      //     }

      //     if (this.page.description.about_image2) {
      //       this.is_background_2 = true;
      //       this.background_image_2 = "/public/uploads/pages/about/" + this.page.pages_id + "/medium/" + this.page.description.about_image2;
      //     }

      //     if (this.page.description.core_files_0) {
      //       this.icon_core_1 = "/public/uploads/pages/core_0/" + this.page.pages_id + "/medium/" + this.page.description.core_files_0;
      //       this.is_display_icon_core_1 = true;
      //     }

      //     if (this.page.description.core_files_1) {
      //       this.icon_core_2 = "/public/uploads/pages/core_1/" + this.page.pages_id + "/medium/" + this.page.description.core_files_1;
      //       this.is_display_icon_core_2 = true;
      //     }

      //     if (this.page.description.core_files_2) {
      //       this.icon_core_3 = "/public/uploads/pages/core_2/" + this.page.pages_id + "/medium/" + this.page.description.core_files_2;
      //       this.is_display_icon_core_3 = true;
      //     }

      //     if (this.page.description.core_files_3) {
      //       this.icon_core_4 = "/public/uploads/pages/core_2/" + this.page.pages_id + "/medium/" + this.page.description.core_files_3;
      //       this.is_display_icon_core_4 = true;
      //     }

      //     if (this.page.description.about_image3) {
      //       this.is_background_3 = true;
      //       this.background_image_3 = "/" + this.page.description.about_image3.medium;
      //     }
      //   }

      //   if (this.page.pages_id == 3 || this.page.pages_id == 6) {
      //     this.content = this.page.description && this.page.description.content ? this.page.description.content : [];
      //   }

      if (this.page.image != "") {
        this.is_background = true;
        this.background_image = "/public/uploads/pages/" + this.page.pages_id + "/medium/" + this.page.image;
      }
      if (this.page.extras_image_1 != "") {
        this.is_background_2 = true;
        this.background_image_2 = "/public/uploads/pages/" + this.page.pages_id + "/medium/" + this.page.extras_image_1;
      }
      if (this.page.extras_image_2 != "") {
        this.is_background_3 = true;
        this.background_image_3 = "/public/uploads/pages/" + this.page.pages_id + "/medium/" + this.page.extras_image_2;
      }
    },
    onCancel() {
      this.$router.replace({ name: "AdminPages" });
    },
    onSave() {
      this.onClearErrors();
      this.onCheckRequiredFields();

      if (this.is_error == false) {
        this.is_calling_api = true;
        var page_fields_add = {};
        var page_fields = {
          title: this.title,
          header: this.header,
          sub_header: this.sub_header,
          meta_title: this.meta_title,
          meta_keywords: this.meta_keywords,
          meta_description: this.meta_description,
          action_type: "update_record",
          pages_id: this.page.encrypted_pages_id,
        };

        if (this.title == "Homepage") {
          page_fields_add = {
            objective_description: this.objective_desc,
            objective_sub_description: this.objective_sub_desc,

            about_main_title: this.about.title,
            about_subtitle: this.about.subtitle,
            about_title: this.about_title,
            about_description: this.about_description,

            video_title: this.video.title,
            video_subtitle: this.video.subtitle,
            video_link: this.video.link,

            faq_title: this.faq.title,
            faq_subtitle: this.faq.subtitle,

            testimonial_title: this.testimonial.title,
            testimonial_subtitle: this.testimonial.subtitle,
            testimonial_description: this.testimonial.description,

            donate_title: this.donate.title,
            donate_subtitle: this.donate.subtitle,
            donate_description: this.donate.description,
            donate_purpose_title: this.donate.purpose_title,
            donate_purpose_description: this.donate.purpose_description,

            events_title: this.events.title,
            events_subtitle: this.events.subtitle,
            events_description: this.events.description,
          };
        } else if (this.title == "Our Mission") {
          // let description_array = [$("#summernote-aboutus-textarea1").summernote("code"), $("#summernote-aboutus-textarea2").summernote("code")];
          page_fields_add = {
            mission_intro_section_title: this.mission_intro.section_title,
            mission_intro_title: this.mission_intro.title,
            mission_intro_description: this.mission_intro.description,

            checklist_title: this.checklist.title,
            checklist_subtitle: this.checklist.subtitle,
            checklist_description: this.checklist.description,
            checklist_short_text: this.checklist.short_text,
            checklist_checklist1: this.checklist.checklist1,
            checklist_checklist2: this.checklist.checklist2,
            checklist_checklist3: this.checklist.checklist3,

            volunteers_title: this.volunteers.title,
            volunteers_subtitle: this.volunteers.subtitle,
            volunteers_description: this.volunteers.description,

            video_title: this.video.title,
            video_subtitle: this.video.subtitle,
            video_link: this.video.link,
          };
        } else if (this.title == "Feeding Program" || this.title == "Scholarship Program") {
          page_fields_add = {
            program_intro_title: this.program.title,
            program_intro_description: this.program.subtitle,

            program_about_title: this.program.program_title,
            program_about_description: this.program.program_description,

            program_overview_title: this.program.overview_title,
            program_overview_description: this.program.overview_description,
          };
        } else if (this.title == "Contact Us") {
          page_fields_add = {
            contact_description: this.contact_description,
          };
        }

        var pages_fields = Object.assign(page_fields, page_fields_add);

        this.$admin_queries("save_pages", {
          file: this.selectedFile,
          file1: this.selectedFile2,
          file2: this.selectedFile3,
          file3: this.selectedFile4,
          file4: this.selectedFile5,
          file5: this.selectedFile6,
          file6: this.selectedFile7,
          file7: this.selectedFile8,
          file8: this.selectedFile9,
          file9: this.selectedFile10,
          file10: this.selectedFile11,
          file11: this.selectedFile12,

          objectiveImages: this.selectedFileObjectives,
          // selectedFileOwnersteps: this.selectedFileOwnersteps,
          // selectedFileExp: this.selectedFileExp,
          // selectedFileContacts: this.selectedFileContacts,
          // selectedFileAbout: this.selectedFileAbout,
          page: pages_fields,
        })
          .then((res) => {
            console.log(res);
            this.is_calling_api = false;

            if (res.data.errors) {
              let errors = Object.values(res.data.errors[0].extensions.validation).flat();
              let errors_keys = Object.keys(res.data.errors[0].extensions.validation).flat();

              this.title_error = errors_keys.some((q) => q == "page.title") ? errors[errors_keys.indexOf("page.title")] : "";
              this.header_error = errors_keys.some((q) => q == "page.header") ? errors[errors_keys.indexOf("page.header")] : "";

              this.meta_title_error = errors_keys.some((q) => q == "page.meta_title") ? errors[errors_keys.indexOf("page.meta_title")] : "";
              this.meta_keywords_error = errors_keys.some((q) => q == "page.meta_keywords") ? errors[errors_keys.indexOf("page.meta_keywords")] : "";
              this.meta_description_error = errors_keys.some((q) => q == "page.meta_description") ? errors[errors_keys.indexOf("page.meta_description")] : "";
            } else {
              let response = res.data.data.pages;

              if (response.error == false) {
                Swal.fire("Success!", response.message, "success").then(() => {
                  this.$router.push("/admin/pages");
                });
              } else {
                Swal.fire("Error!", response.message, "error");
              }
            }
          })
          .catch(() => {
            this.is_calling_api = false;
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

      if (this.header == "" && this.title != "Our Mission") {
        this.header_error = error_message + "header";
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
    },
    onClearErrors() {
      this.is_error = false;
      this.title_error = "";
      this.slug_error = "";
      this.header_error = "";
      this.meta_title_error = "";
      this.meta_keywords_error = "";
      this.meta_description_error = "";
    },
    onFileChanged() {
      this.selectedFile = event.target.files[0];
      this.background_image = this.onDisplayUploadedImage(event, "singleFile");
      this.is_background = true;
    },
    onFile2Changed() {
      this.selectedFile2 = event.target.files[0];
      this.background_image_2 = this.onDisplayUploadedImage(event, "singleFile");
      this.is_background_2 = true;
    },
    onFile3Changed() {
      this.selectedFile3 = event.target.files[0];
      this.background_image_3 = this.onDisplayUploadedImage(event, "singleFile");
      this.is_background_3 = true;
    },
    onFile4Changed() {
      this.selectedFile4 = event.target.files[0];
      this.about_background_image = this.onDisplayUploadedImage(event, "singleFile");
      this.is_about_background_image = true;
    },
    onFile5Changed() {
      this.selectedFile5 = event.target.files[0];
      this.video_background_image = this.onDisplayUploadedImage(event, "singleFile");
      this.is_video_background_image = true;
    },
    onFile6Changed() {
      this.selectedFile6 = event.target.files[0];
      this.faq_background_image = this.onDisplayUploadedImage(event, "singleFile");
      this.is_faq_background_image = true;
    },
    onFile7Changed() {
      this.selectedFile7 = event.target.files[0];
      this.testimonial_background_image = this.onDisplayUploadedImage(event, "singleFile");
      this.is_testimonial_background_image = true;
    },
    onFile8Changed() {
      this.selectedFile8 = event.target.files[0];
      this.donate_background_image = this.onDisplayUploadedImage(event, "singleFile");
      this.is_donate_background_image = true;
    },
    onFile9Changed() {
      this.selectedFile9 = event.target.files[0];
      this.events_background_image = this.onDisplayUploadedImage(event, "singleFile");
      this.is_events_background_image = true;
    },
    onFile10Changed() {
      this.selectedFile10 = event.target.files[0];
      this.checklist_background_image = this.onDisplayUploadedImage(event, "singleFile");
      this.is_checklist_background_image = true;
    },
    onFile11Changed() {
      this.selectedFile11 = event.target.files[0];
      this.volunteers_background_image = this.onDisplayUploadedImage(event, "singleFile");
      this.is_volunteers_background_image = true;
    },
    onFile12Changed() {
      this.selectedFile12 = event.target.files[0];
      this.feeding_background_image = this.onDisplayUploadedImage(event, "singleFile");
      this.is_feeding_background_image = true;
    },
    onFileChangedObjectives(e, index) {
      this.selectedFileObjectives[index] = e.target.files[0];
      this.background_image = this.onDisplayUploadedImage(e, `objective_${index + 1}`);
      this.is_background = true;
    },
    onDisplayUploadedImage(e, type) {
      const file = e.target.files[0];

      if (type == "singleFile") {
        return URL.createObjectURL(file);
      } else if (type == "objective_1") {
        this.objective_background_image_1 = URL.createObjectURL(file);
        this.is_objective_background_image_1 = true;
      } else if (type == "objective_2") {
        this.objective_background_image_2 = URL.createObjectURL(file);
        this.is_objective_background_image_2 = true;
      } else if (type == "objective_3") {
        this.objective_background_image_3 = URL.createObjectURL(file);
        this.is_objective_background_image_3 = true;
      }
    },

    onConvertSlugtoTitle() {
      switch (this.slug) {
        case "homepage":
          this.title = "Homepage";
          break;

        case "our-mission":
          this.title = "Our Mission";
          break;

        case "our-team":
          this.title = "Our Team";
          break;

        case "faqs":
          this.title = "FAQs";
          break;

        case "feeding-program":
          this.title = "Feeding Program";
          break;

        case "scholarship-program":
          this.title = "Scholarship Program";
          break;

        case "events":
          this.title = "Events";
          break;

        case "stories":
          this.title = "Stories";
          break;

        case "contact-us":
          this.title = "Contact Us";
          break;

        default:
          break;
      }
    },
  },
};
</script>