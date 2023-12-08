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


class BlogCategory extends Eloquent
{

    protected $table = 'tblBlogCategory';
    protected $primaryKey = 'fldBlogCategoryID';
    public $timestamps = false;

    public function blogs()
      {
          return $this->hasMany(Blog::class, 'fldBlogCategoryID', 'fldBlogCategoryID');
      }


    public function findCategory($id) {
        $category = self::find($id);
        return $category;
    }

    public function displayAllCategory() {
        $category = self::orderBy('fldBlogCategoryName')->get();
        return $category;
    }

    public function displayCategoryByID($id) {
      $category_id = Crypt::decryptString($id);
      $category = self::where('fldBlogCategoryID','=',$category_id)->get();
      return $category;
    }

    public function AddUpdateRecord($id, $data) {
        $response_obj = new \stdClass();
      
        if($id == 0) {
           $category = new self;
        } else {
          $category = self::find($id);
        }

        $category->fldBlogCategoryName = $data['name'];

        $category->save();

        $response_obj->error = false;
        $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];


        return $response_obj;
    }

    public function findCategoryBySlug($slug) {
      return self::where('fldBlogCategorySlug','=',$slug)->first();
    }

}
