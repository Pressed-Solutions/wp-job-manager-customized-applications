<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function wpjmcq_add_submission_meta_box() {
    add_meta_box( 'wpjmcq-custom-submission', 'Custom Form Responses', 'wpjmcq_custom_submission', 'job_application', 'normal', 'core' );
}
add_action( 'add_meta_boxes', 'wpjmcq_add_submission_meta_box' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function wpjmcq_custom_submission( $post ) {
    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'wpjmcq_custom_submission_meta_box', 'wpjmcq_custom_submission_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $custom_keys = get_post_custom_keys( ( $post->ID - 1) );

    /*
     * Loop through all custom fields
     */
    foreach ($custom_keys as $this_key) {
        // test if this is one of the custom fields or not; if not, ignore
        if ( strpos( $this_key, 'field' ) !== false ) {
            global $wpdb;

            // get names of fields
            $results_query = "SELECT id, data FROM " . $wpdb->prefix . "ninja_forms_fields WHERE id = " . ltrim( $this_key, '_field_' );
            $key_array = $wpdb->get_results( $results_query );
            $key_id = $key_array[0]->id;
            $key_label_array = unserialize( $key_array[0]->data );
            $key_label = $key_label_array['label'];

            // get data for this field
            $key_data = get_post_meta( ( $post->ID - 1 ), $this_key, true );

            // output data
            echo '<p><strong>' . $key_label . '</strong></p>';
            echo '<p>' . $key_data . '</p>';
        }
    }

}
