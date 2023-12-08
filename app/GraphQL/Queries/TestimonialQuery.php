<?php

namespace App\GraphQL\Queries;

use Auth;
use App\Models\Testimonial;


use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Log;
use Request;

class TestimonialQuery extends Query
{

    protected $attributes = [
        'name' => 'The testimonial query',
        'description' => 'Retrieves testimonial',
    ];

    public function args(): array
    {
        return [
            'action_type' => ['type' => Type::string()],
            'testimonial_id' => ['type' => Type::string()],
        ];
    }

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('testimonial_type'));
    }

    public function resolve($root, $args)
    {

        $testimonial_model = new Testimonial();

        if ($args['action_type'] == "display_all") {
            $testimonial  = $testimonial_model->displayAllTestimonial();
        }

        if ($args['action_type'] == "display_by_id") {
            $testimonial  = $testimonial_model->displayTestimonialByID($args['testimonial_id']);
        }

        return $testimonial;
    }
}
