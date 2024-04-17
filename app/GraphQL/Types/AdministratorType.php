<?php

namespace App\GraphQL\Types;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\CustomScalarType;
use Crypt;

class AdministratorType extends GraphQLType
{

    protected $attributes = [
        'name' =>  'administrator record',
        'description' => 'A response administrator response'
    ];

    public function fields(): array
    {
        return [

            'administrator_id' => [
                'type' => new CustomScalarType([
                    'name' => 'administrator_encrypted_id',
                    'serialize' => function ($value) {
                        $result = Crypt::encryptString($value);
                        return $result;
                    }
                ]),
                'alias' => 'fldAdministratorID',
            ],

            'administrator_regular_id' => [
                'type' => Type::string(),
                'alias' => 'fldAdministratorID',
            ],

            'firstname' => [
                'type' => Type::string(),
                'alias' => 'fldAdministratorFirstname',
            ],
            'lastname' => [
                'type' => Type::string(),
                'alias' => 'fldAdministratorLastname',
            ],
            'email' => [
                'type' => Type::string(),
                'alias' => 'fldAdministratorEmail',
            ],

            'mobile' => [
                'type' => Type::string(),
                'alias' => 'fldAdministratorMobile',
            ],
            'is_active' => [
                'type' => Type::int(),
                'alias' => 'fldAdministratorActive',
            ],
            'widget' => [
                'type' => new CustomScalarType([
                    'name' => 'admin_dashboard_widget_unserialized',
                    'serialize' => function ($value) {
                        $result = unserialize($value);
                        return $result;
                    }
                ]),
                'alias' => 'fldAdministratorWidget',
            ],
            'image' => [
                'type' => Type::string(),
                'alias' => 'fldAdministratorProfileImage',
            ],
            'registration_date' => [
                'type' => Type::string(),
                'alias' => 'fldAdministratorRegistrationDate',
            ],

            'blogs' => [
                'type' =>  Type::listOf(GraphQL::type('blogs_type')),
            ],
            'pages' => [
                'type' =>  Type::listOf(GraphQL::type('pages_type')),
            ],
            'transactions' => [
                'type' =>  Type::listOf(GraphQL::type('transactions_type')),
            ],
            'donators' => [
                'type' =>  Type::listOf(GraphQL::type('donators_type')),
            ],
        ];
    }
}
