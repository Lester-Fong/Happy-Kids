<?php

namespace App\GraphQL\Inputs;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class PagesInput extends InputType
{


   protected $attributes = [
      'name' => 'PagesInput',
      'description' => 'Pages information'
   ];

   public function fields(): array
   {
      return [
         'pages_id' => [
            'type' => Type::string(),
         ],
         'title' => [
            'type' => Type::string(),
         ],
         'slug' => [
            'type' => Type::string(),
         ],
         'header' => [
            'type' => Type::string(),
         ],
         'sub_header' => [
            'type' => Type::string(),
         ],
         'meta_title' => [
            'type' => Type::string(),
         ],
         'meta_keywords' => [
            'type' => Type::string(),
         ],
         'meta_description' => [
            'type' => Type::string(),
         ],
         'action_type' => [
            'type' => Type::string(),
         ],
         'description' => [
            'type' => Type::string(),
         ],
         'sub_title' => [
            'type' => Type::listOf(Type::string()),
         ],
         'content' => [
            'type' => Type::listOf(Type::string()),
         ],

         'objective_description' => [
            'type' => Type::listOf(Type::string()),
         ],
         'objective_sub_description' => [
            'type' => Type::listOf(Type::string()),
         ],
         'about_title' => [
            'type' => Type::listOf(Type::string()),
         ],
         'about_description' => [
            'type' => Type::listOf(Type::string()),
         ],
         'about_main_title' => [
            'type' => Type::string(),
         ],
         'about_subtitle' => [
            'type' => Type::string(),
         ],
         'video_title' => [
            'type' => Type::string(),
         ],
         'video_subtitle' => [
            'type' => Type::string(),
         ],
         'video_link' => [
            'type' => Type::string(),
         ],
         'faq_title' => [
            'type' => Type::string(),
         ],
         'faq_subtitle' => [
            'type' => Type::string(),
         ],
         'testimonial_title' => [
            'type' => Type::string(),
         ],
         'testimonial_subtitle' => [
            'type' => Type::string(),
         ],
         'testimonial_description' => [
            'type' => Type::string(),
         ],
         'donate_title' => [
            'type' => Type::string(),
         ],
         'donate_subtitle' => [
            'type' => Type::string(),
         ],
         'donate_description' => [
            'type' => Type::string(),
         ],
         'donate_purpose_title' => [
            'type' => Type::string(),
         ],
         'donate_purpose_description' => [
            'type' => Type::string(),
         ],
         'events_title' => [
            'type' => Type::string(),
         ],
         'events_subtitle' => [
            'type' => Type::string(),
         ],
         'events_description' => [
            'type' => Type::string(),
         ],

         'contact_description' => [
            'type' => Type::string(),
         ],

         'mission_intro_section_title' => [
            'type' => Type::string(),
         ],
         'mission_intro_title' => [
            'type' => Type::string(),
         ],
         'mission_intro_description' => [
            'type' => Type::string(),
         ],
         'checklist_title' => [
            'type' => Type::string(),
         ],
         'checklist_subtitle' => [
            'type' => Type::string(),
         ],
         'checklist_description' => [
            'type' => Type::string(),
         ],
         'checklist_short_text' => [
            'type' => Type::string(),
         ],
         'checklist_checklist1' => [
            'type' => Type::string(),
         ],
         'checklist_checklist2' => [
            'type' => Type::string(),
         ],
         'checklist_checklist3' => [
            'type' => Type::string(),
         ],
         'volunteers_title' => [
            'type' => Type::string(),
         ],
         'volunteers_subtitle' => [
            'type' => Type::string(),
         ],
         'volunteers_description' => [
            'type' => Type::string(),
         ],

         'program_intro_title' => [
            'type' => Type::string(),
         ],
         'program_intro_description' => [
            'type' => Type::string(),
         ],
         'program_about_title' => [
            'type' => Type::string(),
         ],
         'program_about_description' => [
            'type' => Type::string(),
         ],
         'program_overview_title' => [
            'type' => Type::string(),
         ],
         'program_overview_description' => [
            'type' => Type::string(),
         ],


         'core_title' => [
            'type' => Type::listOf(Type::string()),
         ],
         'core_description' => [
            'type' => Type::listOf(Type::string()),
         ],
      ];
   }
}
