jQuery(document).ready(function() {


	jQuery("input#inputText").focusin(function() {
		jQuery(this).val("");
		jQuery("div#caja_categorias").hide();
		jQuery("div#caja_paises").hide();
		jQuery("div#caja_autores").hide();
	});


	// Autocompletado de categorías, autores y ámbitos geográficos
	jQuery("input#inputText").on('input', function() {
		myText = getCleanedString(jQuery(this).val());
		esUnaCategoria = false;
		jQuery('ul#categorias li').each(function() {
	        var li_text = getCleanedString(jQuery(this).text());
	        var n = li_text.includes(myText);
	        if (n) {
	        	jQuery(this).show();
	        	esUnaCategoria = true;
	        } else {
	        	jQuery(this).hide();
	        }
    	});
    	if (esUnaCategoria && myText !== '') {
    		jQuery("div#caja_categorias").show();
    	} else {
    		jQuery("div#caja_categorias").hide();
    	}
    	esUnAutor = false;
		jQuery('ul#autores li').each(function() {
	        var li_text = getCleanedString(jQuery(this).text());
	        var n = li_text.includes(myText);
	        if (n) {
	        	jQuery(this).show();
	        	esUnAutor = true;
	        } else {
	        	jQuery(this).hide();
	        }
    	});
    	if (esUnAutor && myText !== '') {
    		jQuery("div#caja_autores").show();
    	} else {
    		jQuery("div#caja_autores").hide();
    	}
    	if (myText !== '') {
    		jQuery("div#caja_paises").show();
    	} else {
    		jQuery("div#caja_paises").hide();
    	}
	});


	// Marcar etiquetas
	jQuery("div#caja_categorias li a, div#caja_autores li a, div#caja_categorias li a, div#caja_paises li a").on("click", function(e) {
		e.preventDefault();
		if (jQuery(this).parent().hasClass("selected")) {
			return false;
		} else {
			jQuery(this).parent().clone().appendTo("div#caja_seleccion ul");
			jQuery(this).parent().addClass("selected");
		}
	});


	// Desmarcar etiquetas
	jQuery("div#caja_seleccion").on("click", "ul li a", function(e) {
		e.preventDefault();
		var data_name = jQuery(this).parent().attr("term-id");
		jQuery(this).parent().remove();
		jQuery("li.selected[term-id='" + data_name + "']").removeClass("selected");
	});


	// Submit del formulario del filtro
	jQuery("form#form_filter").submit(function(e) {
		
		e.preventDefault();
		
		var text = getCleanedString(jQuery("input#inputText").val());

		categorias = [];
		autores = [];
		paises = [];

		jQuery("div#caja_seleccion ul li").each(function() {
            if(jQuery(this).hasClass("autor"))
				autores.push(getCleanedString(jQuery(this).text()));
			else if(jQuery(this).hasClass("categoria"))
				categorias.push(getCleanedString(jQuery(this).attr("term-id")));
			else if(jQuery(this).hasClass("pais"))
				paises.push(getCleanedString(jQuery(this).attr("term-id")));
		});

		query_paises="";
		query_autores="";
		query_categorias="";

		filter = false;
		if(paises.length > 0){
			filter = true;
			query_paises = "(or wp_double_array:" + paises.join(" wp_double_array:") + ")";
		}
		if(autores.length > 0){
			filter = true;
			query_autores = "(or wp_text_array:'" + autores.join("' wp_text_array:'") + "')";
		}
		if(categorias.length > 0){
			filter = true;
			query_categorias = "(or wp_double_array:" + categorias.join(" wp_double_array:") + ")";	
		}
			
		if(text == "" && filter == false)
			return false;

		var url_buscador = 'http://d1xkg658gp8s5n.cloudfront.net/bbva-components/search?&q.parser=lucene&q=*' + text + '*&project=is8lyryw';
		if(filter)
			url_buscador += '&fq=(and '+query_categorias+ ' ' + query_autores + ' ' + query_paises + ')';

		jQuery.get(url_buscador, function(d) {

			if (d.code === 200 && d.data.hits.found > 0) {
				var results = '<ul>';
		        jQuery.each(d.data.hits.hit, function(i, result) {
		        	var image = (result.fields.image_src !== undefined) ? result.fields.image_src : '';
		            results += '<li><a href="/' + result.fields.resourcename + '"target="_blank">' + result.fields.title + ' ' + result.fields.date + ' ' + result.fields.category + ' ' + image + '</a></li>';
		        });
		        jQuery('#results').html(results + '</ul>');
		        if (d.data.hits.found <= size) {
					jQuery('div#moreLink').empty();
		        } else {
		        	jQuery('div#moreLink').html('<a href="javascript:void(0);" name="more" id="more">+ ' + object_name.more_results + '</a>');
		        }
		        jQuery('div#sortLinks').html('<a href="javascript:void(0);" class="changeSort" name="sortByAscDate" id="sortByAscDate">' +  object_name.sort_by_asc_date + '</a> <a href="javascript:void(0);" class="changeSort" name="sortByDescDate" id="sortByDescDate">' +  object_name.sort_by_desc_date + '</a> <a href="javascript:void(0);" class="changeSort" name="sortByPopular" id="sortByPopular">' +  object_name.sort_by_popular + '</a>');
			} else {
				jQuery('div#sortLinks').empty();
				jQuery('div#moreLink').empty();
				jQuery('#results').html(object_name.no_results);
			}

		}, 'json');


		return true;
	
	});

});
 

function getCleanedString(cadena){

	cadena = cadena.replace(/<(?:.|\n)*?>/gm, '');
	cadena = cadena.toLowerCase();
	cadena = cadena.replace(/á/gi,"a");
	cadena = cadena.replace(/é/gi,"e");
	cadena = cadena.replace(/í/gi,"i");
	cadena = cadena.replace(/ó/gi,"o");
	cadena = cadena.replace(/ú/gi,"u");
	cadena = cadena.replace(/ñ/gi,"n");
	cadena = cadena.replace(/ç/gi,"c");
	cadena = cadena.replace(/[^a-z0-9]/gi,' ');
	cadena = cadena.replace(/\s\s+/g, ' ');
	cadena = cadena.trim();
	
	return cadena;
}