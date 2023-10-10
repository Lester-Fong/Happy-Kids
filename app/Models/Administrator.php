<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Hash;
use Config;
use Auth;
use Log;
use Crypt;
use Str;

class Administrator extends Authenticatable
{
    protected $table = 'tblAdministrator';
    protected $primaryKey = 'fldAdministratorID';
    public $timestamps = false;

    protected $fillable = [
        'fldAdministratorEmail',
        'fldAdministratorPassword',
        'fldAdministratorActive',
        'fldAdministratorFirstname',
        'fldAdministratorLastname',
        'fldAdministratorMobile',
    ];


    use HasApiTokens, Notifiable, HasFactory;


    public function findForPassport($username)
    {
        return $this->where('fldAdministratorEmail', $username)->first();
    }

    public function validateForPassportPasswordGrant($password)
    {
        return Hash::check($password, $this->fldAdministratorPassword);
    }


    public function checkAdministratorAccess($data)
    {

        $response_obj = new \stdClass();
        $administrator = $this->where('fldAdministratorEmail', $data['email'])->first();

        if ($administrator) {

            if (Hash::check($data['password'], $administrator->fldAdministratorPassword)) {

                // check if administrator is active
                if ($administrator->fldAdministratorActive == 0) {
                    $response_obj->error = true;
                    $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['ACCOUNT_INACTIVE'];
                    return $response_obj;
                }

                // check if administrator has access token
                $oauth_access_token_model = new OauthAccessTokens();
                $oauth_access_token_model->checkAdministratorAccessToken($administrator->fldAdministratorID);

                // grant access token
                $helper_token_model = new HelperToken();
                $decoded_response = $helper_token_model->generateAdminToken($administrator->fldAdministratorEmail, $data['password']);


                $token_expiration_date = date('Y-m-d H:i:s', strtotime('+ 60 minutes'));

                $response_obj->error = false;
                $response_obj->access_token = $decoded_response->access_token;
                $response_obj->refresh_token = $decoded_response->refresh_token;
                $response_obj->token_expiration = $token_expiration_date;
                $response_obj->admin = $administrator;
                $response_obj->message = "You successfully logged in.";
            }
        }

        return $response_obj;
    }
}
