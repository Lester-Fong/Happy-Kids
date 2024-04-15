<?php

namespace App\GraphQL\Inputs;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class FrontInput extends InputType
{


    protected $attributes = [
        'name' => 'FrontInput',
        'description' => 'Front information'
    ];

    public function fields(): array
    {
        return [
            'phone' => [
                'type' => Type::string(),
            ],
            'message' => [
                'type' => Type::string(),
            ],
            'action_type' => [
                'type' => Type::string(),
            ],
            'subject' => [
                'type' => Type::string(),
            ],
            'name' => [
                'type' => Type::string(),
            ],
            'email' => [
                'type' => Type::string(),
            ],
        ];
    }
}
