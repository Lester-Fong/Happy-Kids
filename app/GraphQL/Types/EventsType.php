<?php

namespace App\GraphQL\Types;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\CustomScalarType;
use Crypt;

class EventsType extends GraphQLType
{

   protected $attributes = [
      'name' =>  'events  record ',
      'description' => 'A response events response'
   ];

   public function fields(): array
   {
      return [

         'events_id' => [
            'type' => new CustomScalarType([
               'name' => 'events_encrypted_id',
               'serialize' => function ($value) {
                  $result = Crypt::encryptString($value);
                  return $result;
               }
            ]),
            'alias' => 'fldEventsID',
         ],
         'original_events_id' => [
            'type' => Type::string(),
            'alias' => 'fldEventsID',
         ],
         'title' => [
            'type' => Type::string(),
            'alias' => 'fldEventsTitle',
         ],
         'date_start' => [
            'type' => Type::string(),
            'alias' => 'fldEventsDateStart',
         ],
         'date_end' => [
            'type' => Type::string(),
            'alias' => 'fldEventsDateEnd',
         ],
         'location' => [
            'type' => Type::string(),
            'alias' => 'fldEventsLocation',
         ],
         'image' => [
            'type' => Type::string(),
            'alias' => 'fldEventsImage',
         ],
         'is_pinned' => [
            'type' => Type::boolean(),
            'alias' => 'fldEventsIsPinned',
         ],
         'status' => [
            'type' => Type::boolean(),
            'alias' => 'fldEventsStatus',
         ],
         'is_expired' => [
            'type' => Type::boolean(),
            'alias' => 'fldEventsIsExpired',
         ],
         'admin' => [
            'type' => Type::string(),
            'alias' => 'fldEventsAdminID',
         ],
         'author' => [
            'type' => GraphQL::type('admin_type'),
         ],
         'date_created' => [
            'type' => Type::string(),
            'alias' => 'fldEventsDateCreated',
         ],
      ];
   }
}