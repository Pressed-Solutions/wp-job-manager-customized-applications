<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Autofill job fields with default company information
 */
add_filter( 'job_manager_job_listing_data_fields', 'wpjmcq_autofill_data_fields' );
// List of fields which can be changed: https://github.com/mikejolley/WP-Job-Manager/blob/master/includes/admin/class-wp-job-manager-writepanels.php
function wpjmcq_autofill_data_fields( $fields ) {

    #TODO: allow user to set these and pull from database rather than hard-coding them in
    #FIXME: show only if value currently is blank
    $fields['_job_location']['value'] = "Cincinnati";
    $fields['_application']['value'] = "cnkd@heits.com";
    $fields['_company_name']['value'] = "Heits Building Services Cincinnati Northern Kentucky Dayton";
    $fields['_company_website']['value'] = "www.heits-cnkd.com";
    $fields['_company_tagline']['value'] = "Let us earn your trust!";
    $fields['_company_twitter']['value'] = "@HEITSCNKD";
    $fields['_company_facebook']['value'] = "https://www.facebook.com/pages/HEITS-Building-Services-Cincinnati-Northern-Kentucky-Dayton/115675811778223";
    $fields['_company_logo']['value'] = get_stylesheet_directory_uri() . "/img/logo-standalone.svg";

    // And return the modified fields
    return $fields;
}
