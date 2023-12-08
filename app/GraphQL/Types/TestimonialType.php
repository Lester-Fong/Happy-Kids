<?php

namespace App\GraphQL\Types;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\CustomScalarType;
use Crypt;

class TestimonialType extends GraphQLType
{

    protected $attributes = [
        'name' =>  'testimonial record ',
        'description' => 'A response testimonial response'
    ];

    public function fields(): array
    {
        return [

            'testimonial_id' => [
                'type' => new CustomScalarType([
                    'name' => 'testimonial_category_encrypted_id',
                    'serialize' => function ($value) {
                        $result = Crypt::encryptString($value);
                        return $result;
                    }
                ]),
                'alias' => 'fldTestimonialsID',
            ],
            'original_testimonial_id' => [
                'type' => Type::string(),
                'alias' => 'fldTestimonialsID',
            ],
            'name' => [
                'type' => Type::string(),
                'alias' => 'fldTestimonialsName',
            ],
            'position' => [
                'type' => Type::string(),
                'alias' => 'fldTestimonialsPosition',
            ],
            'description' => [
                'type' => Type::string(),
                'alias' => 'fldTestimonialsDescription',
            ],
            'image' => [
                'type' => Type::string(),
                'alias' => 'fldTestimonialsImage',
            ],
            'image_webp' => [
                'type' => new CustomScalarType([
                    'name' => 'testimonial_image_webp',
                    'serialize' => function ($value) {
                        $image_arr = explode(".", $value);
                        return $image_arr[0] . '.webp';
                    }
                ]),
                'alias' => 'fldTestimonialsImage',
            ],

        ];
    }
}
