<?php

namespace App\GraphQL\Types;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\CustomScalarType;
use Crypt;

class ResponseType extends GraphQLType
{

    protected $attributes = [
        'name' =>  'response types',
        'description' => 'A global response'
    ];

    public function fields(): array
    {
        return [
            'error' => [
                'type' => Type::boolean(),
            ],
            'message' => [
                'type' => Type::string(),
            ],

            'access_token' => [
                'type' => Type::string(),
            ],

            'refresh_token' => [
                'type' => Type::string(),
            ],

            'token_expiration' => [
                'type' => Type::string(),
            ],

            'reset_password_security' => [
                'type' => Type::string(),
            ],
            'admin' => [
                'type' => GraphQL::type('admin_type'),
            ],
        ];
    }
}
