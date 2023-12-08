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
};

export default admin_queries;
