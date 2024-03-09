<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\Models\Blog;
use App\Models\Donate;
use App\Models\Helper;


use Str;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Log;
use Hash;
use Config;
use Crypt;

class DonateMutation extends Mutation
{

  protected $attributes = [
    'name' => 'DonateMutation'
  ];


  public function args(): array
  {
    return [
      'donate' => ['type' => GraphQL::type('donate_input')],
    ];
  }

  public function type(): Type
  {
    return GraphQL::type('response_type');
  }


  public function validationErrorMessages(array $args = []): array
  {
    return [
      'donate.amount.required' => 'Please enter or select amount',
    ];
  }

  public function rules(array $args = []): array
  {
    $rules = [];

    $donate = $args['donate'];

    if ($donate['action_type'] == "donate") {
      $rules['donate.amount'] = ['required'];
    }


    return $rules;
  }


  public function resolve($root, $args)
  {

    $donate = $args['donate'];
    $response_obj = new \stdClass();
    $donate_model = new Donate();
    $helper_model = new Helper();

    if ($donate['action_type'] == "donate") {
      $response_obj = $donate_model->onDonate($donate);
    }

    if ($donate['action_type'] == "success_capture") {
      if (isset($donate['token']) && $donate['token'] != null) {
        $response_obj = $donate_model->onCaptureSuccess($donate);

      } else {
        $response_obj->error = true;
        $response_obj->message = 'Invalid access';
      }
      
    } 




    return $response_obj;
  }

}