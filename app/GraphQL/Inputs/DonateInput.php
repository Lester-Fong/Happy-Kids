<?php

namespace App\GraphQL\Inputs;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class DonateInput extends InputType
{


    protected $attributes = [
        'name' => 'DonateInput',
        'description' => 'Donation information'
    ];

    public function fields(): array
    {
        return [
            'amount' => [
                'type' => Type::int(),
            ],
            'token' => [
                'type' => Type::string(),
            ],
            'action_type' => [
                'type' => Type::string(),
            ],
        ];
    }
}
