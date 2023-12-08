<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\Models\Testimonial;
use App\Models\Helper;


use Str;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Log;
use Hash;
use Config;
use Crypt;

class TestimonialMutation extends Mutation
{

    protected $attributes = [
        'name' => 'TestimonialMutation'
    ];


    public function args(): array
    {
        return [
            'testimonial' => ['type' => GraphQL::type('testimonial_input')],
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
            'testimonial.name.required' => 'Please enter testimonial name',
            'testimonial.position.required' => 'Please enter testimonial position',
            'testimonial.description.required' => 'Please enter testimonial description',
        ];
    }

    public function rules(array $args = []): array
    {
        $rules = [];

        $testimonial = $args['testimonial'];

        if ($testimonial['action_type'] == "add" || $testimonial['action_type'] == "update") {
            $rules['testimonial.name'] = ['required'];
            $rules['testimonial.position'] = ['required'];
            $rules['testimonial.description'] = ['required'];
        }




        return $rules;
    }


    public function resolve($root, $args)
    {

        $testimonial = $args['testimonial'];
        $response_obj = new \stdClass();

        $helper_model = new Helper();
        $testimonial_model = new Testimonial();

        if ($testimonial['action_type'] == "add") {

            $testimonial_id = $testimonial_model->AddUpdateRecord(0, $testimonial);

            $file = $args['file'];
            if ($file != "") {
                $filename = $helper_model->ImageUpload($file, $testimonial_id, "testimonial");
                $testimonial_rec = Testimonial::find($testimonial_id);
                if ($testimonial_rec) {
                    $testimonial_rec->fldTestimonialsImage = $filename;
                    $testimonial_rec->save();
                }
            }

            $response_obj->error = false;
            $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];
        }

        if ($testimonial['action_type'] == "update") {


            $testimonial_id = Crypt::decryptString($testimonial['testimonial_id']);

            $testimonial_rec = $testimonial_model->findTestimonial($testimonial_id);

            if ($testimonial_rec) {
                $testimonial_id = $testimonial_model->AddUpdateRecord($testimonial_id, $testimonial);


                $file = $args['file'];
                if ($file != "") {
                    $filename = $helper_model->ImageUpload($file, $testimonial_id, "testimonial");
                    $testimonial_rec = Testimonial::find($testimonial_id);
                    if ($testimonial_rec) {
                        $testimonial_rec->fldTestimonialsImage = $filename;
                        $testimonial_rec->save();
                    }
                }

                $response_obj->error = false;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];
            } else {
                $response_obj->error = true;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_NOT_FOUND'];
            }
        }

        if ($testimonial['action_type'] == "delete_record") {

            $testimonial_id = Crypt::decryptString($testimonial['testimonial_id']);
            $testimonial_rec = Testimonial::find($testimonial_id);

            if ($testimonial_rec) {
                $testimonial_rec->delete();

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
