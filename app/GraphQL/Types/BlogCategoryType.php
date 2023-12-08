<?php

namespace App\GraphQL\Types;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\CustomScalarType;
use Crypt;

class BlogCategoryType extends GraphQLType {

    protected $attributes = [
        'name' =>  'blog category record ',
        'description' => 'A response blog category response'
    ];

    public function fields(): array {
        return [

          'category_id' => [
            'type' => new CustomScalarType([
                   'name' => 'blog_category_encrypted_id',
                   'serialize' => function($value) {
                       $result = Crypt::encryptString($value);
                       return $result;
                   }
               ]),
             'alias' => 'fldBlogCategoryID',
          ],
          'original_category_id' => [
             'type' => Type::string(),
             'alias' => 'fldBlogCategoryID',
          ],

          'name' => [
             'type' => Type::string(),
             'alias' => 'fldBlogCategoryName',
          ],
          'description' => [
             'type' => Type::string(),
             'alias' => 'fldBlogCategoryDescription',
          ],
          'image' => [
            'type' => Type::string(),
             'alias' => 'fldBlogCategoryImage',
          ],
          'slug' => [
             'type' => Type::string(),
             'alias' => 'fldBlogCategorySlug',
          ],
          'meta' => [
            'type' => new CustomScalarType([
                   'name' => 'blog_category_unserialize_meta',
                   'serialize' => function($value) {
                       $result = unserialize($value);
                       return $result;
                   }
               ]),
             'alias' => 'fldBlogCategoryMeta',
          ],
          'blogs' => [
             'type' =>  Type::listOf(GraphQL::type('blogs_type')),
          ],

          'date_created' => [
            'type' => Type::string(),
             'alias' => 'fldBlogCategoryDateCreated',
          ]
        ];
    }


}
