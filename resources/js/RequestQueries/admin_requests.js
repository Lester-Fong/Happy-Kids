let admin_queries = {
    admin_outside_action: `mutation postAdminRequest($admin: AdministratorInput) {
        administrator(admin: $admin) {
            error,
            message,
            access_token,
            refresh_token,
            token_expiration,
            reset_password_security,
            secret,
            qr_url,
            otp_key,
            admin {
                administrator_id,
                firstname,
                lastname,
                email,
                mobile,
            },
        }
    }`,

    save_admin: `mutation administrator($admin: AdministratorInput, $file: Upload) {
        administrator(admin: $admin, file: $file) {
            error,
            message,
            admin {
                firstname,
                lastname,
                email,
                image,
                mobile,
                administrator_id
            }
        }
    }`,

    get_admin: `query administrator($action_type: String) {
        administrator(action_type: $action_type) {
                administrator_id,
                administrator_regular_id,
                firstname,
                lastname,
                email,
                image,
                mobile,
        }
    }`,

    admin_dashboard: `query administrator($action_type: String) {
        administrator(action_type: $action_type) {
                firstname,
                lastname,
                blogs {
                    title,
                    date,
                    views,
                }
                pages {
                    title,
                    views
                },
                transactions {
                    amount,
                    status,
                    date_created
                },
                donators {
                    firstname,
                    lastname,
                    email,
                    country,
                    date_created,
                    transactions_obj {
                        amount,
                    }
                }
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
            views,
            blog_category {
                name
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

    pages: `query pages($action_type: String, $title: String) {
        pages(action_type: $action_type, title: $title) {
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
    faq: `query faq($action_type: String, $faq_id: String) {
        faq(action_type: $action_type, faq_id: $faq_id) {
            faq_id,
            original_faq_id,
            question,
            answer
        }
    }`,

    save_faq: `mutation ($faq: FaqInput) {
        faq(faq: $faq) {
            error,
            message
        }
    }`,

    testimonial: `query testimonial($action_type: String, $testimonial_id: String) {
        testimonial(action_type: $action_type, testimonial_id: $testimonial_id) {
            testimonial_id,
            original_testimonial_id,
            name,
            position,
            description,
            image
        }
    }`,

    save_testimonial: `mutation testimonial($file: Upload, $testimonial: TestimonialInput) {
            testimonial(file: $file, testimonial: $testimonial) {
                  error,
                  message,

            }
          }`,

    team: `query team($action_type: String, $team_id: String) {
            team(action_type: $action_type, team_id: $team_id) {
                team_id,
                original_team_id,
                name,
                position,
                type,
                image
            }
        }`,

    save_team: `mutation team($file: Upload, $team: TeamInput) {
            team(file: $file, team: $team) {
                  error,
                  message,

            }
          }`,

    donators: `query donators($action_type: String, $donators_id: String) {
        donators(action_type: $action_type, donators_id: $donators_id) {
            donators_id,
            original_donators_id,
            firstname,
            lastname,
            email,
            country,
            date_created,
            transactions_obj {
                amount,
            }
        }
    }`,

    transactions: `query transactions($action_type: String, $donate_id: String) {
        transactions(action_type: $action_type, donate_id: $donate_id) {
            donate_id,
            original_donate_id,
            amount,
            status,
            response_id,
            api_response,
            date_created,
            donator {
                donators_id,
                firstname,
                lastname,
                payer_id,
                date_created,
                country,
            }
        }
    }`,
    sms: `query sms($action_type: String, $sms_id: String) {
            sms(action_type: $action_type, sms_id: $sms_id) {
                sms_id,
                original_sms_id,
                message,
                date_sent,
                status,
                contact_ids,
                metadata,
                sender {
                    firstname,
                    lastname,
                    email,
                    image,
                    mobile,
                    administrator_id
                }
            }
        }`,

    save_sms: `mutation sms( $sms: SMSInput) {
            sms(sms: $sms) {
                  error,
                  message,
            }
          }`,
};

export default admin_queries;
