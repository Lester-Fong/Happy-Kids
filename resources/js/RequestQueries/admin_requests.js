let admin_queries = {
    admin_outside_action: `mutation postAdminRequest($admin: AdministratorInput) {
        administrator(admin: $admin) {
            error,
            message,
            access_token,
            refresh_token,
            token_expiration,
            admin {
                administrator_id,
                firstname,
                lastname,
                email,
                mobile,
            },
        }
    }`,
};

export default admin_queries;
