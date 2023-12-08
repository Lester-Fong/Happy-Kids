<?php

namespace App\GraphQL\Inputs;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class TeamInput extends InputType
{


    protected $attributes = [
        'name' => 'TeamInput',
        'description' => 'Project team information'
    ];

    public function fields(): array
    {
        return [
            'name' => [
                'type' => Type::string(),
            ],
            'position' => [
                'type' => Type::string(),
            ],
            'type' => [
                'type' => Type::string(),
            ],
            'action_type' => [
                'type' => Type::string(),
            ],
            'team_id' => [
                'type' => Type::string(),
            ],
        ];
    }
}
