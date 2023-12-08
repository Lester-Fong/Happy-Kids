let front_queries = {
    display_data: `query front($action_type: String, $slug: String) {
        front(action_type: $action_type, slug: $slug) {
            blogs {
                blogs_id,
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
          }
      }
  }`,
};

export default front_queries;
