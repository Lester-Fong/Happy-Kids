<?php

namespace App\GraphQL\Types;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\CustomScalarType;
use Crypt;

class FaqType extends GraphQLType
{

    protected $attributes = [
        'name' =>  'faq record ',
        'description' => 'A response faq'
    ];

    public function fields(): array
    {
        return [

            'faq_id' => [
                'type' => new CustomScalarType([
                    'name' => 'faq_encrypted_id',
                    'serialize' => function ($value) {
                        $result = Crypt::encryptString($value);
                        return $result;
                    }
                ]),
                'alias' => 'fldFAQID',
            ],
            'original_faq_id' => [
                'type' => Type::string(),
                'alias' => 'fldFAQID',
            ],
            'question' => [
                'type' => Type::string(),
                'alias' => 'fldFAQQuestion',
            ],
            'answer' => [
                'type' => Type::string(),
                'alias' => 'fldFAQAnswer',
            ],

        ];
    }
}
