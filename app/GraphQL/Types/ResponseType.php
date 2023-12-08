<?php

namespace App\GraphQL\Types;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\CustomScalarType;
use Crypt;

class ResponseType extends GraphQLType
{

    protected $attributes = [
        'name' =>  'response types',
        'description' => 'A global response'
    ];

    public function fields(): array
    {
        return [
            'error' => [
                'type' => Type::boolean(),
            ],
            'message' => [
                'type' => Type::string(),
            ],
            'access_token' => [
                'type' => Type::string(),
            ],
            'refresh_token' => [
                'type' => Type::string(),
            ],
            'token_expiration' => [
                'type' => Type::string(),
            ],
            'reset_password_security' => [
                'type' => Type::string(),
            ],
            'filename' => [
                'type' => Type::string(),
            ],
            'blogs' => [
                'type' =>  Type::listOf(GraphQL::type('blogs_type')),
             ],
            'single_blog' => [
                'type' =>  GraphQL::type('blogs_type'),
             ],
             'related_blogs' => [
                'type' =>  Type::listOf(GraphQL::type('blogs_type')),
             ],
             'latest_posts' => [
                'type' =>  Type::listOf(GraphQL::type('blogs_type')),
             ],
            'blog_category' => [
                'type' => Type::listOf(GraphQL::type('blog_category_type')),
            ],
            'events' => [
                'type' => Type::listOf(GraphQL::type('events_type')),
            ],
            'admin' => [
                'type' => GraphQL::type('admin_type'),
            ],
            'pages' => [
                'type' => GraphQL::type('pages_type'),
            ],
            'testimonials' => [
                'type' =>  Type::listOf(GraphQL::type('testimonial_type')),
            ],
            'faq' => [
                'type' =>  Type::listOf(GraphQL::type('faq_type')),
            ],
            'team' => [
                'type' =>  Type::listOf(GraphQL::type('team_type')),
            ],
        ];
    }
}
