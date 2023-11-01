<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\Models\Administrator;


use Str;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\UploadType;
use Log;
use Hash;
use Config;
use Crypt;

class AdministratorMutation extends Mutation
{

    protected $attributes = [
        'name' => 'AdministratorMutation'
    ];


    public function args(): array
    {
        return [
            'admin' => ['type' => GraphQL::type('admin_input')],
            // 'file' => ['type' => GraphQL::type('Upload')]
        ];
    }

    public function type(): Type
    {
        return GraphQL::type('response_type');
    }


    public function validationErrorMessages(array $args = []): array
    {
        return [
            'admin.firstname.required' => 'Please enter your firstname',
            'admin.lastname.required' => 'Please enter your lastname',
            'admin.mobile.required' => 'Please enter your mobile no',
            'admin.administrator_id.required' => 'Please enter administrator id',
            'admin.status.required' => 'Please enter your status',
            'admin.email.required' => 'Please enter your email',
            'admin.email.email' => 'Please enter your valid email address',
            'admin.email.unique' => 'Email address already in used',
            'admin.password.required' => 'Please enter your password',
            'admin.password.min' => 'Password must be at least 8 characters in length',
            'admin.password.regex' => 'Password must be at least one lowercase, uppercase, digit and character',
            'admin.contact_no.required' => 'Please enter your contact no',
            'admin.activation_code.required' => 'Please enter your activation code',
            'file.max' => 'Please upload an image file with maximum size of 10MB',
            'admin.incentives.required' => 'Please enter incentives',
            'admin.leadCredits.required' => 'Please enter lead credits',
        ];
    }

    public function rules(array $args = []): array
    {
        $rules = [];

        $admin = $args['admin'];

        if ($admin['action_type'] == "login") {
            $rules['admin.email'] = ['required', 'email'];
            $rules['admin.password'] = ['required'];
        } else if ($admin["action_type"] == "check_email_address" || $admin["action_type"] == "generate_otp") {
            $rules['admin.email'] = ['required', 'email'];
        } else if ($admin["action_type"] == "validate_otp") {
            $rules['admin.email'] = ['required', 'email'];
            $rules['admin.otp'] = ['required'];
        } else if ($admin["action_type"] == "registration_information") {
            $rules['admin.firstname'] = ['required'];
            $rules['admin.lastname'] = ['required'];
            $rules['admin.mobile'] = ['required'];
            $rules['admin.password'] = ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&_]/'];
        } else if ($admin['action_type'] == "forgot_password") {
            $rules['admin.email'] = ['required', 'email'];
        } else if ($admin['action_type'] == "forgot_password_check_otp") {
            $rules['admin.email'] = ['required', 'email'];
            $rules['admin.otp'] = ['required'];
        } else if ($admin['action_type'] == "reset_password") {
            $rules['admin.email'] = ['required', 'email'];
            $rules['admin.password'] = ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&_]/'];
            $rules['admin.confirm_password'] = ['required', 'same:admin.password'];
        } else if ($admin['action_type'] == "new_record") {
            $rules['admin.firstname'] = ['required'];
            $rules['admin.lastname'] = ['required'];
            $rules['admin.mobile'] = ['required'];
            $rules['admin.email'] = ['required', 'email', 'unique:tblAdministrator,fldAdministratorEmail'];
            $rules['admin.password'] = ['required', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&_]/'];
        } else if ($admin['action_type'] == "update_record") {
            $admin = $args['admin'];
            $admin_id = Crypt::decryptString($admin["administrator_id"]);

            $rules['admin.firstname'] = ['required'];
            $rules['admin.lastname'] = ['required'];
            $rules['admin.mobile'] = ['required'];
            $rules['admin.email'] = ['required', 'email', 'unique:tblAdministrator,fldAdministratorEmail,' . $admin_id . ',fldAdministratorID'];
        } else if ($admin["action_type"] == "change_status") {
            $rules['admin.administrator_id'] = ['required'];
            $rules['admin.status'] = ['required'];
        } else if ($admin['action_type'] == "profile") {
            $rules['admin.firstname'] = ['required'];
            $rules['admin.lastname'] = ['required'];
            $rules['admin.mobile'] = ['required'];

            $admin_id = $admin['admin_id'];

            $rules['admin.email'] = ['required', 'email', 'unique:tblAdministrator,fldAdministratorEmail,' . $admin_id . ',fldAdministratorID'];
            $rules['admin.password'] = ['min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&_]/'];
            $rules['file'] = ['max:10000'];
        } else if ($admin['action_type'] == "save_settings") {
            $rules['admin.incentives'] = ['required'];
            $rules['admin.leadCredits'] = ['required'];
        }



        return $rules;
    }


    public function resolve($root, $args)
    {

        $admin = $args['admin'];
        $response_obj = new \stdClass();

        $admin_model = new Administrator();


        if ($admin['action_type'] == "check_email_address") {
            $response_obj = $admin_model->checkAdministratorEmail($admin['email']);
        }

        if ($admin['action_type'] == "generate_otp") {
            $response_obj = $admin_model->generateOTPViaEmail($admin['email']);
        }

        if ($admin['action_type'] == "validate_otp") {
            $response_obj = $admin_model->checkOTPViaEmail($admin);
        }

        if ($admin['action_type'] == "registration_information") {
            $response_obj = $admin_model->registrationInformation($admin);
        }

        if ($admin['action_type'] == "login") {
            $response_obj = $admin_model->checkAdministratorAccess($admin);
        }


        if ($admin['action_type'] == "verify_email") {
            $response_obj = $admin_model->forgotPassword($admin['email']);
        }

        if ($admin['action_type'] == "forgot_password_check_otp") {
            $response_obj = $admin_model->forgotPasswordCheckOTP($admin);
        }

        if ($admin['action_type'] == "verify_security_code") {
            $response_obj = $admin_model->validateSecurityCode($admin['security']);
        }

        if ($admin['action_type'] == "reset_password") {
            $response_obj = $admin_model->resetPassword($admin);
        }


        if ($admin["action_type"] == "new_record") {
            $response_obj = $admin_model->AddUpdateRecord(0, $admin);
        }

        if ($admin["action_type"] == "update_record") {

            $admin_id = Crypt::decryptString($admin['administrator_id']);

            $administrator = Administrator::find($admin_id);

            if ($administrator) {
                $response_obj = $admin_model->AddUpdateRecord($admin_id, $admin);
            } else {
                $response_obj = new \stdClass();
                $response_obj->error = true;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_NOT_FOUND'];
            }
        }


        if ($admin["action_type"] == "change_status") {

            $response_obj = $admin_model->changeStatus($admin);
        }


        if ($admin['action_type'] == "profile") {
            $file = isset($args['file']) ? $args['file'] : "";

            $response_obj = $admin_model->saveProfile($admin, $file);
        }


        if ($admin['action_type'] == "update_dashboard_widget") {
            $response_obj = $admin_model->updateDashboardWidget($admin["dashboard_widget"]);
        }

        if ($admin['action_type'] == "save_settings") {
            $response_obj = $admin_model->saveSettings($admin["leadCredits"], $admin["incentives"]);
        }

        return $response_obj;
    }
}
