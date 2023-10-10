<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class OauthAccessTokens extends Eloquent
{

    protected $table = 'oauth_access_tokens';

    public function checkAdministratorAccessToken($admin_id)
    {
        $access_token = self::where('user_id', '=', $admin_id)->where('client_id', '=', 3)->first();
        if ($access_token) {
            $access_token->delete();
        }
    }
}
