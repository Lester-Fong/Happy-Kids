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


class Faq extends Eloquent
{

    protected $table = 'tblFAQ';
    protected $primaryKey = 'fldFAQID';
    public $timestamps = false;


    public function findFaq($id)
    {
        $faq = self::find($id);
        return $faq;
    }

    public function displayAllFaq()
    {
        $faq = self::get();
        return $faq;
    }

    public function displayFaqByID($id)
    {
        $faq_id = Crypt::decryptString($id);
        $faq = self::where('fldFAQID', '=', $faq_id)->get();
        return $faq;
    }

    public function AddUpdateRecord($id, $data)
    {
        if ($id == 0) {
            $faq = new self;
        } else {
            $faq = self::find($id);
        }

        $faq->fldFAQQuestion = $data['faq_question'];
        $faq->fldFAQAnswer = $data['faq_answer'];

        $faq->save();


        return $faq->fldFAQID;
    }
}
