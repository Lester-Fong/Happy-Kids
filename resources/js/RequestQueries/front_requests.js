const blogFields = onBlogFields();

let front_queries = {
    display_data: `query front($action_type: String, $slug: String) {
        front(action_type: $action_type, slug: $slug) {
            blogs {
                ${blogFields}
              },
              single_blog {
                ${blogFields}
              },
              related_blogs {
                ${blogFields}
              },
              latest_posts {
                ${blogFields}
              },
              blog_category {
                category_id,
                name,
              }
              events {
                original_events_id
                title,
                date_start,
                date_end,
                location,
                image,
                is_pinned,
                status,
                admin,
                date_created,
                is_expired,
                author {
                  firstname,
                  lastname,
                }
              },
              pages {
                encrypted_pages_id,
                pages_id,
                title,
                description,
                slug,
                image,
                extras_image_1,
                extras_image_2,
                meta,
              }
        }
    }`,

    save_blogs: `mutation blogs($file: Upload, $file1: Upload, $thumbnail: Upload, $blogs: BlogInput) {
      blogs(file: $file, file1: $file1, thumbnail: $thumbnail, blogs: $blogs) {
            error,
            message,
            filename
      }
    }`,

    events: `query events($action_type: String, $events_id: String) {
      events(action_type: $action_type, events_id: $events_id) {
            events_id,
        }
    }`,

    front_page_data: `query front($action_type: String!) {
      front(action_type: $action_type) {
          pages {
            encrypted_pages_id,
            pages_id,
            title,
            description,
            slug,
            image,
            extras_image_1,
            extras_image_2,
            meta,
          }
          testimonials {
            testimonial_id,
            original_testimonial_id,
            name,
            position,
            description,
            image
          }
          faq {
            faq_id,
            original_faq_id,
            question,
            answer
          },
          team {
            team_id,
            original_team_id,
            name,
            position,
            type,
            image
          },
          events {
            original_events_id,
            title,
            date_start,
            date_end,
            location,
            image,
            is_expired
          }
      }
  }`,

    blogs: `query blogs($action_type: String) {
            blogs(action_type: $action_type) {
            ${blogFields}
            }
        }`,
};

export default front_queries;

// VARIABLES
function onBlogFields() {
    return `blogs_id,
            title,
            description,
            image,
            thumbnail,
            thumbnail_webp,
            date,
            original_blogs_id
            category_id,
            slug,
            meta,
            author {
              administrator_regular_id,
              firstname,
              lastname,
              image,
            },
            blog_category {
              category_id,
              name,
            }
            `;
}
