<?php

namespace App\GraphQL\Queries;

use Auth;
use App\Models\SMS;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Log;
use Request;

class SMSQuery extends Query
{

    protected $attributes = [
        'name' => 'The sms query',
        'description' => 'Retrieves sms',
    ];

    public function args(): array
    {
        return [
            'action_type' => ['type' => Type::string()],
            'sms_id' => ['type' => Type::string()],
        ];
    }

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('sms_type'));
    }

    public function resolve($root, $args)
    {

        $sms_model = new SMS();

        if ($args['action_type'] == "display_all") {
            $sms  = $sms_model->displayAllSMS();
        }

        // if ($args['action_type'] == "display_by_id") {
        //     $sms  = $sms_model->displaySMSByID($args['sms_id']);
        // }

        return $sms;
    }
}
