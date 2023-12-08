<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\Models\Blog;
use App\Models\Helper;


use Str;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Log;
use Hash;
use Config;
use Crypt;

class BlogMutation extends Mutation
{

  protected $attributes = [
    'name' => 'BlogMutation'
  ];


  public function args(): array
  {
    return [
      'blogs' => ['type' => GraphQL::type('blog_input')],
      'file' => ['type' => GraphQL::type('Upload')],
      'file1' => ['type' => GraphQL::type('Upload')],
      'thumbnail' => ['type' => GraphQL::type('Upload')],
    ];
  }

  public function type(): Type
  {
    return GraphQL::type('response_type');
  }


  public function validationErrorMessages(array $args = []): array
  {
    return [
      'blogs.title.required' => 'Please enter title',
    ];
  }

  public function rules(array $args = []): array
  {
    $rules = [];

    $blogs = $args['blogs'];

    if ($blogs['action_type'] == "add" || $blogs['action_type'] == "update") {
      $rules['blogs.title'] = ['required'];
    }




    return $rules;
  }


  public function resolve($root, $args)
  {

    $blogs = $args['blogs'];
    $response_obj = new \stdClass();
    $blogs_model = new Blog();
    $helper_model = new Helper();

    if ($blogs['action_type'] == "add") {
      $blogs_id = $blogs_model->AddUpdateRecord(0, $blogs);
      
      // file saving
      $file = $args['file'];
      if ($file != "") {
        $filename = $helper_model->ImageUpload2($file, $blogs_id, "blogs_image");
        $blog_rec = $blogs_model->find($blogs_id);
        if ($blog_rec) {
          $blog_rec->fldBlogImage = $filename;
          $blog_rec->save();
        }
      }

      $thumbnail = $args['thumbnail'];

      if ($thumbnail != "") {
        $filename = $helper_model->ImageUpload2($thumbnail, $blogs_id, "blogs_thumbnail");
        $blog_rec = Blog::find($blogs_id);
        if ($blog_rec) {
          $blog_rec->fldBlogThumbnail = $filename;
          $blog_rec->save();
        }
      }

      $response_obj->error = false;
      $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];
    }


    if ($blogs['action_type'] == "upload_image_to_editor") {

      $file = $args['file1'];

      $filename = $helper_model->ImageUpload($file, 0, "blogs_image");
      $response_obj->error = false;
      $response_obj->filename = $filename;
    }

    if ($blogs['action_type'] == "update") {


      $blogs_id = Crypt::decryptString($blogs['blogs_id']);

      $blog_rec = $blogs_model->findBlog($blogs_id);

      if ($blog_rec) {
        $blogs_id = $blogs_model->AddUpdateRecord($blogs_id, $blogs);


        $file = $args['file'];
        if ($file != "") {
          $filename = $helper_model->ImageUpload($file, $blogs_id, "blogs_image");
          $blog_rec = Blog::find($blogs_id);
          if ($blog_rec) {
            $blog_rec->fldBlogImage = $filename;
            $blog_rec->save();
          }
        }


        $thumbnail = $args['thumbnail'];

        if ($thumbnail != "") {
          $filename = $helper_model->ImageUpload($thumbnail, $blogs_id, "blogs_thumbnail");
          $blog_rec = Blog::find($blogs_id);
          if ($blog_rec) {
            $blog_rec->fldBlogThumbnail = $filename;
            $blog_rec->save();
          }
        }

        $response_obj->error = false;
        $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];
      } else {
        $response_obj->error = true;
        $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_NOT_FOUND'];
      }
    }

    if ($blogs['action_type'] == "delete_record") {

      $blogs_id = Crypt::decryptString($blogs['blogs_id']);
      $blog_rec = Blog::find($blogs_id);

      if ($blog_rec) {
        $blog_rec->delete();

        $response_obj->error = false;
        $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_DELETED_SUCCESSFUL'];
      } else {
        $response_obj->error = true;
        $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_NOT_FOUND'];
      }
    }

    // if ($blogs['action_type'] == "add_blog_views") {
    //   $response_obj = Blog::addViewsForBlog($blogs['slug']);
    // }

    return $response_obj;
  }
}