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
use PragmaRX\Google2FALaravel\Support\Constants;

class FrontMutation extends Mutation
{

    protected $attributes = [
        'name' => 'FrontMutation'
    ];


    public function args(): array
    {
        return [
            'front' => ['type' => GraphQL::type('front_input')],
        ];
    }

    public function type(): Type
    {
        return GraphQL::type('response_type');
    }


    public function validationErrorMessages(array $args = []): array
    {
        return [
            'front.message.required' => 'Please enter your message',
            'front.name.required' => 'Please enter your name',
            'front.email.required' => 'Please enter your email',
            'front.email.email' => 'Please enter a valid email',
            'front.phone.required' => 'Please enter your phone number',
            'front.phone.regex' => 'Please enter a valid phone number',
            'front.subject.required' => 'Please enter the email subject',
        ];
    }

    public function rules(array $args = []): array
    {
        $rules = [];

        $front = $args['front'];

        if ($front['action_type'] == "send_email") {
            $rules['front.message'] = ['required'];
            $rules['front.name'] = ['required'];
            $rules['front.email'] = ['required', 'email'];
            $rules['front.phone'] = ['required'];
            $rules['front.subject'] = ['required'];
        }
        return $rules;
    }


    public function resolve($root, $args)
    {

        $front = $args['front'];
        $response_obj = new \stdClass();
        $helper_model = new Helper();


        if ($front['action_type'] == "send_email") {
            //send email to support
            $logo_path = Config::get('Constants.LOGO_PATH');
            $message = $front['message'];
            $to = Config::get('Constants.SUPPORT_EMAIL');
            $from = $front['email'];
            $to_name = "Happy Kids Foundation";
            $from_name = $front['name'];
            $subject = $front['subject'];
            $cc = [];

            $data_obj = [
                'name' => $front['name'],
                'subject' => $front['subject'],
                'content' => "
                <p style='font-size: 14px; line-height: 20px;'>
                    $message
                </p>
                <br>
                <p style='font-size: 14px; line-height: 20px;'>
                    Regards, <br>
                    $from_name <br>
                    $from
                </p>
                "

            ];

            $response = $helper_model->sendEmail($to, $from, $to_name, $from_name, $subject, $cc, $data_obj);

            $response_obj->error = false;
            $response_obj->message = "Email sent successfully";
        }

        return $response_obj;
    }
}
