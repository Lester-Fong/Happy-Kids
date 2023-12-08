let admin_queries = {
    admin_outside_action: `mutation postAdminRequest($admin: AdministratorInput) {
        administrator(admin: $admin) {
            error,
            message,
            access_token,
            refresh_token,
            token_expiration,
            reset_password_security,
            admin {
                administrator_id,
                firstname,
                lastname,
                email,
                mobile,
            },
        }
    }`,

    get_admin: `query administrator($action_type: String) {
        administrator(action_type: $action_type) {
                administrator_id,
                firstname,
                lastname,
                email,
                mobile,
        }
    }`,

    save_pages: `mutation pages($file: Upload, $file1: Upload, $file2: Upload, $file3: Upload, $file4: Upload, $file5: Upload, $file6: Upload, $file7: Upload, $file8: Upload, $file9: Upload, $file10: Upload, $file11: Upload, $objectiveImages: [Upload], $page: PagesInput) {
        pages(file: $file, file1: $file1, file2: $file2, file3: $file3, file4: $file4, file5: $file5, file6: $file6, file7: $file7, file8: $file8, file9: $file9, file10: $file10, file11: $file11, objectiveImages: $objectiveImages, page: $page) {
            error,
            message,
      }
    }`,

    blogs: `query blogs($action_type: String, $blog_id: String) {
        blogs(action_type: $action_type, blog_id: $blog_id) {
            blogs_id,
            original_blogs_id,
            title,
            description,
            image,
            thumbnail,
            meta,
            date,
            category_id,
            slug,
            status,
        }
    }`,

    save_blogs: `mutation blogs($file: Upload, $file1: Upload, $thumbnail: Upload, $blogs: BlogInput) {
            blogs(file: $file, file1: $file1, thumbnail: $thumbnail, blogs: $blogs) {
                  error,
                  message,
                  filename
            }
          }`,

    blog_category: `query blog_category($action_type: String, $category_id: String) {
        blog_category(action_type: $action_type, category_id: $category_id) {
                category_id,
                original_category_id,
                name,
                date_created,
                meta
            }
        }`,

    save_blog_categories: `mutation blog_category($blog_category: BlogCategoryInput) {
        blog_category(blog_category: $blog_category) {
                      error,
                      message,
                }
              }`,

    pages: `query pages($action_type: String, $page_id: String) {
        pages(action_type: $action_type, page_id: $page_id) {
            encrypted_pages_id,
            pages_id,
            title,
            description,
            slug,
            meta,
            image,
            extras_image_1,
            extras_image_2
          }
      }`,

    events: `query events($action_type: String, $events_id: String) {
        events(action_type: $action_type, events_id: $events_id) {
            events_id,
            original_events_id,
            title,
            date_start,
            date_end,
            location,
            image,
            is_pinned,
            date_created,
            status,
            is_expired
        }
    }`,

    save_events: `mutation events($file: Upload, $events: EventsInput) { 
        events(file: $file, events: $events) {
            error,
            message,
        }
    }`,
};

export default admin_queries;
