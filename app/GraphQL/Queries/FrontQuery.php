<?php

namespace App\GraphQL\Queries;

use App\Models\Faq;
use App\Models\Newsletter;
use App\Models\Testimonial;
use Auth;
use App\Models\Brand;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Events;
use App\Models\Pages;
use App\Models\Team;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Log;


class FrontQuery extends Query
{
  protected $attributes = [
    'name' => 'The front query',
    'description' => 'Retrieves front',
  ];

  public function args(): array
  {
    return [
      'action_type' => ['type' => Type::string()],
      'email' => ['type' => Type::string()],
      'slug' => ['type' => Type::string()],
    ];
  }

  public function type(): type
  {
    return GraphQL::type('response_type');
  }

  public function resolve($root, $args)
  {
    $action_type = $args['action_type'];
    // $newsletter_model = new Newsletter;
    $response_obj = new \stdClass();
    // $brand_model = new Brand();
    $blog_model = new Blog();
    $blog_category_model = new BlogCategory();
    $events_model = new Events();


    // if ($action_type == 'subscribe_newsletter') {
    //   $email = $args['email'];
    //   $response = $newsletter_model->newsletterSubscription($email);
    // }

    if ($action_type == 'display_homepage') {
      $response_obj->testimonials = Testimonial::all();
      $response_obj->faq = Faq::take(3)->get();
      $response_obj->pages = Pages::where('fldPagesTitle', 'Homepage')->first();
      $response_obj->events = $events_model->where('fldEventsStatus', '=', 1)
                                    ->orderBy('fldEventsDateStart', 'ASC')
                                    ->take(4)
                                    ->get();
    }

    if ($action_type == 'display_about_page') {
      $response_obj->pages = Pages::where('fldPagesTitle', 'Our Mission')->first();
      $response_obj->team = Team::where('fldTeamType', 'volunteer')->take(3)->get();
    }

    if ($action_type == 'display_faq_page') {
      $response_obj->pages = Pages::where('fldPagesTitle', 'FAQs')->first();
      $response_obj->faq = Faq::all();
    }

    if ($action_type == 'display_team_page') {
      $response_obj->pages = Pages::where('fldPagesTitle', 'Our Team')->first();
      $response_obj->team = Team::where('fldTeamType', 'team')->get();
    }

    if ($action_type == 'display_feeding_program_page') {
      $response_obj->pages = Pages::where('fldPagesTitle', 'Feeding Program')->first();
      $response_obj->team = Team::where('fldTeamType', 'volunteer')->get();
    }

    if ($action_type == 'display_scholar_program_page') {
      $response_obj->pages = Pages::where('fldPagesTitle', 'Scholarship Program')->first();
      $response_obj->team = Team::where('fldTeamType', 'scholar')->get();
    }

    if ($action_type == 'display_events_page') {
      $response_obj->pages = Pages::where('fldPagesTitle', 'Events')->first();
    }

    if ($action_type == 'display_contact_page') {
      $response_obj->pages = Pages::where('fldPagesTitle', 'Contact Us')->first();
    }

    if ($action_type == "display_all_blogs") {
      //   $page  = Pages::find(5);
      $blogs = $blog_model->displayAllBlog();

      $response_obj->pages = Pages::where('fldPagesTitle', 'Stories')->first();
      $response_obj->blogs = $blogs;
    }

    if ($action_type == "display_blogs_by_category") {
      $slug = $args['slug'];
      $blog_category = $blog_category_model->findCategoryBySlug($slug);

      if ($blog_category) {
        $blogs = $blog_model->displayAllBlogByCategory($blog_category->fldBlogCategoryID);
      } else {
        $blogs = $blog_model->displayAllBlog();
      }
      // $pages  = Pages::find(5);

      $response_obj->blogs = $blogs;
      // $response_obj->pages = $pages;
    }


    if ($args['action_type'] == "display_by_blogs_slug") {
      $slug = $args['slug'];
      $single_blog = $blog_model->where('fldBlogSlug', '=', $slug)->first();

      // $popular_blogs = $blog_model->displayPopularBlogs();
      $blog_category = $blog_category_model->displayAllCategory();
      // $pages  = Pages::find(5);
      // related blogs by category id
      
      $related_blogs = $blog_model->displayAllBlogByCategoryExceptSelectedBlog($single_blog->fldBlogCategoryID, $single_blog->fldBlogID);

      $latest_posts = $blog_model->displayRecentBlog();

      $response_obj->latest_posts = $latest_posts;
      $response_obj->single_blog = $single_blog;
      // $response_obj->blogs = $popular_blogs;
      $response_obj->blog_category = $blog_category;
      $response_obj->related_blogs = $related_blogs;
      // $response_obj->page = $pages;
    }

    if ($args['action_type'] == "display_all_events") {
      $events = $events_model->where('fldEventsStatus', '=', 1)
                            ->orderBy('fldEventsDateStart', 'ASC')
                            ->get();
                            
      $response_obj->pages = Pages::where('fldPagesTitle', 'Events')->first();

      $response_obj->events = $events;
    }
    
    
    return $response_obj;
  }
  
}
