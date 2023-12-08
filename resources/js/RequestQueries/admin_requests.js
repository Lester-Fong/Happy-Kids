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
    save_pages: `mutation pages($file: Upload, $file1: Upload, $file2: Upload, $file3: Upload, $file4: Upload, $file5: Upload, $selectedFileHow: [Upload], $selectedFileRoles: [Upload], $selectedFileCore: [Upload], $page: PagesInput) {
        pages(file: $file, file1: $file1, file2: $file2, file3: $file3, file4: $file4, file5: $file5, selectedFileHow: $selectedFileHow, selectedFileRoles: $selectedFileRoles, selectedFileCore: $selectedFileCore, page: $page) {
              error,
              message,
        }
      }`,
};

export default admin_queries;
