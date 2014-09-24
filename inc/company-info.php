<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Adds a company Facebook field
 */
add_filter( 'submit_job_form_fields', 'wpjmcq_add_facebook' );
function wpjmcq_add_facebook() {
    $fields['job']['company_facebook'] = array(
        'label' => __( 'Company Facebook', 'job_manager' ),
        'type' => 'text',
        'required' => false,
        'placeholder' => __( 'Full Facebook URL, e.g. "http://facebook.com/example-page"', 'job_manager' ),
        'priority' => 6
    );
    return $fields;
}
// save submitted info
add_action( 'job_manager_update_job_data', 'wpjmcq_add_facebook_save', 10, 2 );
function wpjmcq_add_facebook_save( $job_id, $values ) {
    update_post_meta( $job_id, '_company_facebook', $values['job']['company_facebook'] );
}
// add to admin metaboxes
add_filter( 'job_manager_job_listing_data_fields', 'wpjmcq_admin_add_facebook' );
function wpjmcq_admin_add_facebook( $fields ) {
    $fields['_company_facebook'] = array(
        'label' => __( 'Facebook', 'job_manager' ),
        'type' => 'text',
        'placeholder' => __( 'Full Facebook URL, e.g. "http://facebook.com/example-page"', 'job_manager' ),
        'description' => ''
        );
    return $fields;
}


/**
 * Autofill job fields with default company information
 */
add_filter( 'job_manager_job_listing_data_fields', 'wpjmcq_autofill_data_fields' );
// List of fields which can be changed: https://github.com/mikejolley/WP-Job-Manager/blob/master/includes/admin/class-wp-job-manager-writepanels.php
function wpjmcq_autofill_data_fields( $fields ) {

    #TODO: allow user to set these and pull from database rather than hard-coding them in
    $fields['_job_location']['value'] = "Cincinnati";
    $fields['_application']['value'] = "cnkd@heits.com";
    $fields['_company_name']['value'] = "Heits Building Services Cincinnati Northern Kentucky Dayton";
    $fields['_company_website']['value'] = "www.heits-cnkd.com";
    $fields['_company_tagline']['value'] = "Let us earn your trust!";
    $fields['_company_twitter']['value'] = "@HEITSCNKD";
    $fields['_company_facebook']['value'] = "https://www.facebook.com/pages/HEITS-Building-Services-Cincinnati-Northern-Kentucky-Dayton/115675811778223";
    $fields['_company_logo']['value'] = get_stylesheet_directory_uri() . "/img/logo-standalone.png";

    // And return the modified fields
    return $fields;
}

/**
 * Display or retrieve the current company facebook link with optional content.
 *
 * @access public
 * @param mixed $id (default: null)
 * @return void
 */
function the_company_facebook( $before = '', $after = '', $echo = true, $post = null ) {
	$company_facebook = get_the_company_facebook( $post );

	if ( strlen( $company_facebook ) == 0 )
		return;

	$company_facebook = esc_attr( strip_tags( $company_facebook ) );
	$company_facebook = $before . '<a href="' . $company_facebook . '" class="company_facebook" target="_blank">Facebook</a>' . $after;

	if ( $echo )
		echo $company_facebook;
	else
		return $company_facebook;
}

/**
 * get_the_company_facebook function.
 *
 * @access public
 * @param int $post (default: 0)
 * @return void
 */
function get_the_company_facebook( $post = null ) {
	$post = get_post( $post );
	if ( $post->post_type !== 'job_listing' )
		return;

	$company_facebook = $post->_company_facebook;

	if ( strlen( $company_facebook ) == 0 )
		return;

	if ( strpos( $company_facebook, '@' ) === 0 )
		$company_facebook = substr( $company_facebook, 1 );

	return apply_filters( 'the_company_facebook', $company_facebook, $post );
}
