<?php


namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contacts\Auth\MustVerifyEmail;
use Laravel\Passport\Passport;
use GuzzleHttp\Client;

use Log;

class HelperToken extends Authenticatable
{

    use HasApiTokens, Notifiable;

    private $admin_client_secret = "Vx6qZSowNl8z75w5mkvKAhBIvu0oKWCtAf2LrNAh";

    public function generateAdminToken($email, $password)
    {
        $client = new Client;
        $form_params = [
          'grant_type' => 'password',
          'client_id' => '3',
          'client_secret' => $this->admin_client_secret,
          'username' => $email,
          'password' => $password,
          'scope' => '',
        ];
    
    
        $response = $client->post(url('oauth/token'), [
          'form_params' => $form_params,
        ])->getBody()->getContents();
    
    
        return json_decode($response);
    }


    public function refreshAdminToken($refresh_token)
    {

        $http = new Client;

        $form_parameters = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
            'client_id' => 3,
            'client_secret' => $this->admin_client_secret,
            'scope' => ''
        ];

        $response = $http->post(url('oauth/token'), [
            'form_params' => $form_parameters
        ])->getBody()->getContents();

        return json_decode($response);
    }
}
