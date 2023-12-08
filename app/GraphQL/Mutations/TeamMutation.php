<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\Models\Team;
use App\Models\Helper;


use Str;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Log;
use Hash;
use Config;
use Crypt;

class TeamMutation extends Mutation
{

    protected $attributes = [
        'name' => 'TeamMutation'
    ];


    public function args(): array
    {
        return [
            'team' => ['type' => GraphQL::type('team_input')],
            'file' => ['type' => GraphQL::type('Upload')],
        ];
    }

    public function type(): Type
    {
        return GraphQL::type('response_type');
    }


    public function validationErrorMessages(array $args = []): array
    {
        return [
            'team.name.required' => 'Please enter team name',
            'team.position.required' => 'Please enter team position',
            'team.type.required' => 'Please enter team type',
        ];
    }

    public function rules(array $args = []): array
    {
        $rules = [];

        $team = $args['team'];

        if ($team['action_type'] == "add" || $team['action_type'] == "update") {
            $rules['team.name'] = ['required'];
            $rules['team.position'] = ['required'];
            $rules['team.type'] = ['required'];
        }




        return $rules;
    }


    public function resolve($root, $args)
    {

        $team = $args['team'];
        $response_obj = new \stdClass();

        $helper_model = new Helper();
        $team_model = new Team();

        if ($team['action_type'] == "add") {

            $team_id = $team_model->AddUpdateRecord(0, $team);

            $file = $args['file'];
            if ($file != "") {
                $filename = $helper_model->ImageUpload($file, $team_id, "team");
                $team_rec = $team_model->find($team_id);
                if ($team_rec) {
                    $team_rec->fldTeamImage = $filename;
                    $team_rec->save();
                }
            }

            $response_obj->error = false;
            $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];
        }

        if ($team['action_type'] == "update") {


            $team_id = Crypt::decryptString($team['team_id']);
            $team_rec = $team_model->find($team_id);

            if ($team_rec) {
                $team_id = $team_model->AddUpdateRecord($team_id, $team);


                $file = $args['file'];
                if ($file != "") {
                    $filename = $helper_model->ImageUpload($file, $team_id, "team");
                    $team_rec = $team_model->find($team_id);
                    if ($team_rec) {
                        $team_rec->fldTeamImage = $filename;
                        $team_rec->save();
                    }
                }

                $response_obj->error = false;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];
            } else {
                $response_obj->error = true;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_NOT_FOUND'];
            }
        }

        if ($team['action_type'] == "delete_record") {

            $team_id = Crypt::decryptString($team['team_id']);
            $team_rec = $team_model->find($team_id);

            if ($team_rec) {
                $team_rec->delete();

                $response_obj->error = false;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_DELETED_SUCCESSFUL'];
            } else {
                $response_obj->error = true;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_NOT_FOUND'];
            }
        }

        return $response_obj;
    }
}
