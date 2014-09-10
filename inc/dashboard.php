<?php
    #TODO: customize submission list preview
    #TODO: customize submission individual preview (ability to add private notes, etc.)

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Adds a box to the right-hand column on the form submission edit screen
 */
function wpjmcq_add_notes_meta_box() {
    add_meta_box( 'wpjmcq-applicant-notes', 'Application Notes', 'wpjmcq_applicant_notes', 'nf_sub', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'wpjmcq_add_notes_meta_box' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function wpjmcq_applicant_notes( $post ) {
    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'wpjmcq_applicant_notes_meta_box', 'wpjmcq_applicant_notes_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $these_notes = get_post_meta( $post->ID, '_wpjmcq_applicant_notes', true );

    /*
     * Output list with all ninja forms
     */
    echo '<textarea name="wpjmcq_applicant_notes">';
    // if notes are not empty, display notes
    if ( isset ( $these_notes ) ) { echo $these_notes; }
    #FIXME: handle line breaks better
    #FUTURE: use individual notes rather than lumping them together
    echo '</textarea>';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function wpjmcq_save_applicant_notes_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['wpjmcq_applicant_notes_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['wpjmcq_applicant_notes_meta_box_nonce'], 'wpjmcq_applicant_notes_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'nf_sub' == $_POST['post_type'] ) {

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
	if ( ! isset( $_POST['wpjmcq_applicant_notes'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['wpjmcq_applicant_notes'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_wpjmcq_applicant_notes', $my_data );
}
add_action( 'save_post', 'wpjmcq_save_applicant_notes_data' );

#TODO: ajax-ify the note submission
?>
