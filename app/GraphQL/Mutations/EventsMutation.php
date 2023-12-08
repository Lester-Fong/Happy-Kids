<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\Models\Events;
use App\Models\Helper;


use Str;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Log;
use Hash;
use Config;
use Crypt;

class EventsMutation extends Mutation
{

  protected $attributes = [
    'name' => 'EventsMutation'
  ];


  public function args(): array
  {
    return [
      'events' => ['type' => GraphQL::type('events_input')],
      'file' => ['type' => GraphQL::type('Upload')],
    ];
  }

  public function type(): Type
  {
    return GraphQL::type('response_type');
  }


  public function validationErrorMessages(array $args = []): array
  {
    return [
      'events.title.required' => 'Please enter title',
      'events.date_start.required' => 'Please enter date start',
      'events.date_end.required' => 'Please enter date end',
      'events.location.required' => 'Please enter location',
    ];
  }

  public function rules(array $args = []): array
  {
    $rules = [];

    $events = $args['events'];

    if ($events['action_type'] == "new_record" || $events['action_type'] == "update_record") {
      // $rules['events.title'] = ['required'];
    }




    return $rules;
  }


  public function resolve($root, $args)
  {

    $events = $args['events'];
    $response_obj = new \stdClass();
    $events_model = new Events();
    $helper_model = new Helper();

    if ($events['action_type'] == "new_record") {
      $events_id = $events_model->AddUpdateRecord(0, $events);
      
      // file saving
      $file = $args['file'];
      if ($file != "") {
        $filename = $helper_model->ImageUpload2($file, $events_id, "events_image");
        $events_rec = $events_model->find($events_id);
        if ($events_rec) {
          $events_rec->fldEventsImage = $filename;
          $events_rec->save();
        }
      }

      $response_obj->error = false;
      $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];
    }


    if ($events['action_type'] == "upload_image_to_editor") {

      $file = $args['file1'];

      $filename = $helper_model->ImageUpload($file, 0, "events_image");
      $response_obj->error = false;
      $response_obj->filename = $filename;
    }

    if ($events['action_type'] == "update_record") {
      $events_id = Crypt::decryptString($events['events_id']);

      $events_rec = $events_model->findEvents($events_id);

      if ($events_rec) {
        $events_id = $events_model->AddUpdateRecord($events_id, $events);


        $file = $args['file'];
        if ($file != "") {
          $filename = $helper_model->ImageUpload2($file, $events_id, "events_image");
          $events_rec = $events_model->find($events_id);
          if ($events_rec) {
            $events_rec->fldEventsImage = $filename;
            $events_rec->save();
          }
        }

        $response_obj->error = false;
        $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];
      } else {
        $response_obj->error = true;
        $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_NOT_FOUND'];
      }
    }

    if ($events['action_type'] == "delete_record") {

      $events_id = Crypt::decryptString($events['events_id']);
      $event_rec = $events_model->find($events_id);

      if ($event_rec) {
        $event_rec->delete();

        $response_obj->error = false;
        $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_DELETED_SUCCESSFUL'];
      } else {
        $response_obj->error = true;
        $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_NOT_FOUND'];
      }
    }


    return $response_obj;
  }
}