<?php

namespace App\GraphQL\Inputs;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class TestimonialInput extends InputType
{


    protected $attributes = [
        'name' => 'TestimonialInput',
        'description' => 'Project testimonial information'
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
            'description' => [
                'type' => Type::string(),
            ],
            'action_type' => [
                'type' => Type::string(),
            ],
            'testimonial_id' => [
                'type' => Type::string(),
            ],
        ];
    }
}
