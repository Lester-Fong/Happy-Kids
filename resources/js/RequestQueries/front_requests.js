let front_queries = {
    display_data: `query front($action_type: String, $slug: String, ) {
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
    
        }
    }`,
};

export default front_queries;
