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

        if ($id == 2) {
            $description_obj->content = $data['content'];
            $description_obj->sub_content = $data['sub_title'];
            // $description_obj->description = $data['description'];
            // $description_obj->why_us_title = $data['why_us_title'];
            // $description_obj->why_us_description = $data['why_us_description'];
            // $description_obj->how_title = $data['how_title'];
            // $description_obj->how_description = $data['how_description'];
            $description_obj->mission_title = $data['mission_title'];
            $description_obj->mission_description = $data['mission_description'];
            $description_obj->vision_title = $data['vision_title'];
            $description_obj->vision_description = $data['vision_description'];
            $description_obj->core_title = $data['core_title'];
            $description_obj->core_description = $data['core_description'];
        }

        if ($id == 3 || $id == 6) {
            $description_obj->content = $data['content'];
        }


        if ($id == 8) {

            $description_obj->description = $data['description'];
        }

        // Uploading the image

        if ($data['title'] == 'Homepage') {

            $helper_model = new Helper();
            $description_data = $page->fldPagesDescription ? unserialize($page->fldPagesDescription) : new \stdClass();


            if ($data['title'] == 'Homepage') {
                $objective_images = $args['objectiveImages'];

                if ($objective_images) {
                    foreach ($objective_images as $index => $obj_files) {
                        if ($obj_files != "") {
                            $filename = $helper_model->ImageUpload($obj_files, "how_" . $index . "/" . $id, "pages");
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

            // $file4 = $args['file4'];
            // if ($file4 != "") {
            //     $filename = $helper_model->ImageUpload($file4, "why" . "/" . $id, "pages");
            //     $description_obj->why_image = $filename;
            //     $filename_arr = explode('.', $filename);
            //     $description_obj->why_image_webp = $filename_arr[0] . ".webp";
            // } else {
            //     $description_obj->why_image = isset($description_data->why_image) ? $description_data->why_image : "";
            //     $description_obj->why_image_webp = isset($description_data->why_image_webp) ? $description_data->why_image_webp : "";
            // }
            // $file5 = $args['file5'];
            // if ($file5 != "") {
            //     $filename = $helper_model->ImageUpload($file5, "how" . "/" . $id, "pages");
            //     $description_obj->how_image = $filename;
            //     $filename_arr = explode('.', $filename);
            //     $description_obj->how_image_webp = $filename_arr[0] . ".webp";
            // } else {
            //     $description_obj->how_image = isset($description_data->how_image) ? $description_data->how_image : "";
            //     $description_obj->how_image_webp = isset($description_data->how_image_webp) ? $description_data->how_image_webp : "";
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
