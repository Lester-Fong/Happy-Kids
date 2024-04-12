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
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaypalModel extends Eloquent {

    
     public function onProcessPayment($data) {
        $response_obj = new \stdClass();
        
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->setCurrency('PHP');
        
        $access_token = $provider->getAccessToken();

        // get root url
        $root_url = Request::root();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "PHP",
                        "value" => $data['amount']
                    ]
                ]
                    ],
            "application_context" => [
                "cancel_url" => $root_url . "/paypal/cancel",
                "return_url" => $root_url . "/paypal/success"
            ]
        ]);

        Log::debug(print_r('onDonate $response', true));
        Log::debug(print_r($response, true));


        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $key => $link) {
                if ($link['rel'] == 'approve') {
                    $approve_url = $link['href'];
                }
            }

            
            $response_obj->error = false;
            $response_obj->href = $approve_url;
            $response_obj->status = $response['status'];
            $response_obj->id = $response['id'];
            $response_obj->message = 'Payment request has been created successfully';
            $response_obj->response = $response;
        } else {
            $response_obj->error = true;
            $response_obj->response = $response;
            $response_obj->status = $response['status'] ?? 'FAILED';
            $response_obj->message = 'Payment failed, please try again';
        }
        

        return $response_obj;
    }
    

     public function onCapturePaymentOrder($data) {
        $response_obj = new \stdClass();

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $access_token = $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($data['token']);

        Log::debug(print_r('capturePaymentOrder $response', true));
        Log::debug(print_r($response, true));


        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $response_obj->error = false;
            $response_obj->response = $response;
            $response_obj->status = $response['status'];
            $response_obj->payer = $response['payer'];
        } else {
            $response_obj->error = true;
            $response_obj->response = $response;
            $response_obj->status = $response['status'] ?? 'FAILED';
        }

        return $response_obj;
    }

}
