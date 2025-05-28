<?php

namespace App\GraphQL\Types;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\CustomScalarType;
use Crypt;

class TransactionsType extends GraphQLType
{

   protected $attributes = [
      'name' =>  'transactions record ',
      'description' => 'A response transactions response'
   ];

   public function fields(): array
   {
      return [

         'donate_id' => [
            'type' => new CustomScalarType([
               'name' => 'donate_encrypted_id',
               'serialize' => function ($value) {
                  $result = Crypt::encryptString($value);
                  return $result;
               }
            ]),
            'alias' => 'fldDonateID',
         ],
         'original_donate_id' => [
            'type' => Type::string(),
            'alias' => 'fldDonateID',
         ],
         'amount' => [
            'type' => Type::string(),
            'alias' => 'fldDonateAmount',
         ],
         'status' => [
            'type' => Type::string(),
            'alias' => 'fldDonateStatus',
         ],
         'token' => [
            'type' => Type::string(),
            'alias' => 'fldDonateURLToken',
         ],
         'response_id' => [
            'type' => Type::string(),
            'alias' => 'fldDonateResponseID',
         ],
         'api_response' => [
            'type' => new CustomScalarType([
               'name' => 'unserialized_api_response',
               'serialize' => function ($value) {
                  $result = json_decode($value);
                  return $result;
               }
            ]),
            'alias' => 'fldDonateAPIResponse',
         ],
         'date_created' => [
            'type' => Type::string(),
            'alias' => 'fldDonateCreatedAt',
         ],
         'date_updated' => [
            'type' => Type::string(),
            'alias' => 'fldDonateUpdatedAt',
         ],
         'donator' => [
            'type' => GraphQL::type('donators_type'),
         ],
      ];
   }
}