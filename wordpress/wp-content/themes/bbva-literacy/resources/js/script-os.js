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


	/*jQuery(document).ajaxComplete(function(event,xhr,ajaxOptions) {
		if(typeof(ajaxOptions.url) !== "undefined" && ajaxOptions.url.indexOf('ipinfo.io') != -1) {
			pais = jQuery("#select-country :selected").val();
			pais =  pais.toLowerCase();
			numero_talleres = jQuery('.' + pais +  ' article#otros_talleres .content .data-block').length;
			
			if (numero_talleres < 6) {
	        	jQuery('a#readmore_talleres').hide();
			} else {
	    		jQuery('a#readmore_talleres').show();
	   		}
		}
	});*/


	jQuery('#readmore_talleres').on('click', function(e) {
	    e.preventDefault();
		pais = jQuery('.workshops:visible').attr("class").split(' ')[1];
	    numero_talleres_visibles = jQuery('.' + pais +  ' article#otros_talleres .content .data-block:visible').length;
	    numero_talleres_ocultos = jQuery('.' + pais +  ' article#otros_talleres .content .data-block:hidden').length;
	    i = 1;
	    jQuery('.' + pais +  ' article#otros_talleres .content .data-block:hidden').each(function() {
	        jQuery('.' + pais +  ' article#otros_talleres .content #taller_' + numero_talleres_visibles).show();
	        numero_talleres_visibles++;
	        if (i == 6) {
	            return false;
	        } else {
	            i++;
	        }
	    });
	    numero_talleres_ocultos = jQuery('.' + pais +  ' article#otros_talleres .content .data-block:hidden').length;
	    if (numero_talleres_ocultos == 0) {
	        jQuery('a#readmore_talleres').hide();
	    } else {
	    	jQuery('a#readmore_talleres').show();
	    }
	});
	 
});