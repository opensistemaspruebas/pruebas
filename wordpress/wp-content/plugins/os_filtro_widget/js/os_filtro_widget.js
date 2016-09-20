jQuery(document).ready(function() {

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
			
			query = '';
			wp_double_array = '';
			wp_text_array = '';

			jQuery("ul#seleccion li").each(function() {
				if (jQuery(this).hasClass("autor")) {
					wp_text_array += '+"' + jQuery(this).attr("term-id") + '"';
				} else {
					wp_double_array += '+"' + jQuery(this).attr("term-id") + '"';
				}
			});

			if (wp_text_array) {
				query += 'wp_text_array:(' + wp_text_array + ')';
				if (wp_double_array) {
					query += 'AND wp_double_array:(' + wp_double_array + ')';
				}
			} else if (wp_double_array) {
				query += 'wp_double_array:(' + wp_double_array + ')';
			} else {
				return false;
			}


			var url_buscador = 'http://d1xkg658gp8s5n.cloudfront.net/bbva-components/search?&q.parser=lucene&q=' + query + '&return=wp_double_array%2Cwp_text_array&project=is8lyryw';
			
			var terms = [];
			var authors = [];
			
			jQuery.get(url_buscador, function(d, terms, authors) {
				
				if (d.code === 200 && d.data.hits.found > 0) {
			        
			        jQuery.each(d.data.hits.hit, function(i, result) {
			        	
			        	var terms_aux = result.fields.wp_double_array;
			        	var authors_aux = result.fields.wp_text_array;
			        	
			        	for (var i = 0; i < terms_aux.length; i++) {
			        		terms.push(terms_aux[i]);
			        	}
			        	
			        	for (var j = 0; j < authors_aux.length; j++) {
			        		authors.push(authors_aux[j]);
			        	}
			        
			        });
				
				} else {
					// No hay ninguna categoría relacionada
				}
			}, 'json');

			console.log(terms);
			console.log(authors);

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

		categorias = "";
		autor = "";
		paises = "";

		jQuery("div#caja_seleccion ul li.categoria").each(function() {
			categorias += getCleanedString(jQuery(this).text()) + ',';
		});
		categorias = categorias.substring(0, categorias.length - 1);
		
		var tags = [];
		var categories = jQuery("#selectCategory").val();
		var authors = jQuery("#selectAuthor").val();
		var countries = jQuery("#selectCountry").val();
		var sortBy = jQuery("#inputSortBy").val();
		var size = jQuery("#size").val();
		var start = jQuery("#start").val();
		var topic = jQuery("#topic").val();

		tags = (categories) ? tags.concat(categories) : tags;
		tags = (authors) ? tags.concat(authors) : tags;
		tags = (countries) ? tags.concat(countries) : tags;

		if (text || tags.length > 0) {

			var query = '';

			if (tags.length > 0) {
				for (var i = 0; i < tags.length; i++) { 
					tags[i] = getCleanedString(tags[i]);
				}
			}

			var tags_string = (tags.length > 0) ? '"' + tags.join('"+"') + '"' : '';

			text = getCleanedString(text);
			tags_string = tags_string;

			var aux = (sortBy == "sortByPopular") ? ' AND (category:"interesante")' : '';
			sortBy = (sortBy == "sortByPopular") ? 'date desc' : sortBy;
			query += (text) ? '(title:("' + text + '") OR content:("' + text + '"))' : '';
			query += (text && tags_string) ? ' AND ' : '';
			query += (tags_string) ? '(category:(' + tags_string + '))' : '';

			//var url_buscador = 'http://dquteo8n8b00y.cloudfront.net/bbva-components/search?&q.parser=lucene&q=' + query + ' AND (topic:"publicacion")' + aux + '&return=title%2Ctopic%2Ccategory%2Cdate%2Cimage_src' + '&sort=' + sortBy + '&size=' + size + '&start=' + start + '&project=irnbsadx';
			var url_buscador = 'http://d1xkg658gp8s5n.cloudfront.net/bbva-components/search?&q.parser=lucene&q=*' + text + '*&project=is8lyryw';

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

		}

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