<?php

namespace App\GraphQL\Queries;

use Auth;
use App\Models\Team;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Log;
use Request;

class TeamQuery extends Query
{

    protected $attributes = [
        'name' => 'The team query',
        'description' => 'Retrieves team',
    ];

    public function args(): array
    {
        return [
            'action_type' => ['type' => Type::string()],
            'team_id' => ['type' => Type::string()],
        ];
    }

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('team_type'));
    }

    public function resolve($root, $args)
    {

        $team_model = new Team();

        if ($args['action_type'] == "display_all") {
            $team  = $team_model->displayAllTeam();
        }

        if ($args['action_type'] == "display_by_id") {
            $team  = $team_model->displayTeamByID($args['team_id']);
        }

        return $team;
    }
}
