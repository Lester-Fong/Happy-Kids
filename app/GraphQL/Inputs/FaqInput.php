<?php

namespace App\GraphQL\Inputs;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class FaqInput extends InputType
{


    protected $attributes = [
        'name' => 'FaqInput',
        'description' => 'Project faq information'
    ];

    public function fields(): array
    {
        return [
            'faq_question' => [
                'type' => Type::string(),
            ],
            'faq_answer' => [
                'type' => Type::string(),
            ],
            'action_type' => [
                'type' => Type::string(),
            ],
            'faq_id' => [
                'type' => Type::string(),
            ],
        ];
    }
}
