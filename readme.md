#Introduction
This plugin brings [Ninja Forms](https://wordpress.org/plugins/ninja-forms/) and [WP Job Manager Applications](https://wpjobmanager.com/add-ons/applications/) together to allow for custom questions for each job listing.

#Requirements
- [WP Job Manager Applications plugin](https://wpjobmanager.com/add-ons/applications/)
- [Ninja Forms plugin](https://wordpress.org/plugins/ninja-forms/)

#Installation Instructions
1. Install both plugins.
1. Copy the `templates/application-form.php` file to the `/wp-content/plugins/wp-job-manager-applications/templates/` folder, replacing the existing file. Without this step, the Ninja Form content will not be displayed.
1. Copy the `inc/wp-job-manager-applications-functions.php` file to `/wp-content/plugins/wp-job-manager-applications/includes/` folder, replacing the existing file. Without this step, custom question responses will not be shown.
1. Copy the `template/job-applications.php` file to the `/wp-content/plugins/wp-job-manager/applications/templates/` folder, replacing the existing file. Without this step, you will be unable to filter the dashboard by whether or not applicants entered answers in the custom questions.

#Usage Instructions
1. Create a Ninja form for each job application that needs customized application fields; make sure to name it descriptively so you can choose it from a list easily. You only need to create the custom question fields; the Job Manager Applications plugin will ask for their name, email address, cover letter, and resume.
1. Create the job posting and choose the Ninja form from the dropdown list on the right-hand side of the page.

#Special Role
- To set up a user who can manage jobs and nothing else, create a new user with these capabilities:
    - `edit_posts`
    - `manage_applications`
    - `manage_job_listings`
    - `manage_jobs`
    - `manage_resumes`
    - `read`
    - `read_private_posts`

- And add this code to `functions.php`:

````
    // tweak dashboard for job manager role
    function remove_admin_menus() {
        remove_menu_page( 'index.php' );                        // Dashboard
        remove_menu_page( 'edit.php' );                         // Posts
        remove_menu_page( 'edit-comments.php' );                // Comments
        remove_menu_page( 'tools.php' );                        // Tools
    }
    if ( appthemes_check_user_role( 'jobmanager' ) ) { add_action( 'admin_menu', 'remove_admin_menus' ); }

    // hide jetpack admin menu item from non-admins
    function remove_jetpack() {
        if( class_exists( 'Jetpack' ) && !current_user_can( 'manage_options' ) ) {
            remove_menu_page( 'jetpack' );
        }
    }
    add_action( 'admin_init', 'remove_jetpack' );

    // get logged-in user's role
    function appthemes_check_user_role( $role, $user_id = null ) {

        if ( is_numeric( $user_id ) )
        $user = get_userdata( $user_id );
        else
            $user = wp_get_current_user();

        if ( empty( $user ) )
        return false;

        return in_array( $role, (array) $user->roles );
    }
````