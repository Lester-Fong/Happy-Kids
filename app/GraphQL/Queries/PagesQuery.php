<?php

namespace App\GraphQL\Queries;

use Log;
use Auth;
use App\Models\Pages;

use Crypt;
use GraphQL;
use Request;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class PagesQuery extends Query
{

    protected $attributes = [
        'name' => 'The pages query',
        'description' => 'Retrieves pages',
    ];

    public function args(): array
    {
        return [
            'action_type' => ['type' => Type::string()],
            'page_id' => ['type' => Type::string()],
        ];
    }

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('pages_type'));
    }

    public function resolve($root, $args)
    {

        $pages_model = new Pages();

        if ($args['action_type'] == "display_all_pages") {
            $pages  = $pages_model->displayAll();
        }

        if ($args['action_type'] == "display_single_page") {
            $pages  = $pages_model->displaySinglePage($args['page_id']);
        }

        return $pages;
    }
}
