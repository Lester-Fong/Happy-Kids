<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\Models\Pages;
use App\Models\Customer;
use App\Models\Helper;


use Str;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\UploadType;
use Log;
use Hash;
use Config;
use Crypt;

class PagesMutation extends Mutation
{

    protected $attributes = [
        'name' => 'PagesMutation'
    ];


    public function args(): array
    {
        return [
            'page' => ['type' => GraphQL::type('page_input')],
            'file' => ['type' => GraphQL::type('Upload')],
            'file1' => ['type' => GraphQL::type('Upload')],
            'file2' => ['type' => GraphQL::type('Upload')],
            'file3' => ['type' => GraphQL::type('Upload')],
            'file4' => ['type' => GraphQL::type('Upload')],
            'file5' => ['type' => GraphQL::type('Upload')],
            'file6' => ['type' => GraphQL::type('Upload')],
            'file7' => ['type' => GraphQL::type('Upload')],
            'file8' => ['type' => GraphQL::type('Upload')],
            'file9' => ['type' => GraphQL::type('Upload')],
            'file10' => ['type' => GraphQL::type('Upload')],
            'file11' => ['type' => GraphQL::type('Upload')],
            'objectiveImages' => ['type' => Type::listOf(GraphQL::type('Upload'))],
        ];
    }

    public function type(): Type
    {
        return GraphQL::type('response_type');
    }


    public function validationErrorMessages(array $args = []): array
    {
        return [
            'page.title.required' => 'Please enter page title',
            'page.header.required' => 'Please enter page header title',
            'page.meta_title.required' => 'Please enter page meta title',
            'page.meta_keywords.required' => 'Please enter page meta keywords',
            'page.meta_description.required' => 'Please enter page meta description',
        ];
    }

    public function rules(array $args = []): array
    {
        $rules = [];

        $page = $args['page'];

        Log::debug(print_r($args, true));



        if ($page['action_type'] == "new_record" || $page['action_type'] == "update_record") {
            $rules['page.title'] = ['required'];
            $rules['page.header'] = ['required'];
            $rules['page.meta_title'] = ['required'];
            $rules['page.meta_keywords'] = ['required'];
            $rules['page.meta_description'] = ['required'];
        }



        return $rules;
    }


    public function resolve($root, $args)
    {

        $page = $args['page'];
        $response_obj = new \stdClass();
        $page_model = new Pages();
        $helper_model = new Helper();

        if ($page['action_type'] == "new_record") {

            $page_id = $page_model->addUpdateRecord(0, $page, $args);

            $file = $args['file'];
            $file1 = $args['file1'];
            $file2 = $args['file2'];
            if ($file != "") {
                $filename = $helper_model->ImageUpload($file, $page_id, "pages");
                $page_rec = $page_model->find($page_id);
                if ($page_rec) {
                    $page_rec->fldPagesHeaderImage = $filename;
                    $page_rec->save();
                }
            }

            if ($file1 != "") {
                $filename = $helper_model->ImageUpload($file1, $page_id, "pages");
                $page_rec = $page_model->find($page_id);
                if ($page_rec) {
                    $page_rec->fldPagesImage1 = $filename;
                    $page_rec->save();
                }
            }

            if ($file2 != "") {
                $filename = $helper_model->ImageUpload($file2, $page_id, "pages");
                $page_rec = $page_model->find($page_id);
                if ($page_rec) {
                    $page_rec->fldPagesImage2 = $filename;
                    $page_rec->save();
                }
            }

            $response_obj->error = false;
            $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];
        }

        if ($page['action_type'] == "update_record") {

            $page_id = Crypt::decryptString($page["page_id"]);

            $page_rec = $page_model->find($page_id);

            if ($page_rec) {
                $page_model->addUpdateRecord($page_id, $page, $args);

                $file = $args['file'];
                if ($file != "") {
                    $filename = $helper_model->ImageUpload($file, $page_id, "pages");
                    $page_rec = $page_model->find($page_id);
                    if ($page_rec) {
                        $page_rec->fldPagesHeaderImage = $filename;
                        $page_rec->save();
                    }
                }

                $response_obj->error = false;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_SUCCESSFUL'];
            } else {
                $response_obj->error = false;
                $response_obj->message = Config::get('Constants.ERROR_MESSAGE')['RECORD_NOT_FOUND'];
            }
        }

        return $response_obj;
    }
}
