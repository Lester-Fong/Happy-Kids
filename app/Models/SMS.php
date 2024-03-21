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
use Illuminate\Support\Facades\Config;

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
        $semaphore = Config::get('Constants.SEMAPHORE');
        Log::debug(print_r($data['contact_numbers'], true));
        $client = new Client();

        $response = $client->post('http://api.semaphore.co/api/v4/messages', [
            'form_params' => [
                'apikey' => $semaphore['API_KEY'],
                'number' => implode(',', $data['contact_numbers']),
                'message' => $data['message'],
            ]
        ]);

        $response = json_decode($response->getBody()->getContents(), true);
        Log::debug(print_r($response, true));
        dd('test');

        $sms->fldSMSTransactionMessage = $data['message'];
        $sms->fldSMSTransactionContactIDs = json_encode($data['contact_numbers']);
        $sms->fldSMSTransactionSenderID = $admin_sender->fldAdministratorID;

        $sms->save();
        return $sms->fldSMSTransactionID;
    }
}
