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


class Donate extends Eloquent
{

    protected $table = 'tblDonate';
    protected $primaryKey = 'fldDonateID';
    public $timestamps = false;

    public function donator()
    {
        return $this->hasOne(Donator::class,'fldDonatorDonateResponseID', 'fldDonateResponseID' );
    }

    public function onDonate($data)
    {
        $paypal_model = new PaypalModel;

        $response = $paypal_model->onProcessPayment($data);

        if (!$response->error) {
            $donation = new self;
            $donation->fldDonateAmount = $data['amount'];
            $donation->fldDonateStatus = $response->status;
            $donation->fldDonateURLToken = $response->href;
            $donation->fldDonateResponseID = $response->id;
            $donation->fldDonateAPIResponse = json_encode($response->response);
            $donation->save();
        } else {
            $donation = new self;
            $donation->fldDonateAmount = $data['amount'];
            $donation->fldDonateStatus = $response->status;
            $donation->fldDonateAPIResponse = json_encode($response->response);
            $donation->save();
        }

        return $response;
    }

    public function onCaptureSuccess($data)
    {
        $paypal_model = new PaypalModel;
        $donator_model = new Donator;
        $api_response = $paypal_model->onCapturePaymentOrder($data);

        if (!$api_response->error) {
            $response = self::onUpdateResponseRecord($data['token'], $api_response);
            $donator_model->onSaveRecord($api_response->payer, $api_response->response['id']);
        } else {
            $response = self::onUpdateResponseRecord($data['token'], $api_response);
        }

        return $response;
    }


    public function onUpdateResponseRecord($token, $response)
    {
        $response_obj = new \stdClass();

        $donation = self::where('fldDonateResponseID', '=', $token)->first();

        if ($response->status == 'FAILED') {
            $donation = new self;
            $response_obj->error = true;
            $response_obj->message = 'Payment failed, please try again';
        } else {
            $response_obj->error = false;
            $response_obj->message = 'Payment has been process successfully';
        }

        if ($donation) {
            $donation->fldDonateAPIResponse = json_encode($response->response);
            $donation->fldDonateStatus = $response->status;
            $donation->fldDonateUpdatedAt = date('Y-m-d H:i:s');

            $donation->save();
        } else {
            $response_obj->error = true;
            $response_obj->message = 'Payment failed, please try again';
        }

        return $response_obj;
    }

    public function displayAll($date_from, $date_to)
    {
        if (empty($date_from) && empty($date_to)) {
            return self::with('donator')->orderBy('fldDonateCreatedAt', 'DESC')->get();
        } else {
            return self::with('donator')
                ->whereDate("fldDonateCreatedAt", '>=', $date_from)
                ->whereDate("fldDonateCreatedAt", '<=', $date_to)
                ->orderBy('fldDonateCreatedAt', 'DESC')
                ->get();
        }
    }
    // {
    //     return self::with('donator')->orderBy('fldDonateCreatedAt', 'DESC')
    //             ->whereDate("fldDonateCreatedAt");
    //             ->get();
    // }

    public function displayRecentTransactions()
    {
        return self::orderBy('fldDonateCreatedAt', 'DESC')->limit(5)->get();
    }
}
