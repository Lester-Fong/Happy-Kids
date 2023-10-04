<?php


namespace App\GraphQL\Inputs;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class AdministratorInput extends InputType
{


    protected $attributes = [
        'name' => 'AdministratorInput',
        'description' => 'Administrator information'
    ];

    public function fields(): array
    {
        return [
            'admin_id' => [
                'type' => Type::string(),
            ],
            'firstname' => [
                'type' => Type::string(),
            ],
            'lastname' => [
                'type' => Type::string(),
            ],
            'email' => [
                'type' => Type::string(),
            ],
            'mobile' => [
                'type' => Type::string(),
            ],
            'password' => [
                'type' => Type::string(),
            ],
            'action_type' => [
                'type' => Type::string(),
            ],
            'status' => [
                'type' => Type::string(),
            ],
            'otp' => [
                'type' => Type::string(),
            ],
            'security_token' => [
                'type' => Type::string(),
            ],
            'administrator_id' => [
                'type' => Type::string(),
            ],
            'confirm_password' => [
                'type' => Type::string(),
            ],
            'status' => [
                'type' => Type::int(),
            ],
            'security' => [
                'type' => Type::string(),
            ],
            'dashboard_widget' => [
                'type' => Type::listOf(Type::boolean()),
            ],
        ];
    }
}
