let admin_queries = {
    admin_outside_action: `mutation postAdminRequest($admin: AdministratorInput) {
        administrator_mutation(admin: $admin) {
            error,
            message,
        }
    }`,
};

export default admin_queries;
