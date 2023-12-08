<?php
namespace App\GraphQL\Inputs;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class BlogCategoryInput extends InputType {


   protected $attributes = [
      'name' => 'BlogCategoryInput',
      'description' => 'Project Blog Category information'
   ];

   public function fields(): array {
      return [
          'name' => [
             'type' => Type::string(),
          ],
          'action_type' => [
             'type' => Type::string(),
          ],
          'category_id' => [
             'type' => Type::string(),
          ],

      ];
   }

}
