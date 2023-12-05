<?php

namespace App\GraphQL\Queries;
use Auth;
use App\Models\BlogCategory;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Log;
use Request;

class BlogCategoryQuery extends Query {

    protected $attributes = [
        'name' => 'The blogcategory query',
        'description' => 'Retrieves blog category',
    ];

    public function args(): array {
        return [
            'action_type' => [ 'type' => Type::string()],
            'category_id' => [ 'type' => Type::string()],
        ];
    }

    public function type(): Type {
        return Type::listOf(GraphQL::type('blog_category_type'));
    }

    public function resolve($root, $args) {

      $blog_category_model = new BlogCategory();

      if($args['action_type'] == "display_all") {
        $category  = $blog_category_model->displayAllCategory();
      }

      if($args['action_type'] == "display_by_id") {
        $category  = $blog_category_model->displayCategoryByID($args['category_id']);
      }

      return $category;

    }


}
