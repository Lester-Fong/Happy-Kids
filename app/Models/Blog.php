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


class Blog extends Eloquent
{

  protected $table = 'tblBlog';
  protected $primaryKey = 'fldBlogID';
  public $timestamps = false;


  public function category()
  {
    return $this->belongsTo(BlogCategory::class, 'fldBlogCategoryID', 'fldBlogCategoryID');
  }

  public function author()
  {
    return $this->belongsTo(Administrator::class, 'fldBlogAuthor', 'fldAdministratorID');
  }


  public function findBlog($id)
  {
    $blog = self::find($id);
    return $blog;
  }

  public function displayAll()
  {
    $blog = self::orderBy('fldBlogDate', 'DESC')->get();
    return $blog;
  }

  public function displayBlogByID($id)
  {
    $blog_id = Crypt::decryptString($id);
    $blog = self::where('fldBlogID', '=', $blog_id)->get();
    return $blog;
  }

  public function AddUpdateRecord($id, $data)
  {
    if ($id == 0) {
      $blog = new self;
    } else {
      $blog = self::find($id);
    }

    $admin_model = new Administrator();
    $admin = $admin_model->getInfo();

    $blog->fldBlogTitle = $data['title'];
    $blog->fldBlogDescription = $data['description'];
    $blog->fldBlogSlug = Str::slug($data['title']);
    $blog->fldBlogDate = $data['date'];
    $blog->fldBlogCategoryID = $data['category_id'];
    $blog->fldBlogStatus = $data['status'];
    // $blog->fldBlogReadLength = $data['minutes_read'];
    $blog->fldBlogAuthor = $admin->fldAdministratorID;

    $meta_obj = new \stdClass();
    $meta_obj->title = $data['meta_title'];
    $meta_obj->description = $data['meta_description'];
    $meta_obj->keywords = $data['meta_keywords'];


    $blog->fldBlogMeta = serialize($meta_obj);

    $blog->save();


    return $blog->fldBlogID;
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
    $blogs = self::orderBy('fldBlogDate', 'DESC')->take(10)->get();
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
      ->where('fldBlogStatus', "=", 1)
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
