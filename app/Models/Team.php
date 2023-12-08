<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Image;
use File;
use Validator;
use Request;
use Input;
use Config;
use Hash;
use Session;
use Log;
use Crypt;
use DB;
use Dompdf\Dompdf;
use View;
use Str;
use Illuminate\Support\Arr;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth2;


class Team extends Eloquent
{

    protected $table = 'tblTeam';
    protected $primaryKey = 'fldTeamID';
    public $timestamps = false;


    public function findTeam($id)
    {
        $category = self::find($id);
        return $category;
    }

    public function displayAllTeam()
    {
        $category = self::orderBy('fldTeamID', 'DESC')->get();
        return $category;
    }

    public function displayTeamByID($id)
    {
        $team_id = Crypt::decryptString($id);
        $team = self::where('fldTeamID', '=', $team_id)->get();
        return $team;
    }

    public function AddUpdateRecord($id, $data)
    {
        if ($id == 0) {
            $team = new self;
        } else {
            $team = self::find($id);
        }

        $team->fldTeamName = $data['name'];
        $team->fldTeamPosition = $data['position'];
        $team->fldTeamType = $data['type'];

        $team->save();


        return $team->fldTeamID;
    }
}
