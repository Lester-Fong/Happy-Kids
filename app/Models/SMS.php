<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Log;
use Crypt;
use DB;
use Str;
use Illuminate\Support\Arr;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth2;


class SMS extends Eloquent
{

    protected $table = 'tblSMSTransaction';
    protected $primaryKey = 'fldSMSTransactionID';
    public $timestamps = false;

    public function sender()
    {
        return $this->belongsTo('App\Models\Administrator', 'fldSMSTransactionSenderID', 'fldAdministratorID');
    }


    public function findSMS($id)
    {
        $sms = self::find($id);
        return $sms;
    }

    public function displayAllSMS()
    {
        $sms = self::orderBy('fldSMSTransactionID', 'DESC')->get();
        return $sms;
    }

    public function displaySMSByID($id)
    {
        $sms_id = Crypt::decryptString($id);
        $sms = self::where('fldSMSID', '=', $sms_id)->get();
        return $sms;
    }

    public function AddUpdateRecord($id, $data)
    {
        if ($id == 0) {
            $sms = new self;
        } else {
            $sms = self::find($id);
        }

        $administratorModel = new Administrator();
        $admin_sender = $administratorModel->getInfo();

        // Implement the SMS API here

        $sms->fldSMSTransactionMessage = $data['message'];
        $sms->fldSMSTransactionContactIDs = json_encode($data['contact_numbers']);
        $sms->fldSMSTransactionSenderID = $admin_sender->fldAdministratorID;

        $sms->save();
        return $sms->fldSMSTransactionID;
    }
}
