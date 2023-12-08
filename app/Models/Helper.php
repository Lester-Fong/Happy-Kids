<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use File;
use Validator;
use Request;
use Input;
use Config;
use Hash;
use Session;
use Mail;
use Log;
use Storage;
use Str;
use Crypt;
use Image;

class Helper extends Eloquent
{

    public function ImageUpload($file, $id, $type)
    {
        if ($file != "") {

            ini_set('memory_limit', '-1');
            switch ($type) {
                case "pages":
                    $destinationPath = Config::get('Constants.PAGES_IMAGE_PATH') . $id . '/';
                    break;
                case "category":
                    $destinationPath = Config::get('Constants.CATEGORY_IMAGE_PATH') . $id . '/';
                    break;
                case "category_cover":
                    $destinationPath = Config::get('Constants.CATEGORY_COVER_IMAGE_PATH') . $id . '/';
                    break;
                case "blog_category":
                    $destinationPath = Config::get('Constants.BLOG_CATEGORY_IMAGE_PATH') . $id . '/';
                    break;
                case "blogs_image":
                    $destinationPath = Config::get('Constants.BLOGS_IMAGE_PATH') . $id . '/';
                    break;
                case "testimonial":
                    $destinationPath = Config::get('Constants.TESTIMONIALS_IMAGE_PATH') . $id . '/';
                    break;
                case "team":
                    $destinationPath = Config::get('Constants.TEAM_IMAGE_PATH') . $id . '/';
                    break;
                case "content":
                    $destinationPath = Config::get('Constants.CONTENT_IMAGE_PATH') . $id . '/';
                    break;
                case "blogs_thumbnail":
                    $destinationPath = Config::get('Constants.BLOGS_THUMBNAIL_PATH') . $id . '/';
                    break;
                case "events_image":
                    $destinationPath = Config::get('Constants.EVENTS_IMAGE_PATH') . $id . '/';
                    break;
                default:
                    // Handle the case when $type is not recognized.
                    $destinationPath = "";
                    break;
            }




            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $filename_without_extension = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

            if (File::exists($destinationPath)) {
                if ($type == "contractor") {
                    File::deleteDirectory(Config::get('Constants.CONTRACTOR_IMAGE_PATH') . $id . '/');
                }
                if ($type == "customer") {
                    File::deleteDirectory(Config::get('Constants.CUSTOMER_IMAGE_PATH') . $id . '/');
                }
                if ($type == "admin") {
                    File::deleteDirectory(Config::get('Constants.ADMIN_IMAGE_PATH') . $id . '/');
                }
            }



            $file->move($destinationPath, $filename);
            if (!File::exists($destinationPath . Config::get('Constants.THUMB'))) {
                File::makeDirectory($destinationPath . Config::get('Constants.MEDIUM'), 0775);
                File::makeDirectory($destinationPath . Config::get('Constants.SMALL'), 0775);
                File::makeDirectory($destinationPath . Config::get('Constants.THUMB'), 0775);
                File::makeDirectory($destinationPath . Config::get('Constants.LARGE'), 0775);
            }

            $destinationPathFile = $destinationPath . $filename;

            $img = Image::make(file_get_contents($destinationPathFile))->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->encode('webp')->save($destinationPath . $filename_without_extension . '.webp');

            $img->save($destinationPath . Config::get('Constants.LARGE') . $filename, 90);

            $img = Image::make(file_get_contents($destinationPathFile))->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($destinationPath . Config::get('Constants.MEDIUM') . $filename, 90);

            $img = Image::make(file_get_contents($destinationPathFile))->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($destinationPath . Config::get('Constants.SMALL') . $filename, 90);

            $img = Image::make(file_get_contents($destinationPathFile))->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($destinationPath . Config::get('Constants.THUMB') . $filename, 90);
        } else {
            $filename = "";
        }


        if ($type == "blogs" && $id == 0) {
            return $destinationPathFile;
        } else if ($type == "portfolio") {
            $original_file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $file->getClientOriginalExtension();
            return ["filename_for_response" => $original_file_name, "filename_for_saving" => $filename];
        }

        return $filename;
    }

    public function removePhoto($portfolio_id, $image_name)
    {
        $destinationPath = Config::get('Constants.CONTRACTOR_PORTFOLIO_IMAGE_PATH') . $portfolio_id . '/';


        // Determine the desired extension (e.g., webp)
        $newExtension = "webp";
        // Extract the current extension from the string
        $currentExtension = pathinfo($image_name, PATHINFO_EXTENSION);

        // Remove the current extension and add the new one
        $newFilename = preg_replace('/\..+$/', '.' . $newExtension, $image_name);

        File::delete($destinationPath . $image_name);
        File::delete($destinationPath . $newFilename);
        File::delete($destinationPath . Config::get('Constants.LARGE') . $image_name);
        File::delete($destinationPath . Config::get('Constants.MEDIUM') . $image_name);
        File::delete($destinationPath . Config::get('Constants.SMALL') . $image_name);
        File::delete($destinationPath . Config::get('Constants.THUMB') . $image_name);
    }


