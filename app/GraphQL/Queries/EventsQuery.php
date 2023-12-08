<?php
 
namespace App\GraphQL\Queries;
use Auth;
use App\Models\Events;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Log;
use Request;

class EventsQuery extends Query {

    protected $attributes = [
        'name' => 'The events query',
        'description' => 'Retrieves events',
    ];

    public function args(): array {
        return [
            'action_type' => [ 'type' => Type::string()],
            'events_id' => [ 'type' => Type::string()],
        ];
    }

    public function type(): Type {
        return Type::listOf(GraphQL::type('events_type'));
    }

    public function resolve($root, $args) {

      $events_model = new Events();

      if($args['action_type'] == "display_all") {
        $events  = $events_model->displayAll();
      }

      if($args['action_type'] == "display_by_id") {
        $events  = $events_model->displayEventsByID($args['events_id']);
      }

      if($args['action_type'] == "check_and_set_expired") {
        $events  = $events_model->checkAndSetExpired();
      }



      return $events;

    }


}