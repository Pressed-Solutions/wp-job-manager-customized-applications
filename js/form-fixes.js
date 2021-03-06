jQuery( document ).ready( function() {
    // set optional items
    jQuery( 'fieldset-candidate_email .required-field, fieldset-application_attachment .required-field' ).removeClass( 'required-field' );
    jQuery( 'input[name="candidate_email"]' ).attr( 'required', false );
    jQuery( 'div.ninja-forms-required-items' ).remove();

    // set required items
    jQuery( 'label[for="candidate_name"]' ).append( ' <span class="ninja-forms-req-symbol">*</span>' );
    jQuery( '.ninja-forms-req' ).attr( 'required', true );

    // reorder form
    if ( jQuery( '.ninja-forms-cont' ) ) {
        jQuery( '.fieldset-application_attachment' ).insertAfter( '.ninja-forms-cont' );
    }
});
