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


class Testimonial extends Eloquent
{

    protected $table = 'tblTestimonials';
    protected $primaryKey = 'fldTestimonialsID';
    public $timestamps = false;


    public function findTestimonial($id)
    {
        $category = self::find($id);
        return $category;
    }

    public function displayAllTestimonial()
    {
        $category = self::orderBy('fldTestimonialsID', 'DESC')->get();
        return $category;
    }

    public function displayTestimonialByID($id)
    {
        $testimonial_id = Crypt::decryptString($id);
        $testimonial = self::where('fldTestimonialsID', '=', $testimonial_id)->get();
        return $testimonial;
    }

    public function AddUpdateRecord($id, $data)
    {
        if ($id == 0) {
            $testimonial = new self;
        } else {
            $testimonial = self::find($id);
        }

        $testimonial->fldTestimonialsName = $data['name'];
        $testimonial->fldTestimonialsPosition = $data['position'];
        $testimonial->fldTestimonialsDescription = $data['description'];

        $testimonial->save();


        return $testimonial->fldTestimonialsID;
    }


    public function displayHomePage()
    {
        $testimonial = self::orderBy('fldTestimonialsID', 'DESC')->take(3)->get();
        return $testimonial;
    }
}
