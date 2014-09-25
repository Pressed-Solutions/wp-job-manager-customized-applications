<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

public function job_dashboard_customized( $atts ) {
    if ( ! is_user_logged_in() ) {
        return __( 'You need to be signed in to manage your listings.', 'wp-job-manager' );
    }

    extract( shortcode_atts( array(
        'posts_per_page' => '25',
    ), $atts ) );

    wp_enqueue_script( 'wp-job-manager-job-dashboard' );

    ob_start();

    // If doing an action, show conditional content if needed....
    if ( ! empty( $_REQUEST['action'] ) ) {
        $action = sanitize_title( $_REQUEST['action'] );

        // Show alternative content if a plugin wants to
        if ( has_action( 'job_manager_job_dashboard_content_' . $action ) ) {
            do_action( 'job_manager_job_dashboard_content_' . $action, $atts );

            return ob_get_clean();
        }
    }

    // ....If not show the job dashboard
    $args     = apply_filters( 'job_manager_get_dashboard_jobs_args', array(
        'post_type'           => 'job_listing',
        'post_status'         => array( 'publish', 'expired', 'pending' ),
        'ignore_sticky_posts' => 1,
        'posts_per_page'      => $posts_per_page,
        'offset'              => ( max( 1, get_query_var('paged') ) - 1 ) * $posts_per_page,
        'orderby'             => 'date',
        'order'               => 'desc'
    ) );

    $jobs = new WP_Query;

    echo $this->job_dashboard_message;

    $job_dashboard_columns = apply_filters( 'job_manager_job_dashboard_columns', array(
        'job_title' => __( 'Title', 'wp-job-manager' ),
        'filled'    => __( 'Filled?', 'wp-job-manager' ),
        'date'      => __( 'Date Posted', 'wp-job-manager' ),
        'expires'   => __( 'Date Expires', 'wp-job-manager' )
    ) );

    get_job_manager_template( 'job-dashboard.php', array( 'jobs' => $jobs->query( $args ), 'max_num_pages' => $jobs->max_num_pages, 'job_dashboard_columns' => $job_dashboard_columns ) );

    return ob_get_clean();
}

add_shortcode( 'job_dashboard', 'job_dashboard_customized' );
