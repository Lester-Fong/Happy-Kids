<?php
namespace App\GraphQL\Mutations;

use Auth;
use App\Models\BlogCategory;
use App\Models\Helper;


use Str;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Log;
use Hash;
use Config;
use Crypt;

class BlogCategoryMutation extends Mutation {

  protected $attributes = [
     'name' => 'BlogCategoryMutation'
  ];


  public function args(): array {
     return [
       'blog_category' => [ 'type' => GraphQL::type('blog_category_input')],
     ];
  }

  public function type(): Type {
     return GraphQL::type('response_type');
  }


  public function validationErrorMessages(array $args = []): array {
      return [
         'blog_category.name.required' => 'Please enter category name',
      ];
  }

  public function rules(array $args = []): array {
     $rules = [];

     Log::debug('blog categ mutation args');
     Log::debug(print_r($args, true));
     
     $blog_category = $args['blog_category'];

     if($blog_category['action_type'] == "add" || $blog_category['action_type'] == "update") {
       $rules['blog_category.name'] = ['required'];
     }




     return $rules;
  }


  public function resolve($root, $args) {

     $blog_category = $args['blog_category'];
     $response_obj = new \stdClass();
     $category_data = new BlogCategory();

     $helper_model = new Helper();

     if($blog_category['action_type'] == "add") {
         $response_obj = $category_data->AddUpdateRecord(0, $blog_category);

         Log::debug(print_r($response_obj, true));
     }

     if($blog_category['action_type'] == "update") {
       $category_id = Crypt::decryptString($blog_category['category_id']);

       $response_obj = $category_data->AddUpdateRecord($category_id, $blog_category);

     }

     if($blog_category['action_type'] == "delete_record") {
       $category_data = new BlogCategory();
       $category_id = Crypt::decryptString($blog_category['category_id']);
       $category_rec = BlogCategory::find($category_id);

       if($category_rec) {
          $category_rec->delete();

          $response_obj->error = false;
          $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_DELETED_SUCCESSFUL'];
       } else {
         $response_obj->error = true;
         $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_NOT_FOUND'];
       }
     }

     return $response_obj;

  }

}
