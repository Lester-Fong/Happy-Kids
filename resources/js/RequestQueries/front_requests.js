const blogFields = onBlogFields();

let front_queries = {
    display_data: `query front($action_type: String, $slug: String, ) {
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
            }`;
}
