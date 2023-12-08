<?php
 
namespace App\GraphQL\Queries;
use Auth;
use App\Models\Blog;
use App\Models\BlogCategory;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Log;
use Request;

class BlogQuery extends Query {

    protected $attributes = [
        'name' => 'The blog query',
        'description' => 'Retrieves blog',
    ];

    public function args(): array {
        return [
            'action_type' => [ 'type' => Type::string()],
            'blog_id' => [ 'type' => Type::string()],
        ];
    }

    public function type(): Type {
        return Type::listOf(GraphQL::type('blogs_type'));
    }

    public function resolve($root, $args) {

      $blog_model = new Blog();

      if($args['action_type'] == "display_all") {
        $blog  = $blog_model->displayAll();
      }

      if($args['action_type'] == "display_by_id") {
        $blog  = $blog_model->displayBlogByID($args['blog_id']);
      }

      return $blog;

    }


}