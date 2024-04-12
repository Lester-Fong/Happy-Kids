<?php
 
namespace App\GraphQL\Queries;

use App\Models\Donate;
use Auth;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Log;
use Request;

class DonateQuery extends Query {

    protected $attributes = [
        'name' => 'The transactions query',
        'description' => 'Retrieves transactions',
    ];

    public function args(): array {
        return [
            'action_type' => [ 'type' => Type::string()],
            'donate_id' => [ 'type' => Type::string()],
        ];
    }

    public function type(): Type {
        return Type::listOf(GraphQL::type('transactions_type'));
    }

    public function resolve($root, $args) {

      $donate_model = new Donate();

      if($args['action_type'] == "display_all") {
        $record = $donate_model->displayAll();
      }


      return $record;

    }


}