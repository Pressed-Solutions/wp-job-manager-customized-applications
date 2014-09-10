<?php
/*
Plugin Name: WP Job Manager - Customized Applications
Plugin URI: https://github.com/macbookandrew/wp-job-manager-customized-applications
Description: Allows the creation of customized application forms for each job posting. Requires WP Job Manager - Applications plugin (https://wpjobmanager.com/add-ons/applications/)
Version: 1.0
Author: Andrew Minion
Author URI: http://andrewrminion.com
Requires at least: 3.8
Tested up to: 4.0

	Copyright: 2014 Andrew Minion
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// define constants
define( 'JOB_MANAGER_CUSTOMIZED_APPLICATIONS_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );


// load backend
if ( is_admin() ) {
    require_once( 'inc/dashboard.php' );
    require_once( 'inc/metaboxes.php' );
}

// load frontend
if ( ! is_admin() ) {
    // call a function to get our template
    add_action( 'job_manager_application_details_email', 'application_form', 20 );
    // unhook job manager apply-via-email details
    #TODO: figure out how to make this work, unless ninja_form id is 0 (default)
    remove_action( 'job_manager_application_details_email', array( $job_manager->post_types, 'application_details_email' ) );

    // get our template
    function application_form() {
        if ( function_exists( 'get_job_manager_template' ) ) {
            get_job_manager_template( 'application-form.php', NULL, 'wp-job-manager-customized-applications', JOB_MANAGER_CUSTOMIZED_APPLICATIONS_PLUGIN_DIR . '/templates/' );
        }
    }
}
?>
