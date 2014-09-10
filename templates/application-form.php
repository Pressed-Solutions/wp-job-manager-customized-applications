<?php
global $post;

$this_form = get_post_meta( $post->ID, '_wpjmcq_chosen_form', true );

?>

<form class="job-manager-customized-application-form job-manager-form" method="post" enctype="multipart/form-data">
	<?php if( function_exists( 'ninja_forms_display_form' ) ) { ninja_forms_display_form( $this_form ); } ?>
</form>