    public function sendEmail($to, $from, $to_name, $from_name, $subject, $cc, $data)
    {

        try {

            Mail::send("email", $data, function ($message) use ($to, $from, $to_name, $from_name, $subject, $cc) {
                $message->from($from, $from_name);
                $message->to($to, $to_name)
                    ->subject($subject);

                if (count($cc) > 0) {
                    $message->cc($cc);
                }
            });
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
        }
    }

    public function sendEmailWithBcc($from, $from_name, $subject, $data, $recipients, $cc)
    {
        try {
            Mail::send("email", $data, function ($message) use ($from, $from_name, $subject, $recipients, $cc) {
                $message->from($from, $from_name);
                $message->to($recipients[0], '')
                    ->bcc(array_slice($recipients, 1))
                    ->subject($subject);

                if (count($cc) > 0) {
                    $message->cc($cc);
                }
            });
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
        }
    }


    public function sendSms($to, $from, $to_name, $from_name, $data)
    {

        // try {
        //           Mail::send("sms", $data, function($message) use($to, $from, $to_name, $from_name,) {
        //               $message->from($from,$from_name);
        //               $message->to($to, $to_name)
        //                       ->subject($subject);
        //
        //               if(count($cc) > 0) {
        //                   $message->cc($cc);
        //               }
        //           });
        //
        //     } catch(\Exception $e) {
        //       Log::debug($e->getMessage());
        //     }
    }


    public function checkDevelopmentStatus()
    {
        $base_url = "";
        $website_name = "Servicio - ";
        if (Config::get('Constants.DEVELOPMENT_STATUS') == "local") {
            $base_url = "servicio.local";
            $website_name = $website_name . "local";
        } else if (Config::get('Constants.DEVELOPMENT_STATUS') == "production") {
            $base_url = "servicio.ph";
            $website_name = $website_name . "production";
        }

        $response_obj = new \stdClass();
        $response_obj->base_url = $base_url;
        $response_obj->website_name = $website_name;
        return $response_obj;
    }

    public function checkGoogleRecaptcha($action = "homepage", $captcha = "")
    {

        $data = "https://www.google.com/recaptcha/api/siteverify?secret=" . Config::get('Constants.GOOGLE_RECAPTCHA_VERIFY') . "&response=$captcha";

        try {
            $Response = file_get_contents($data);

            $Return = json_decode($Response);

            $response = self::checkDevelopmentStatus();
            $hostname = $response->base_url;

            // Log::debug($hostname);
            // Log::debug(print_r('ReturDown', true));
            // Log::debug(print_r($Return, true));


            if ($Return->success == true && $Return->score > 0.5 && str_contains($Return->hostname, $hostname)   && $Return->action == $action) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            Log::error(print_r($e->getMessage(), true));
            return false;
        }
    }

    public function checkRecaptacha($token, $action)
    {
        // Log::debug('action' . $action);
        $response = self::checkGoogleRecaptcha($action, $token);
        // Log::debug('response' . $response);

        $response_obj = new \stdClass();
        if ($response == false) {
            $response_obj->error = true;
            $response_obj->message = "Invalid recaptcha please try again.";
            return $response_obj;
        }
        $response_obj->error = false;
        return $response_obj;
    }

    public function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomIndex = mt_rand(0, strlen($characters) - 1);
            $randomString .= $characters[$randomIndex];
        }

        return $randomString;
    }

    public function ImageUpload2($file, $id, $type)
    {
        if ($file != "") {
            // ini_set('memory_limit', '-1');
            if ($type == "blogs_image") {
                $destinationPath = Config::get('Constants.BLOGS_IMAGE_PATH') . $id . '/';
            } else if ($type == "blogs_thumbnail") {
                $destinationPath = Config::get('Constants.BLOGS_THUMBNAIL_PATH') . $id . '/';
            } else if ($type == "events_image") {
                $destinationPath = Config::get('Constants.EVENTS_IMAGE_PATH') . $id . '/';
            }
            
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.webp';

            $file->move($destinationPath, $filename);

            if (!File::exists($destinationPath . Config::get('Constants.THUMB'))) {
                File::makeDirectory($destinationPath . Config::get('Constants.MEDIUM'), 0775);
                File::makeDirectory($destinationPath . Config::get('Constants.SMALL'), 0775);
                File::makeDirectory($destinationPath . Config::get('Constants.THUMB'), 0775);
                File::makeDirectory($destinationPath . Config::get('Constants.LARGE'), 0775);
            }

            $destinationPathFile = $destinationPath . $filename;


            // root path and original size
            $img = Image::make(file_get_contents($destinationPathFile));
            $img->encode('webp')->save($destinationPath . $filename);


            $img = Image::make(file_get_contents($destinationPathFile))->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->encode('webp', 90)->save($destinationPath . Config::get('Constants.LARGE') . $filename);


            $img = Image::make(file_get_contents($destinationPathFile))->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->encode('webp', 80)->save($destinationPath . Config::get('Constants.MEDIUM') . $filename);


            $img = Image::make(file_get_contents($destinationPathFile))->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->encode('webp', 60)->save($destinationPath . Config::get('Constants.SMALL') . $filename);


            $img = Image::make(file_get_contents($destinationPathFile))->resize(75, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->encode('webp', 50)->save($destinationPath . Config::get('Constants.THUMB') . $filename);
        } else {
            $filename = "";
        }
        return $filename;
    }
}
