<?php

namespace App\GraphQL\Types;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\CustomScalarType;
use Crypt;

class DonatorType extends GraphQLType
{

   protected $attributes = [
      'name' =>  'donators record ',
      'description' => 'A response donators response'
   ];

   public function fields(): array
   {
      return [

         'donators_id' => [
            'type' => new CustomScalarType([
               'name' => 'donators_encrypted_id',
               'serialize' => function ($value) {
                  $result = Crypt::encryptString($value);
                  return $result;
               }
            ]),
            'alias' => 'fldDonatorID',
         ],
         'original_donators_id' => [
            'type' => Type::string(),
            'alias' => 'fldDonatorID',
         ],
         'firstname' => [
            'type' => Type::string(),
            'alias' => 'fldDonatorFirstName',
         ],
         'lastname' => [
            'type' => Type::string(),
            'alias' => 'fldDonatorLastName',
         ],
         'email' => [
            'type' => Type::string(),
            'alias' => 'fldDonatorEmailAddress',
         ],
         'country' => [
            'type' => Type::string(),
            'alias' => 'fldDonatorCountry',
         ],
         'payer_id' => [
            'type' => Type::string(),
            'alias' => 'fldDonatorPayerID',
         ],
         'date_created' => [
            'type' => Type::string(),
            'alias' => 'fldDonatorCreatedAt',
         ],
         'response_id' => [
            'type' => Type::string(),
            'alias' => 'fldDonatorDonateResponseID',
         ],
         'transactions_obj' => [
            'type' => GraphQL::type('transactions_type'),
         ],
      ];
   }
}