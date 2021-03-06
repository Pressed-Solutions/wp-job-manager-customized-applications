<?php global $post; ?>
<form class="job-manager-application-form job-manager-form" method="post" enctype="multipart/form-data">
	<?php do_action( 'job_application_form_fields_start' ); ?>

	<?php foreach ( $application_fields as $key => $field ) : ?>
		<fieldset class="fieldset-<?php esc_attr_e( $key ); ?>">
			<label for="<?php esc_attr_e( $key ); ?>"><?php echo $field['label'] . apply_filters( 'submit_job_form_required_label', $field['required'] ? '' : ' <small>' . __( '(optional)', 'wp-job-manager' ) . '</small>', $field ); ?></label>
			<div class="field <?php echo $field['required'] ? 'required-field' : ''; ?>">
				<?php get_job_manager_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) ); ?>
			</div>
		</fieldset>
	<?php endforeach; ?>

    <?php
        $this_form = get_post_meta( $post->ID, '_wpjmcq_chosen_form', true );

        // remove opening and closing <form> tags
        remove_action('ninja_forms_display_open_form_tag', 'ninja_forms_display_open_form_tag');
        remove_action('ninja_forms_display_close_form_tag', 'ninja_forms_display_close_form_tag');

        // display custom ninja form
        if( function_exists( 'ninja_forms_display_form' ) ) { ninja_forms_display_form( $this_form ); }
    ?>

	<?php do_action( 'job_application_form_fields_end' ); ?>

	<p>
		<input type="submit" name="wp_job_manager_send_application" value="<?php esc_attr_e( 'Send application', 'wp-job-manager-applications' ); ?>" />
		<input type="hidden" name="job_id" value="<?php echo absint( $post->ID ); ?>" />
	</p>
</form>
