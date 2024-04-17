<?php

namespace App\GraphQL\Queries;

use Auth;
use App\Models\Administrator;
use App\Models\Blog;
use App\Models\Donate;
use App\Models\Donator;
use App\Models\Pages;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Log;
use Request;
use Crypt;

class AdministratorQuery extends Query
{

    protected $attributes = [
        'name' => 'The administrator query',
        'description' => 'Retrieves administrator',
    ];

    public function args(): array
    {
        return [
            'action_type' => ['type' => Type::string()],
            'admin_id' => ['type' => Type::string()],
        ];
    }

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('admin_type'));
    }

    public function resolve($root, $args)
    {
        $admin_model = new Administrator();

        if ($args['action_type'] == "display_all") {
            $admin  = $admin_model->displayAllAdmin();
        }

        if ($args['action_type'] == "get_current_admin") {
            $admin[0] = $admin_model->getInfo();
        }

        if ($args['action_type'] == "get_admin_dashboard_data") {
            $blogs_model = new Blog();
            $page_model = new Pages();
            $donate_model = new Donate();
            $donator_model = new Donator();

            $admin[0] = $admin_model->getInfo();
            $response_obj = $admin[0];
            $response_obj->blogs = $blogs_model->displayAll();
            $response_obj->pages = $page_model->displayAll();
            $response_obj->transactions = $donate_model->displayRecentTransactions();
            $response_obj->donators = $donator_model->getDonatorOfTheMonth();
        }

        return $admin;
    }
}
