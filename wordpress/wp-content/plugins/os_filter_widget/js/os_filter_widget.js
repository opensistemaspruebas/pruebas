jQuery(document).ready(function() {
	
	jQuery("form#form_filter").change(function() {
		var sortBy = jQuery("#inputSortBy").val("date desc");
		var size = jQuery("#size").val("7");
		var start = jQuery("#start").val("0");
	});

	// Submit del formulario del filtro
	jQuery("form#form_filter").submit(function(e) {
		
		e.preventDefault();
		
		var text = jQuery("input#inputText").val();
		
		var tags = [];
		var categories = jQuery("#selectCategory").val();
		var authors = jQuery("#selectAuthor").val();
		var countries = jQuery("#selectCountry").val();
		var sortBy = jQuery("#inputSortBy").val();
		var size = jQuery("#size").val();
		var start = jQuery("#start").val();

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

			var url_buscador = 'http://dquteo8n8b00y.cloudfront.net/bbva-components/search?&q.parser=lucene&q=' + query + ' AND (topic:"post")' + aux + '&return=title%2Ctopic%2Ccategory%2Cdate%2Cimage_src' + '&sort=' + sortBy + '&size=' + size + '&start=' + start + '&project=irnbsadx';

			$.get(url_buscador, function(d) {

				if (d.code === 200 && d.data.hits.found > 0) {
					var results = '<ul>';
			        $.each(d.data.hits.hit, function(i, result) {
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

	// Links de cambiar ordenación
	jQuery(document).on("click", "a.changeSort", function(e) {
		
		e.preventDefault();
		e.stopPropagation();

		var sortBy = jQuery(this).attr("id");

		var sort = 'date%20desc';

		switch(sortBy) {
		    case 'sortByAscDate':
		        sort = 'date asc';
		        break;
		    case 'sortByDescDate':
		        sort = 'date desc';
		        break;
		     case 'sortByPopular':
		     	sort = 'sortByPopular';
		     	break;
		}

		jQuery("#inputSortBy").val(sort);

		jQuery("form#form_filter").submit();		

		return true;

	});

	// Link para mostrar más publicaciones
	jQuery(document).on("click", "a#more", function(e) {
		
		e.preventDefault();
		e.stopPropagation();

		var size = jQuery("#size").val();

		jQuery("#size").val(size * 2);
		jQuery("form#form_filter").submit();

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