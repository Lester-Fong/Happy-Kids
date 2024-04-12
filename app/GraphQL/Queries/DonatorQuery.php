<?php
 
namespace App\GraphQL\Queries;

use App\Models\Donator;
use Auth;
use App\Models\Events;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Log;
use Request;

class DonatorQuery extends Query {

    protected $attributes = [
        'name' => 'The donators query',
        'description' => 'Retrieves donators',
    ];

    public function args(): array {
        return [
            'action_type' => [ 'type' => Type::string()],
            'donators_id' => [ 'type' => Type::string()],
        ];
    }

    public function type(): Type {
        return Type::listOf(GraphQL::type('donators_type'));
    }

    public function resolve($root, $args) {

      $donators_model = new Donator();

      if($args['action_type'] == "display_all") {
        $events  = $donators_model->displayAll();
      }


      return $events;

    }


}