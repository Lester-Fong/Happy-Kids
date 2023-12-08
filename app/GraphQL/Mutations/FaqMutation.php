<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\Models\Faq;
use App\Models\Helper;


use Str;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Log;
use Hash;
use Config;
use Crypt;

class FaqMutation extends Mutation
{

    protected $attributes = [
        'name' => 'FaqMutation'
    ];


    public function args(): array
    {
        return [
            'faq' => ['type' => GraphQL::type('faq_input')]
        ];
    }

    public function type(): Type
    {
        return GraphQL::type('response_type');
    }


    public function validationErrorMessages(array $args = []): array
    {
        return [
            'faq.faq_question.required' => 'Please enter faq question',
            'faq.faq_answer.required' => 'Please enter faq answer',
        ];
    }

    public function rules(array $args = []): array
    {
        $rules = [];

        $faq = $args['faq'];

        if ($faq['action_type'] == "add" || $faq['action_type'] == "update") {
            $rules['faq.faq_question'] = ['required'];
            $rules['faq.faq_answer'] = ['required'];
        }




        return $rules;
    }


    public function resolve($root, $args)
    {

        $faq = $args['faq'];
        $response_obj = new \stdClass();

        $helper_model = new Helper();
        $faq_model = new Faq();

        if ($faq['action_type'] == "add") {


            $faq_id = $faq_model->AddUpdateRecord(0, $faq);


            $response_obj->error = false;
            $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];
        }

        if ($faq['action_type'] == "update") {


            $faq_id = Crypt::decryptString($faq['faq_id']);

            $faq_modelc = $faq_model->findFaq($faq_id);

            if ($faq_model) {
                $faq_id = $faq_model->AddUpdateRecord($faq_id, $faq);



                $response_obj->error = false;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];
            } else {
                $response_obj->error = true;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_NOT_FOUND'];
            }
        }

        if ($faq['action_type'] == "delete_record") {

            $faq_id = Crypt::decryptString($faq['faq_id']);
            $faq_rec = Faq::find($faq_id);

            if ($faq_rec) {
                $faq_rec->delete();

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
