<?php

namespace App\GraphQL\Inputs;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class SMSInput extends InputType
{


    protected $attributes = [
        'name' => 'SMSInput',
        'description' => 'Project sms information'
    ];

    public function fields(): array
    {
        return [
            'contact_numbers' => [
                'type' => Type::listOf(Type::string()),
            ],
            'message' => [
                'type' => Type::string(),
            ],
            'action_type' => [
                'type' => Type::string(),
            ],
            'sms_id' => [
                'type' => Type::string(),
            ],
        ];
    }
}
