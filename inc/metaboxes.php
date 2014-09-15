<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function wpjmcq_add_meta_box() {
    add_meta_box( 'wpjmcq-form-picker', 'Choose a Form', 'wpjmcq_form_picker', 'job_listing', 'side' );
}
add_action( 'add_meta_boxes', 'wpjmcq_add_meta_box' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function wpjmcq_form_picker( $post ) {
    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'wpjmcq_form_picker_meta_box', 'wpjmcq_form_picker_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $this_form = get_post_meta( $post->ID, '_wpjmcq_chosen_form', true );

    /*
     * Get list of all ninja forms
     */
    $ninja_forms = ninja_forms_get_all_forms();

    /*
     * Output list with all ninja forms
     */
    echo '<label for="wpjmcq_chosen_form">Choose a customized form:</label> ';
    echo '<select name="wpjmcq_chosen_form">';
        echo '<option value="0">Default Application Form</option>';
        foreach ( $ninja_forms as $ninja_form ) {
            echo '<option value="' . $ninja_form[ 'id' ] . '"';
            // make this item default if form has already been chosen
            if ( get_post_meta( $post->ID, '_wpjmcq_chosen_form', true ) == $ninja_form[ 'id' ]) { echo ' selected'; }
            echo '>' . $ninja_form[ 'data' ][ 'form_title' ] . '</option>';
        }
    echo '</select>';
    if ( isset( $this_form ) && ($this_form != 0 ) ) { echo '<p><a href="/wp-admin/admin.php?page=ninja-forms&tab=field_settings&form_id=' . $this_form . '">Edit this form</a></p>'; }
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function wpjmcq_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['wpjmcq_form_picker_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['wpjmcq_form_picker_meta_box_nonce'], 'wpjmcq_form_picker_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'job_listing' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.
	if ( ! isset( $_POST['wpjmcq_chosen_form'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['wpjmcq_chosen_form'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_wpjmcq_chosen_form', $my_data );
}
add_action( 'save_post', 'wpjmcq_save_meta_box_data' );

#TODO: add link to view responses
#http://wordpress.dev/wp-admin/edit.php?post_status=all&post_type=nf_sub&form_id=
