// version: 3.2
jQuery(document).ready(function($){
	
	
var wc_terms_toggle = {
	
		init: function() {
			$( document.body ).on( 'click', 'a.woocommerce-terms-and-conditions-link', this.toggle_terms );
		},

		toggle_terms: function() {

			if ( $( '.woocommerce-terms-and-conditions' ).length ) {
				$( '.woocommerce-terms-and-conditions' ).slideToggle();
				return false;
			}
		}
	};
	wc_terms_toggle.init();
	
})(jQuery);
