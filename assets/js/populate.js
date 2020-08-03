//Also take a look at quick-edit.js located at woocommerce->assets->js->admin
//woocommerce->includes->admin->class-wc-admin-post-types.php
//woocommerce->includes->admin->class-wc-admin-post-types.php
//woocommerce->includes->admin->views->html-quick-edit-product.php on line 195
jQuery(function($){
    $( '#the-list' ).on( 'click', '.editinline', function() {

		var id = $( this ).closest( 'tr' ).attr( 'id' );
        id = id.replace( 'tag-', '' ); //-> post- for products
        //if post id exists
        if ( id > 0 ) {

            // add rows to variables
            var specific_post_edit_row = $( '#edit-' + id ),
                specific_post_row = $( '#tag-' + id ), //-> #post- for products
                cat_years = $( '.column-flatep_meta_years', specific_post_row ).text();

            // populate the inputs with column data
            $( ':input[name="flatep_meta_years"]', specific_post_edit_row ).val( cat_years );
        }
        
    });
	
});