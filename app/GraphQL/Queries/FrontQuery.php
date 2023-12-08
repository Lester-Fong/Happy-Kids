<?php

namespace App\GraphQL\Queries;

use App\Models\Faq;
use App\Models\Newsletter;
use App\Models\Testimonials;
use Auth;
use App\Models\Brand;
use App\Models\Blog;
use App\Models\BlogCategory;
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


    if ($action_type == 'subscribe_newsletter') {
      $email = $args['email'];
      $response = $newsletter_model->newsletterSubscription($email);
    }


    if ($action_type == 'get_home_owner_data') {
      $response_obj->page = Pages::find(6);
      $response_obj->faq = Faq::where('fldFaqType', '=', 'Owner')->get();
      $response_obj->testimonial = Testimonials::where('fldTestimonialsActive', true)->get();
    }

    if ($action_type == 'get_customer_faq') {
      $response_obj->faq = Faq::where('fldFaqType', '=', 'Customer')->get();
    }


    if ($action_type == 'get_home_data') {
      $response_obj->testimonial = Testimonials::where('fldTestimonialsActive', true)->get();
      $response_obj->page = Pages::find(1);
      $response_obj->blogs =  $blog_model->displayAllBlog();
    }

    if ($action_type == 'get_services_data') {
      $response_obj->testimonial = Testimonials::where('fldTestimonialsActive', true)->get();
      $response_obj->page = Pages::find(2);
    }

    if ($action_type == 'get_aboutus_data') {
      $response_obj->page = Pages::find(3);
      $response_obj->team = Team::where('fldTeamActive', true)->get();
    }

    if ($action_type == 'get_contacts_data') {
      $response_obj->page = Pages::find(4);
    }

    if ($action_type == "display_all_blogs") {
    //   $page  = Pages::find(5);
      $blogs = $blog_model->displayAllBlog();

    //   $response_obj->page = $page;
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
      // $blog_category = $blog_category_model->displayAllCategory();
      // $pages  = Pages::find(5);
      // related blogs by category id
      
      $related_blogs = $blog_model->displayAllBlogByCategoryExceptSelectedBlog($single_blog->fldBlogCategoryID, $single_blog->fldBlogID);

      $latest_posts = $blog_model->displayRecentBlog();

      $response_obj->latest_posts = $latest_posts;
      $response_obj->single_blog = $single_blog;
      // $response_obj->blogs = $popular_blogs;
      // $response_obj->blog_category = $blog_category;
      $response_obj->related_blogs = $related_blogs;
      // $response_obj->page = $pages;
    }
    return $response_obj;
  }
}
