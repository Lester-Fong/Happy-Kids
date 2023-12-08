<?php

namespace App\GraphQL\Types;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\CustomScalarType;
use Crypt;

class PagesType extends GraphQLType
{

    protected $attributes = [
        'name' =>  'PagesType record ',
        'description' => 'A response PagesType response'
    ];

    public function fields(): array
    {
        return [

            'encrypted_pages_id' => [
                'type' => new CustomScalarType([
                    'name' => 'pages_encrypted_id',
                    'serialize' => function ($value) {
                        $result = Crypt::encryptString($value);
                        return $result;
                    }
                ]),
                'alias' => 'fldPagesID',
            ],
            'pages_id' => [
                'type' => Type::string(),
                'alias' => 'fldPagesID',
            ],
            'title' => [
                'type' => Type::string(),
                'alias' => 'fldPagesTitle',
            ],
            'description' => [
                'type' => new CustomScalarType([
                    'name' => 'pages_unserialize_description',
                    'serialize' => function ($value) {
                        $result = unserialize($value);
                        return $result;
                    }
                ]),
                'alias' => 'fldPagesDescription',
            ],
            'slug' => [
                'type' => Type::string(),
                'alias' => 'fldPagesSlug',
            ],
            'image' => [
                'type' => Type::string(),
                'alias' => 'fldPagesHeaderImage',
            ],
            'extras_image_1' => [
                'type' => Type::string(),
                'alias' => 'fldPagesImage1',
            ],
            'extras_image_2' => [
                'type' => Type::string(),
                'alias' => 'fldPagesImage2',
            ],
            'meta' => [
                'type' => new CustomScalarType([
                    'name' => 'pages_unserialize_meta',
                    'serialize' => function ($value) {
                        $result = unserialize($value);
                        return $result;
                    }
                ]),
                'alias' => 'fldPagesMetaInformation',
            ]
        ];
    }
}
