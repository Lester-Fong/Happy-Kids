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
use Illuminate\Support\Carbon;

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

    public function forgotPassword($email)
    {

        $response_obj = new \stdClass();

        $administrator_rec = self::where('fldAdministratorEmail', '=', $email)->first();

        if ($administrator_rec) {

            $one_time_pin = random_int(100000, 999999);
            $date = Carbon::now()->format('Y-m-d H:i:s');
            $carbonDate = Carbon::parse($date)->addMinutes(10);

            $administrator_rec->fldAdministratorForgotPasswordOTP = $one_time_pin;
            $administrator_rec->fldAdministratorForgotPasswordOTPExpirationDate = $carbonDate;
            $administrator_rec->save();

            $response_obj->error = false;
            $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['FORGOT_PASSWORD_SUCCESSFUL'];


            $helper_model = new Helper();
            $from = "noreply@happykids.edu.ph";
            $from_name = "HappyKids";
            $to_name = $administrator_rec->fldAdministratorFirstname;
            $subject = "🔒 Happy Kids - Forgot Password";
            $full_name = $administrator_rec->fldAdministratorFirstname . ' ' . $administrator_rec->fldAdministratorLastname;

            $cc = [];
            $data_obj = [
                'name' => $full_name,
                'subject' => $subject,
                'content' => "<h3>Hi $full_name,</h3><p style='text-align: center;''><strong style='font-size:32px;line-height:32px;letter-spacing: 16px;'>" . $one_time_pin . "</strong></p>
                            <p style='text-align: center !important;'>
                                Valid for <strong>10 mins.</strong> NEVER share this code, including Happy Kids admins.<br>
                            </p>
                            <p style='font-size: 14px; text-align: justify; line-height: 20px;'>
                                Your account can’t be accessed without this verification code, even if you didn’t submit this request. <br><br>
                                To keep your account secure, we recommend using a unique password for your Happy Kids account to sign in.
                                <br><br><br> If you have any questions, please contact Support.
                            </p>"
            ];

            $helper_model->sendEmail($email, $from, $to_name, $from_name, $subject, $cc, $data_obj);
        } else {
            $response_obj->error = true;
            $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['EMAIL_ADDRESS_NOT_FOUND'];
        }

        return $response_obj;
    }

    public function forgotPasswordCheckOTP($administrator)
    {

        $response_obj = new \stdClass();


        $administrator_rec = self::where('fldAdministratorEmail', '=', $administrator['email'])
            ->where('fldAdministratorForgotPasswordOTP', '=', $administrator['otp'])
            ->first();

        if ($administrator_rec) {
            $current_date = Carbon::now()->format('Y-m-d H:i:s');
            if ($current_date > $administrator_rec->fldAdministratorForgotPasswordOTPExpirationDate) {

                $response_obj->error = true;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['OTP_EXPIRED'];
                return $response_obj;
            } else {

                $security = Str::random(200);
                $administrator_rec->fldAdministratorSecurity = $security;
                $administrator_rec->save();

                $response_obj->error = false;
                $response_obj->reset_password_security = $security;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['OTP_VALID'];
            }
        } else {
            $response_obj->error = true;
            $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['OTP_INVALID'];
        }

        return $response_obj;
    }

    public function validateSecurityCode($security)
    {
        $response_obj = new \stdClass();

        $administrator_rec = self::where('fldAdministratorSecurity', '=', $security)->first();

        if ($administrator_rec) {
            $response_obj->error = false;
        } else {
            $response_obj->error = true;
            $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['INVALID_SECURITY_CODE'];
        }

        return $response_obj;
    }

    public function resetPassword($administrator)
    {

        $email = $administrator['email'];
        $password = $administrator['password'];
        $security = $administrator['security'];
        $response_obj = new \stdClass();

        if ($security == "") {
            $response_obj->error = true;
            $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RESET_PASSWORD_SECURITY_ERROR'];
        } else {
            $administrator_rec = self::where('fldAdministratorEmail', '=', $email)
                ->where('fldAdministratorSecurity', '=', $security)->first();

            if ($administrator_rec) {
                $administrator_rec->fldAdministratorPassword = Hash::make($password);
                $administrator_rec->fldAdministratorSecurity = "";
                $administrator_rec->save();

                $response_obj->error = false;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RESET_PASSWORD_SUCCESSFUL'];


                // Email -- Todo!
                // $helper_model = new Helper();
                // $from = Config::get('Constants.SERVICIO_EMAIL');
                // $from_name = "Servicio";
                // $to_name = $administrator_rec->fldAdministratorFirstname;
                // $subject = "Your Servicio password has changed";
                // $cc = [];
                // $data_obj = ['is_email' => 'admin'];
                // $data_obj['name'] = $administrator_rec->fldAdministratorFirstname . ' ' . $administrator_rec->fldAdministratorLastname;
                // $data_obj['subject'] = "Your Servicio password has changed";
                // $data_obj['content'] = "	Recently your Servicio password has changed. 	If you didn’t request this password change please contact the Partner support team.";
                // $helper_model->sendEmail($email, $from, $to_name, $from_name, $subject, $cc, $data_obj);
            } else {
                $response_obj->error = true;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['EMAIL_ADDRESS_NOT_FOUND'] .  ' or ' . Config::get('Constants.ERROR_MESSAGE')['INVALID_SECURITY_CODE'];
            }
        }
        return $response_obj;
    }


    public function checkAdministratorAccess($data)
    {

        $response_obj = new \stdClass();
        $administrator = $this->where('fldAdministratorEmail', $data['email'])->first();

        if ($administrator) {

            if (Hash::check($data['password'], $administrator->fldAdministratorPassword)) {

                // check if administrator is active
                // if ($administrator->fldAdministratorActive == 0) {
                //     $response_obj->error = true;
                //     $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['ACCOUNT_INACTIVE'];
                //     return $response_obj;
                // }

                // check if administrator has access token
                $oauth_access_token_model = new OauthAccessTokens();
                $oauth_access_token_model->checkAdministratorAccessToken($administrator->fldAdministratorID);

                // grant access token
                $helper_token_model = new HelperToken();
                $decoded_response = $helper_token_model->generateAdminToken($administrator->fldAdministratorEmail, $data['password']);


                $token_expiration_date = Carbon::now()->addHour()->format('Y-m-d H:i:s');

                $response_obj->error = false;
                $response_obj->access_token = $decoded_response->access_token;
                $response_obj->refresh_token = $decoded_response->refresh_token;
                $response_obj->token_expiration = $token_expiration_date;
                $response_obj->admin = $administrator;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['SUCCESS_LOGIN'];
            } else {
                $response_obj->error = true;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['ERROR_LOGIN'];
            }
        }

        return $response_obj;
    }


    public function getInfo()
    {
        return Auth::user();
    }

    public function AddUpdateRecord($id, $data, $file)
    {
        $response_obj = new \stdClass();


        if ($id == 0) {
            $administrator = new self;
        } else {
            $administrator = self::find($id);
        }


        if ($administrator) {
            if ($data['password'] != "") {
                $administrator->fldAdministratorPassword = Hash::make($data['password']);
            }

            $administrator->fldAdministratorEmail = $data['email'];
            $administrator->fldAdministratorFirstname = $data['firstname'];
            $administrator->fldAdministratorLastname = $data['lastname'];
            $administrator->fldAdministratorMobile = $data['mobile'];

            $administrator->save();
            $helper_model = new Helper();
            if ($file != null) {
                $filename = $helper_model->ImageUpload($file, $administrator->fldAdministratorID, 'admin_profile_image');
                Log::debug(print_r($filename, true));
                self::addUpdateAdminProfileImage($administrator->fldAdministratorID, $filename);
            }

            $response_obj->admin = $administrator;
            $response_obj->error = false;
            $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];

            return $response_obj;
        } else {
            $response_obj->error = true;
            $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['GLOBAL_ERROR_MESSAGE'];

            return $response_obj;
        }
    }

    public function addUpdateAdminProfileImage($admin_id, $filename)
    {
        $response_obj = new \stdClass();
        $admin = self::find($admin_id);

        if ($admin) {
            $admin->fldAdministratorProfileImage = $filename;
            $admin->save();
            $response_obj->error = false;
            $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];
        } else {
            $response_obj->error = true;
            $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_NOT_FOUND'];
        }

        return $response_obj;
    }

    public function displayAllAdmin()
    {
        $admin = self::orderBy('fldAdministratorFirstname', 'asc')->get();
        return $admin;
    }

    public function onDeleteRecord($data)
    {
        $response_obj = new \stdClass();
        $admin_id = Crypt::decryptString($data['administrator_id']);

        $admin = self::find($admin_id);

        if ($admin) {
            $admin->delete();
            $response_obj->error = false;
            $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_DELETED_SUCCESSFUL'];
        } else {
            $response_obj->error = true;
            $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_NOT_FOUND'];
        }

        return $response_obj;
    }
}
