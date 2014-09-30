<?php
/*
Plugin Name: WP Job Manager - Customized Applications
Plugin URI: https://github.com/macbookandrew/wp-job-manager-customized-applications
Description: Allows the creation of customized application forms for each job posting. Requires WP Job Manager - Applications plugin (https://wpjobmanager.com/add-ons/applications/)
Version: 1.1
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

// load backend
if ( is_admin() ) {
    require_once( 'inc/metaboxes.php' );
    require_once( 'inc/submissions-backend.php' );
    require_once( 'inc/company-info.php' );
}

// load frontend
if ( ! is_admin() ) {
    require_once( 'inc/shortcodes.php' );
    add_action( 'wp_head', 'add_dashboard_style' );
    add_action( 'wp_footer', 'add_dashboard_scripts' );
}

require_once( 'inc/wp-job-manager-applications-functions.php' );

// add job dashboard styles and scripts
function add_dashboard_style() {
    echo '<style>
        .job-application-meta dt {font-weight: bold;}
        .no-custom-question-response {display: none;}
    </style>';
}
function add_dashboard_scripts() {
    echo "<script>
        jQuery('#hideLazyApplicants').click(function(){
            jQuery('.job-application').toggleClass('no-custom-question-response');
        })
    </script>";
}

// save custom matching data
function custom_values_register(){
    add_action( 'ninja_forms_post_process', 'process_custom_extra_value' );
}
add_action( 'init', 'custom_values_register' );
 
function process_custom_extra_value() {

    // make sure we're referencing the global variable.
	global $ninja_forms_processing;
    
    // get all Ninja Forms fields
    $all_fields = $ninja_forms_processing->get_all_fields();
    
    // add all Ninja Forms fields to global array for submission as metadata alongside other application data
    $GLOBALS["nf_content"] = array();
    foreach ( $all_fields as $key => $value ) {
        $GLOBALS["nf_content"][$key] = $value;
    }
}
