<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Image;
use File;
use Validator;
use Request;
use Input;
use Config;
use Hash;
use Session;
use Log;
use Crypt;
use DB;
use Dompdf\Dompdf;
use View;
use Str;
use Illuminate\Support\Arr;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth2;


class Pages extends Eloquent
{

    protected $table = 'tblPages';
    protected $primaryKey = 'fldPagesID';
    public $timestamps = false;

    public function displayAll()
    {
        return self::all();
    }

    public function displaySinglePage($encrypted_id)
    {
        $id = Crypt::decryptString($encrypted_id);

        $page = self::where('fldPagesID', '=', $id)->get();
        return $page;
    }

    public function addUpdateRecord($id, $data, $args)
    {

        if ($id == 0) {
            $page = new self;
        } else {
            $page = self::find($id);
        }

        $page->fldPagesTitle = $data['title'];
        $page->fldPagesSlug = Str::slug($data['title']);

        $description_obj = new \stdClass();
        $description_obj->title = $data['header'];
        $description_obj->sub_title = $data['sub_header'];

        if ($data['title'] == 'Homepage') {

            $description_obj->objective_description = $data['objective_description'];
            $description_obj->objective_sub_description = $data['objective_sub_description'];
            $description_obj->about_main_title = $data['about_main_title'];
            $description_obj->about_subtitle = $data['about_subtitle'];
            $description_obj->about_title = $data['about_title'];
            $description_obj->about_description = $data['about_description'];
            $description_obj->video_title = $data['video_title'];
            $description_obj->video_subtitle = $data['video_subtitle'];
            $description_obj->video_link = $data['video_link'];
            $description_obj->faq_title = $data['faq_title'];
            $description_obj->faq_subtitle = $data['faq_subtitle'];
            $description_obj->testimonial_title = $data['testimonial_title'];
            $description_obj->testimonial_subtitle = $data['testimonial_subtitle'];
            $description_obj->testimonial_description = $data['testimonial_description'];
            $description_obj->donate_title = $data['donate_title'];
            $description_obj->donate_subtitle = $data['donate_subtitle'];
            $description_obj->donate_description = $data['donate_description'];
            $description_obj->donate_purpose_title = $data['donate_purpose_title'];
            $description_obj->donate_purpose_description = $data['donate_purpose_description'];
            $description_obj->events_title = $data['events_title'];
            $description_obj->events_subtitle = $data['events_subtitle'];
            $description_obj->events_description = $data['events_description'];
        }

        if ($data['title'] == 'Our Mission') {
            $description_obj->mission_intro_section_title = $data['mission_intro_section_title'];
            $description_obj->mission_intro_title = $data['mission_intro_title'];
            $description_obj->mission_intro_description = $data['mission_intro_description'];
            $description_obj->checklist_title = $data['checklist_title'];
            $description_obj->checklist_subtitle = $data['checklist_subtitle'];
            $description_obj->checklist_description = $data['checklist_description'];
            $description_obj->checklist_short_text = $data['checklist_short_text'];
            $description_obj->checklist_checklist1 = $data['checklist_checklist1'];
            $description_obj->checklist_checklist2 = $data['checklist_checklist2'];
            $description_obj->checklist_checklist3 = $data['checklist_checklist3'];
            $description_obj->volunteers_title = $data['volunteers_title'];
            $description_obj->volunteers_subtitle = $data['volunteers_subtitle'];
            $description_obj->volunteers_description = $data['volunteers_description'];
        }

        if ($id == 3 || $id == 6) {
            $description_obj->content = $data['content'];
        }


        if ($id == 8) {

            $description_obj->description = $data['description'];
        }

        // Uploading the image

        if (isset($data['title'])) {

            $helper_model = new Helper();
            $description_data = $page->fldPagesDescription ? unserialize($page->fldPagesDescription) : new \stdClass();


            if ($data['title'] == 'Homepage') {
                $objective_images = $args['objectiveImages'];

                if ($objective_images) {
                    foreach ($objective_images as $index => $obj_files) {
                        if ($obj_files != "") {
                            $filename = $helper_model->ImageUpload($obj_files, "objectives_" . $index . "/" . $id, "pages");
                            $dynamic_var = "obj_files_" . $index;
                            $dynamic_var_webp = "obj_files_webp_" . $index;
                            $description_obj->$dynamic_var = $filename;
                            $filename_arr = explode('.', $filename);
                            $description_obj->$dynamic_var_webp = $filename_arr[0] . ".webp";
                        } else {
                            $dynamic_var = "obj_files_" . $index;
                            $dynamic_var_webp = "obj_files_webp_" . $index;
                            $description_obj->$dynamic_var = isset($description_obj->$dynamic_var) ? $description_obj->$dynamic_var : "";
                            $description_obj->$dynamic_var_webp = isset($description_obj->$dynamic_var_webp) ? $description_obj->$dynamic_var_webp : "";
                        }
                    }
                } else {
                    $description_obj->obj_files_0 = isset($description_data->obj_files_0) ? $description_data->obj_files_0 : "";
                    $description_obj->obj_files_1 = isset($description_data->obj_files_1) ? $description_data->obj_files_1 : "";
                    $description_obj->obj_files_2 = isset($description_data->obj_files_2) ? $description_data->obj_files_2 : "";
                    $description_obj->obj_files_3 = isset($description_data->obj_files_3) ? $description_data->obj_files_3 : "";

                    $description_obj->obj_files_webp_0 = isset($description_data->obj_files_webp_0) ? $description_data->obj_files_webp_0 : "";
                    $description_obj->obj_files_webp_1 = isset($description_data->obj_files_webp_1) ? $description_data->obj_files_webp_1 : "";
                    $description_obj->obj_files_webp_2 = isset($description_data->obj_files_webp_2) ? $description_data->obj_files_webp_2 : "";
                    $description_obj->obj_files_webp_3 = isset($description_data->obj_files_webp_3) ? $description_data->obj_files_webp_3 : "";
                }

                $file3 = $args['file3'];
                if ($file3 != "") {
                    $filename = $helper_model->ImageUpload($file3, "about" . "/" . $id, "pages");
                    $description_obj->about_image = $filename;
                    $filename_arr = explode('.', $filename);
                    $description_obj->about_image_webp = $filename_arr[0] . ".webp";
                } else {
                    $description_obj->about_image = isset($description_data->about_image) ? $description_data->about_image : "";
                    $description_obj->about_image_webp = isset($description_data->about_image_webp) ? $description_data->about_image_webp : "";
                }
                $file4 = $args['file4'];
                if ($file4 != "") {
                    $filename = $helper_model->ImageUpload($file4, "video" . "/" . $id, "pages");
                    $description_obj->video_image = $filename;
                    $filename_arr = explode('.', $filename);
                    $description_obj->video_image_webp = $filename_arr[0] . ".webp";
                } else {
                    $description_obj->video_image = isset($description_data->video_image) ? $description_data->video_image : "";
                    $description_obj->video_image_webp = isset($description_data->video_image_webp) ? $description_data->video_image_webp : "";
                }
                $file5 = $args['file5'];
                if ($file5 != "") {
                    $filename = $helper_model->ImageUpload($file5, "faq" . "/" . $id, "pages");
                    $description_obj->faq_image = $filename;
                    $filename_arr = explode('.', $filename);
                    $description_obj->faq_image_webp = $filename_arr[0] . ".webp";
                } else {
                    $description_obj->faq_image = isset($description_data->faq_image) ? $description_data->faq_image : "";
                    $description_obj->faq_image_webp = isset($description_data->faq_image_webp) ? $description_data->faq_image_webp : "";
                }
                $file6 = $args['file6'];
                if ($file6 != "") {
                    $filename = $helper_model->ImageUpload($file6, "testimonial" . "/" . $id, "pages");
                    $description_obj->testimonial_image = $filename;
                    $filename_arr = explode('.', $filename);
                    $description_obj->testimonial_image_webp = $filename_arr[0] . ".webp";
                } else {
                    $description_obj->testimonial_image = isset($description_data->testimonial_image) ? $description_data->testimonial_image : "";
                    $description_obj->testimonial_image_webp = isset($description_data->testimonial_image_webp) ? $description_data->testimonial_image_webp : "";
                }
                $file7 = $args['file7'];
                if ($file7 != "") {
                    $filename = $helper_model->ImageUpload($file7, "donate" . "/" . $id, "pages");
                    $description_obj->donate_image = $filename;
                    $filename_arr = explode('.', $filename);
                    $description_obj->donate_image_webp = $filename_arr[0] . ".webp";
                } else {
                    $description_obj->donate_image = isset($description_data->donate_image) ? $description_data->donate_image : "";
                    $description_obj->donate_image_webp = isset($description_data->donate_image_webp) ? $description_data->donate_image_webp : "";
                }
                $file8 = $args['file8'];
                if ($file8 != "") {
                    $filename = $helper_model->ImageUpload($file8, "event" . "/" . $id, "pages");
                    $description_obj->event_image = $filename;
                    $filename_arr = explode('.', $filename);
                    $description_obj->event_image_webp = $filename_arr[0] . ".webp";
                } else {
                    $description_obj->event_image = isset($description_data->event_image) ? $description_data->event_image : "";
                    $description_obj->event_image_webp = isset($description_data->event_image_webp) ? $description_data->event_image_webp : "";
                }
            } else if ($data['title'] == 'Our Mission') {
                $file9 = $args['file9'];
                if ($file9 != "") {
                    $filename = $helper_model->ImageUpload($file9, "checklist" . "/" . $id, "pages");
                    $description_obj->checklist_image = $filename;
                    $filename_arr = explode('.', $filename);
                    $description_obj->checklist_image_webp = $filename_arr[0] . ".webp";
                } else {
                    $description_obj->checklist_image = isset($description_data->checklist_image) ? $description_data->checklist_image : "";
                    $description_obj->checklist_image_webp = isset($description_data->checklist_image_webp) ? $description_data->checklist_image_webp : "";
                }
                $file10 = $args['file10'];
                if ($file10 != "") {
                    $filename = $helper_model->ImageUpload($file10, "volunteer" . "/" . $id, "pages");
                    $description_obj->volunteer_image = $filename;
                    $filename_arr = explode('.', $filename);
                    $description_obj->volunteer_image_webp = $filename_arr[0] . ".webp";
                } else {
                    $description_obj->volunteer_image = isset($description_data->volunteer_image) ? $description_data->volunteer_image : "";
                    $description_obj->volunteer_image_webp = isset($description_data->volunteer_image_webp) ? $description_data->volunteer_image_webp : "";
                }
            }

            // if ($id == 2) {

            //     $core_files_arr = $args['selectedFileCore'];
            //     if ($core_files_arr) {
            //         foreach ($core_files_arr as $index => $core_files) {
            //             if ($core_files != "") {
            //                 $filename = $helper_model->ImageUpload($core_files, "core_" . $index . "/" . $id, "pages");
            //                 $dynamic_var = "core_files_" . $index;
            //                 $dynamic_var_webp = "core_files_webp_" . $index;
            //                 $description_obj->$dynamic_var = $filename;
            //                 $filename_arr = explode('.', $filename);
            //                 $description_obj->$dynamic_var_webp = $filename_arr[0] . ".webp";
            //             } else {
            //                 $dynamic_var = "core_files_" . $index;
            //                 $dynamic_var_webp = "core_files_webp_" . $index;
            //                 $description_obj->$dynamic_var = isset($description_obj->$dynamic_var) ? $description_obj->$dynamic_var : "";
            //                 $description_obj->$dynamic_var_webp = isset($description_obj->$dynamic_var_webp) ? $description_obj->$dynamic_var_webp : "";
            //             }
            //         }
            //     } else {
            //         $description_obj->core_files_0 = isset($description_data->core_files_0) ? $description_data->core_files_0 : "";
            //         $description_obj->core_files_1 = isset($description_data->core_files_1) ? $description_data->core_files_1 : "";
            //         $description_obj->core_files_2 = isset($description_data->core_files_2) ? $description_data->core_files_2 : "";
            //         $description_obj->core_files_3 = isset($description_data->core_files_3) ? $description_data->core_files_3 : "";


            //         $description_obj->core_files_webp_0 = isset($description_data->core_files_webp_0) ? $description_data->core_files_webp_0 : "";
            //         $description_obj->core_files_webp_1 = isset($description_data->core_files_webp_1) ? $description_data->core_files_webp_1 : "";
            //         $description_obj->core_files_webp_2 = isset($description_data->core_files_webp_2) ? $description_data->core_files_webp_2 : "";
            //         $description_obj->core_files_webp_3 = isset($description_data->core_files_webp_3) ? $description_data->core_files_webp_3 : "";
            //     }
            // }




            // if ($id == 10) {
            //     $roles_files_arr = $args['selectedFileRoles'];
            //     if ($roles_files_arr) {
            //         foreach ($roles_files_arr as $index => $roles_files) {
            //             if ($roles_files != "") {
            //                 $filename = $helper_model->ImageUpload($roles_files, "roles_" . $index . "/" . $id, "pages");
            //                 $dynamic_var = "roles_files_" . $index;
            //                 $dynamic_var_webp = "roles_files_webp_" . $index;
            //                 $description_obj->$dynamic_var = $filename;
            //                 $filename_arr = explode('.', $filename);
            //                 $description_obj->$dynamic_var_webp = $filename_arr[0] . ".webp";
            //             } else {
            //                 $dynamic_var = "roles_files_" . $index;
            //                 $dynamic_var_webp = "roles_files_webp_" . $index;
            //                 $description_obj->$dynamic_var = isset($description_obj->$dynamic_var) ? $description_obj->$dynamic_var : "";
            //                 $description_obj->$dynamic_var_webp = isset($description_obj->$dynamic_var_webp) ? $description_obj->$dynamic_var_webp : "";
            //             }
            //         }
            //     } else {
            //         $description_obj->roles_files_0 = isset($description_data->roles_files_0) ? $description_data->roles_files_0 : "";
            //         $description_obj->roles_files_1 = isset($description_data->roles_files_1) ? $description_data->roles_files_1 : "";
            //         $description_obj->roles_files_2 = isset($description_data->roles_files_2) ? $description_data->roles_files_2 : "";
            //         $description_obj->roles_files_3 = isset($description_data->roles_files_3) ? $description_data->roles_files_3 : "";
            //         $description_obj->roles_files_4 = isset($description_data->roles_files_4) ? $description_data->roles_files_4 : "";

            //         $description_obj->roles_files_webp_0 = isset($description_data->roles_files_webp_0) ? $description_data->roles_files_webp_0 : "";
            //         $description_obj->roles_files_webp_1 = isset($description_data->roles_files_webp_1) ? $description_data->roles_files_webp_1 : "";
            //         $description_obj->roles_files_webp_2 = isset($description_data->roles_files_webp_2) ? $description_data->roles_files_webp_2 : "";
            //         $description_obj->roles_files_webp_3 = isset($description_data->roles_files_webp_3) ? $description_data->roles_files_webp_3 : "";
            //         $description_obj->roles_files_webp_4 = isset($description_data->roles_files_webp_4) ? $description_data->roles_files_webp_4 : "";
            //     }
            // }


            // if ($id == 2) {
            //     $file1 = $args['file1'];
            //     if ($file1 != "") {
            //         $filename = $helper_model->ImageUpload($file1, "about" . "/" . $id, "pages");
            //         $description_obj->about_image1 = $filename;
            //         $filename_arr = explode('.', $filename);
            //         $description_obj->about_image1_webp = $filename_arr[0] . ".webp";
            //     } else {
            //         $description_obj->about_image1 = isset($description_data->about_image1) ? $description_data->about_image1 : "";
            //         $description_obj->about_image1_webp = isset($description_data->about_image1_webp) ? $description_data->about_image1_webp : "";
            //     }

            //     $file2 = $args['file2'];
            //     if ($file2 != "") {
            //         $filename = $helper_model->ImageUpload($file2, "about" . "/" . $id, "pages");
            //         $description_obj->about_image2 = $filename;
            //         $filename_arr = explode('.', $filename);
            //         $description_obj->about_image2_webp = $filename_arr[0] . ".webp";
            //     } else {
            //         $description_obj->about_image2 = isset($description_data->about_image2) ? $description_data->about_image2 : "";
            //         $description_obj->about_image2_webp = isset($description_data->about_image2_webp) ? $description_data->about_image2_webp : "";
            //     }

            //     $file3 = $args['file3'];
            //     if ($file3 != "") {
            //         $filename = $helper_model->ImageUpload($file3, "about" . "/" . $id, "pages");
            //         $description_obj->about_image3 = $filename;
            //         $filename_arr = explode('.', $filename);
            //         $description_obj->about_image3_webp = $filename_arr[0] . ".webp";
            //     } else {
            //         $description_obj->about_image3 = isset($description_data->about_image3) ? $description_data->about_image3 : "";
            //         $description_obj->about_image3_webp = isset($description_data->about_image3_webp) ? $description_data->about_image3_webp : "";
            //     }
            // }
        }

        $page->fldPagesDescription = serialize($description_obj);

        $meta_obj = new \stdClass();
        $meta_obj->title = $data['meta_title'];
        $meta_obj->description = $data['meta_description'];
        $meta_obj->keywords = $data['meta_keywords'];



        $page->fldPagesMetaInformation = serialize($meta_obj);

        $page->save();

        return $page->fldPagesID;
    }
}
