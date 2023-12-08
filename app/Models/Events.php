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


class Events extends Eloquent {

  protected $table = 'tblEvents';
  protected $primaryKey = 'fldEventsID';
  public $timestamps = false;

  public function author()
  {
    return $this->belongsTo(Administrator::class, 'fldEventsAdminID', 'fldAdministratorID');
  }

  public function findEvents($id)
  {
    $events = self::find($id);
    return $events;
  }

  public function displayAll() {
    return self::orderBy('fldEventsDateStart', 'DESC')->get();
  }

  public function displayEventsByID($id) {
    $events_id = Crypt::decryptString($id);
    return self::where('fldEventsID', '=', $events_id)->get();
  }

  public function checkAndSetExpired() {
    $events = self::where(function ($query) {
      $query->where('fldEventsIsExpired', '=', 0)
            ->orWhereNull('fldEventsIsExpired');
      })
      ->where('fldEventsDateEnd', '<', date('Y-m-d H:i:s'))
      ->get();

    foreach($events as $event) {
      $event->fldEventsIsExpired = 1;
      $event->save();
    }
    return $events;
  }

  public function AddUpdateRecord($id, $data) {
    if ($id == 0) {
      $events = new self;
    } else {
      $events = self::find($id);
    }

    $admin_model = new Administrator();
    $admin = $admin_model->getInfo();

    $events->fldEventsTitle = $data['title'];
    $events->fldEventsDateStart = $data['date_start'];
    $events->fldEventsDateEnd = $data['date_end'];
    $events->fldEventsLocation = $data['location'];
    $events->fldEventsStatus = $data['status'];
    $events->fldEventsAdminID = $admin->fldAdministratorID;


    $events->save();


    return $events->fldEventsID ;
  }

  public function displayHomePage()
  {

    $blogs = self::where('fldBlogStatus', '=', 1)
      ->orderBy('fldBlogDate', 'DESC')
      ->take(3)
      ->get();
    return $blogs;
  }

  public function displayRecentBlog()
  {
    $blogs = self::orderBy('fldBlogDate', 'DESC')->take(3)->get();
    return $blogs;
  }

  public function displayAllBlog()
  {

    $blogs = self::where('fldBlogStatus', '=', 1)->orderBy('fldBlogDate', 'DESC')->get();
    return $blogs;
  }

  public function displayAllBlogByCategory($category_id)
  {
    $blogs = self::where('fldBlogCategoryID', '=', $category_id)->orderBy('fldBlogDate', 'DESC')->get();
    return $blogs;
  }

  public function displayAllBlogByCategoryExceptSelectedBlog($category_id, $blog_id)
  {
    $blogs = self::where('fldBlogCategoryID', '=', $category_id)
      ->where('fldBlogID', "!=", $blog_id)
      ->orderBy('fldBlogDate', 'DESC')
      ->get();
    return $blogs;
  }

  public function displayPopularBlogs()
  {
    $blogs = self::where('fldBlogStatus', "=", 1)
      ->orderBy('fldBlogDate', 'DESC')
      ->limit(5)                      
      ->get();

    return $blogs;
  }

  public function addViewsForBlog($slug)
  {
    $single_blog = self::where('fldBlogSlug', '=', $slug)->first();
    $response_obj = new \stdClass();

    if ($single_blog && $single_blog->fldBlogStatus == 1) {
      $single_blog->fldBlogViews += 1;
      $single_blog->save();

      $response_obj->error = false;
    } else {
      $response_obj->error = true;
      $response_obj->message = "Record not found.";
    }
    return $response_obj;
  }

  
}
