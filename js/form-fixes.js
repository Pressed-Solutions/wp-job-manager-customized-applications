jQuery( document ).ready( function() {
    jQuery( 'label[for="candidate_name"], label[for="application_attachment"]' ).append( ': <span class="ninja-forms-req-symbol">*</span>' );
    jQuery( 'fieldset-candidate_email .required-field' ).removeClass( 'required-field' );
    jQuery( 'input[name="candidate_email"]' ).attr( 'required', false );
    jQuery( 'div.ninja-forms-required-items' ).remove();
    jQuery( '.ninja-forms-req, input#application_attachment' ).attr( 'required', true );
    if ( jQuery( '.ninja-forms-cont' ) ) {
        jQuery( '.fieldset-application_attachment' ).insertAfter( '.ninja-forms-cont' );
    }
});
