<?php
 
namespace App\GraphQL\Inputs;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class EventsInput extends InputType
{

   protected $attributes = [
      'name' => 'EventsInput',
      'description' => 'Events information'
   ];

   public function fields(): array
   {
      return [
         'events_id' => [
            'type' => Type::string(),
         ],
         'title' => [
            'type' => Type::string(),
         ],
         'date_start' => [
            'type' => Type::string(),
         ],
         'date_end' => [
            'type' => Type::string(),
         ],
         'location' => [
            'type' => Type::string(),
         ],
         'is_pinned' => [
            'type' => Type::string(),
         ],
         'status' => [
            'type' => Type::string(),
         ],
         'is_expired' => [
            'type' => Type::string(),
         ],
         'action_type' => [
            'type' => Type::string(),
         ],
      ];
   }
}