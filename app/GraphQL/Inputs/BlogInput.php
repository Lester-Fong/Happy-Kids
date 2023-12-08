<?php
 
namespace App\GraphQL\Inputs;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class BlogInput extends InputType
{

   protected $attributes = [
      'name' => 'BlogInput',
      'description' => 'Project Blog information'
   ];

   public function fields(): array
   {
      return [
         'title' => [
            'type' => Type::string(),
         ],
         'date' => [
            'type' => Type::string(),
         ],
         'description' => [
            'type' => Type::string(),
         ],
         'meta_title' => [
            'type' => Type::string(),
         ],
         'meta_keywords' => [
            'type' => Type::listOf(Type::string()),
         ],
         'meta_description' => [
            'type' => Type::string(),
         ],
         'action_type' => [
            'type' => Type::string(),
         ],
         'blogs_id' => [
            'type' => Type::string(),
         ],
         'category_id' => [
            'type' => Type::string(),
         ],
         'status' => [
            'type' => Type::string(),
         ],
         'slug' => [
            'type' => Type::string(),
         ],
         // 'minutes_read' => [
         //    'type' => Type::string(),
         // ],
      ];
   }
}