<?php

namespace App\GraphQL\Types;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\CustomScalarType;
use Crypt;

class BlogType extends GraphQLType
{

   protected $attributes = [
      'name' =>  'blog  record ',
      'description' => 'A response blog  response'
   ];

   public function fields(): array
   {
      return [

         'blogs_id' => [
            'type' => new CustomScalarType([
               'name' => 'blog_encrypted_id',
               'serialize' => function ($value) {
                  $result = Crypt::encryptString($value);
                  return $result;
               }
            ]),
            'alias' => 'fldBlogID',
         ],
         'original_blogs_id' => [
            'type' => Type::string(),
            'alias' => 'fldBlogID',
         ],

         'title' => [
            'type' => Type::string(),
            'alias' => 'fldBlogTitle',
         ],
         'description' => [
            'type' => Type::string(),
            'alias' => 'fldBlogDescription',
         ],
         'image' => [
            'type' => Type::string(),
            'alias' => 'fldBlogImage',
         ],
         'thumbnail' => [
            'type' => Type::string(),
            'alias' => 'fldBlogThumbnail',
         ],
         'thumbnail_webp' => [
            'type' => new CustomScalarType([
               'name' => 'blog_cover_image_webp',
               'serialize' => function ($value) {
                  $image_arr = explode(".", $value);
                  return $image_arr[0] . '.webp';
               }
            ]),
            'alias' => 'fldBlogCoverImage',
         ],
         'meta' => [
            'type' => new CustomScalarType([
               'name' => 'blog_unserialize_meta',
               'serialize' => function ($value) {
                  $result = unserialize($value);
                  return $result;
               }
            ]),
            'alias' => 'fldBlogMeta',
         ],
         'date' => [
            'type' => Type::string(),
            'alias' => 'fldBlogDate',
         ],
         'category_id' => [
            'type' => Type::string(),
            'alias' => 'fldBlogCategoryID',
         ],
         'slug' => [
            'type' => Type::string(),
            'alias' => 'fldBlogSlug',
         ],
         'status' => [
            'type' => Type::string(),
            'alias' => 'fldBlogStatus',
         ],
         'author' => [
            'type' =>  GraphQL::type('admin_type'),
         ],
         'blog_category' => [
            'type' =>  GraphQL::type('blog_category_type'),
         ],
      ];
   }
}