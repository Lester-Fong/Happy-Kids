<?php

namespace App\GraphQL\Queries;

use Auth;
use App\Models\Faq;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Log;
use Request;

class FaqQuery extends Query
{

    protected $attributes = [
        'name' => 'The faq query',
        'description' => 'Retrieves faq',
    ];

    public function args(): array
    {
        return [
            'action_type' => ['type' => Type::string()],
            'faq_id' => ['type' => Type::string()],
        ];
    }

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('faq_type'));
    }

    public function resolve($root, $args)
    {

        $faq_model = new Faq();

        if ($args['action_type'] == "display_all") {
            $faq  = $faq_model->displayAllFaq();
        }

        if ($args['action_type'] == "display_by_id") {
            $faq  = $faq_model->displayFaqByID($args['faq_id']);
        }

        return $faq;
    }
}
