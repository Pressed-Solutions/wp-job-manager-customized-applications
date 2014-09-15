<?php
/*
Plugin Name: WP Job Manager - Customized Applications
Plugin URI: https://github.com/macbookandrew/wp-job-manager-customized-applications
Description: Allows the creation of customized application forms for each job posting. Requires WP Job Manager - Applications plugin (https://wpjobmanager.com/add-ons/applications/)
Version: 1.0.1
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
    require_once( 'inc/metaboxes.php' );
    require_once( 'inc/submissions.php' );
}

// load frontend
if ( ! is_admin() ) {
}
