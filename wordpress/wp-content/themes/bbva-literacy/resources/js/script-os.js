jQuery(document).ready(function($) {

	$("select#language-header").change(function() {
		console.log("cambio");
		var val = jQuery(this).find(":selected").val();
		window.location.href = val;
	});
	
	numero_trabajos_ocultos = jQuery('article#otros_trabajos .content .data-block:hidden').length;
	if (numero_trabajos_ocultos == 0) {
	    jQuery('a#readmore_trabajos').remove();
	}
	numero_trabajos_visibles = jQuery('article#otros_trabajos .content .data-block:visible').length;
	jQuery('#readmore_trabajos').on('click', function(e) {
	    e.preventDefault();
	    numero_trabajos_ocultos = jQuery('article#otros_trabajos .content .data-block:hidden').length;
	    i = 1;
	    jQuery('article#otros_trabajos .content .data-block:hidden').each(function() {
	        jQuery('article#otros_trabajos .content #trabajo_' + numero_trabajos_visibles).show();
	        numero_trabajos_visibles++;
	        if (i == 3) {
	            return false;
	        } else {
	            i++;
	        }
	    });
	    numero_trabajos_ocultos = jQuery('article#otros_trabajos .content .data-block:hidden').length;
	    if (numero_trabajos_ocultos == 0) {
	        jQuery('a#readmore_trabajos').remove();
	    }
	});
	 
});