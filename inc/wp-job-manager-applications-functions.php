<?php
#TODO: override the main plugin's function rather than replacing its functions.php file
if ( ! function_exists( 'create_job_application' ) ) {

	/**
	 * Create a new job application
	 * @param  int $job_id
	 * @param  string $candidate_name
	 * @param  string $application_message
	 * @param  string $candidate_email
	 * @param  array  $meta
	 * @param  bool $notification
	 * @return int|bool success
	 */
	function create_job_application( $job_id, $candidate_name, $candidate_email, $application_message, $meta = array(), $notification = true ) {
		$job = get_post( $job_id );

		if ( ! $job || $job->post_type !== 'job_listing' ) {
			return false;
		}

		$application_data = array(
			'post_title'     => wp_kses_post( $candidate_name ),
			'post_content'   => wp_kses_post( $application_message ),
			'post_status'    => 'new',
			'post_type'      => 'job_application',
			'comment_status' => 'closed',
			'post_author'    => $job->post_author,
			'post_parent'    => $job_id
		);
		$application_id = wp_insert_post( $application_data );

		if ( $application_id ) {
			update_post_meta( $application_id, '_job_applied_for', $job->post_title );
			update_post_meta( $application_id, '_candidate_email', $candidate_email );
			update_post_meta( $application_id, '_candidate_user_id', get_current_user_id() );
			update_post_meta( $application_id, '_rating', 0 );

            // insert Ninja Form content as post meta
            foreach ( $GLOBALS["nf_content"] as $nf_key => $nf_value ) {
                update_post_meta( $application_id, '_field_' . $nf_key, wp_kses_post( $nf_value ) );
            }

			if ( $meta ) {
				foreach ( $meta as $key => $value ) {
					update_post_meta( $application_id, $key, $value );
				}
			}

			if ( $notification ) {
				$method = get_the_job_application_method( $job_id );

				if ( "email" === $method->type ) {
					$send_to = $method->raw_email;
				} elseif ( $job->post_author ) {
					$user    = get_user_by( 'id', $job->post_author );
					$send_to = $user->user_email;
				} else {
					$send_to = '';
				}

				if ( $send_to ) {
					$dashboard_slug = get_option( 'job_manager_job_dashboard_page_slug' );
					$dashboard_link = '';
					$attachments    = array();

					if ( $dashboard_slug ) {
						$dashboard_link  = add_query_arg( array( 'action' => 'show_applications', 'job_id' => $job_id ), get_permalink( get_page_by_path( $dashboard_slug )->ID ) );
					}

					$message = apply_filters( 'create_job_application_notification_message', array(
						'greeting'       => __( 'Hello', 'wp-job-manager-applications' ),
						'position'       => sprintf( "\n\n" . __( 'A candidate (%s) has submitted their application for the position "%s".', 'wp-job-manager-applications' ), wp_kses_post( $candidate_name ), get_the_title( $job_id ) ),
						'before_message' => '',
						'start_message'  => "\n\n-----------\n\n",
						'message'        => wp_kses_post( $application_message ),
						'end_message'    => "\n\n-----------\n\n",
						'view_resume'    => $dashboard_link ? sprintf( __( 'You can view this and any other applications here: %s.', 'wp-job-manager-applications' ), $dashboard_link ) : __( 'You can view the applications from your dashboard.', 'wp-job-manager-applications' ),
						'contact'        => "\n" . sprintf( __( 'You can contact them directly at: %s.', 'wp-job-manager-applications' ), $candidate_email ),
					), $application_id );

					$headers   = array();
					$headers[] = 'From: ' . $candidate_email;
					$headers[] = 'Reply-To: ' . $candidate_email;
					$headers[] = 'Content-Type: text/plain';
					$headers[] = 'charset=utf-8';

					if ( ! empty( $meta['_attachment_file'] ) ) {
						if ( is_array( $meta['_attachment_file'] ) ) {
							foreach ( $meta['_attachment_file'] as $file ) {
								$attachments[] = $file;
							}
						} else {
							$attachments[] = $meta['_attachment_file'];
						}
						$message['before_message'] = "\n\n" . __( 'Their CV/resume is attached to this email.', 'wp-job-manager-applications' );
					}

					wp_mail( apply_filters( 'create_job_application_notification_recipient', $send_to, $job_id ), sprintf( __( "New job application for %s", 'wp-job-manager-applications' ), get_the_title( $job_id ) ), implode( '', $message ), $headers, $attachments );
				}
			}

			return $application_id;
		}

		return false;
	}
}

if ( ! function_exists( 'get_job_application_count' ) ) {

	/**
	 * Get number of applications for a job
	 * @param  int $job_id
	 * @return int
	 */
	function get_job_application_count( $job_id ) {
		return sizeof( get_posts( array(
			'post_type'      => 'job_application',
			'post_status'    => array( 'publish', 'new', 'interviewed', 'offer', 'hired', 'archived' ),
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'post_parent'    => $job_id
		) ) );
	}
}