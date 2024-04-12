<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\Models\SMS;
use App\Models\Helper;


use Str;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Log;
use Hash;
use Config;
use Crypt;

class SMSMutation extends Mutation
{

    protected $attributes = [
        'name' => 'SMSMutation'
    ];


    public function args(): array
    {
        return [
            'sms' => ['type' => GraphQL::type('sms_input')],
        ];
    }

    public function type(): Type
    {
        return GraphQL::type('response_type');
    }


    public function validationErrorMessages(array $args = []): array
    {
        return [
            'sms.message.required' => 'Please enter your sms message',
            'sms.contact_numbers.required' => 'Please enter sms recipient number/s',
        ];
    }

    public function rules(array $args = []): array
    {
        $rules = [];

        $sms = $args['sms'];

        if ($sms['action_type'] == "add" || $sms['action_type'] == "update") {
            $rules['sms.message'] = ['required'];
            // required length morethan 0 of the contact_number array
            $rules['sms.contact_numbers'] = ['required', 'array', 'min:1'];
        }
        return $rules;
    }


    public function resolve($root, $args)
    {

        $sms = $args['sms'];
        $response_obj = new \stdClass();
        $sms_model = new SMS();

        if ($sms['action_type'] == "create_message") {
            $sms_id = $sms_model->AddUpdateRecord(0, $sms);

            if ($sms_id) {
                $response_obj->error = false;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];
            } else {
                $response_obj->error = true;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_NOT_FOUND'];
            }
        }

        // if ($sms['action_type'] == "update") {


        //     $sms_id = Crypt::decryptString($sms['sms_id']);
        //     $sms_rec = $sms_model->find($sms_id);

        //     if ($sms_rec) {
        //         $sms_id = $sms_model->AddUpdateRecord($sms_id, $sms);


        //         $file = $args['file'];
        //         if ($file != "") {
        //             $filename = $helper_model->ImageUpload($file, $sms_id, "sms");
        //             $sms_rec = $sms_model->find($sms_id);
        //             if ($sms_rec) {
        //                 $sms_rec->fldSMSImage = $filename;
        //                 $sms_rec->save();
        //             }
        //         }

        //         $response_obj->error = false;
        //         $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];
        //     } else {
        //         $response_obj->error = true;
        //         $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_NOT_FOUND'];
        //     }
        // }

        // if ($sms['action_type'] == "delete_record") {

        //     $sms_id = Crypt::decryptString($sms['sms_id']);
        //     $sms_rec = $sms_model->find($sms_id);

        //     if ($sms_rec) {
        //         $sms_rec->delete();

        //         $response_obj->error = false;
        //         $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_DELETED_SUCCESSFUL'];
        //     } else {
        //         $response_obj->error = true;
        //         $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_NOT_FOUND'];
        //     }
        // }

        return $response_obj;
    }
}
