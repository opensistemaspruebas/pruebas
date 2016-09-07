$(document).ready(function() {
	
	/*$('#f').keyup(function() {
    	//$('#field2hidden').val($(this).val());
    	console.log($(this).val());
	
	});*/

	$("form#form_filter").change(function() {
		var sortBy = $("#inputSortBy").val("sortByDescDate");
		var size = $("#size").val("7");
		var start = $("#start").val("0");
	});

	// Submit del formulario del filtro
	$("form#form_filter").submit(function(e) {
		
		e.preventDefault();
		
		var text = $("input#inputText").val();
		
		var tags = [];
		var categories = $("#selectCategory").val();
		var authors = $("#selectAuthor").val();
		var countries = $("#selectCountry").val();
		var sortBy = $("#inputSortBy").val();
		var size = $("#size").val();
		var start = $("#start").val();

		tags = (categories) ? tags.concat(categories) : tags;
		tags = (authors) ? tags.concat(authors) : tags;
		tags = (countries) ? tags.concat(countries) : tags;

		if (text || tags.length > 0) {

			var query = '';

			var tags_string = (tags.length > 0) ? '"' + tags.join('"+"') + '"' : '';

			text = text;
			tags_string = tags_string;

			query += (text) ? '(*' + text + '*)' : '';
			query += (text && tags_string) ? ' AND ' : '';
			query += (tags_string) ? '(category:(' + tags_string + '))' : '';

			var url_buscador = 'http://dquteo8n8b00y.cloudfront.net/bbva-components/search?&q.parser=lucene&q=(' + query + ' AND (topic:"post"))&return=title%2Ctopic%2Ccategory%2Cdate%2Cimage_src&size=' + size + '&start=' + start + '&project=irnbsadx';

			$.get(url_buscador, function(d) {

				if (d.code === 200 && d.data.hits.found > 0) {
					var results = '<ul>';
			        $.each(d.data.hits.hit, function(i, result) {
			        	var image = (result.fields.image_src !== undefined) ? result.fields.image_src : '';
			            results += '<li><a href="/' + result.fields.resourcename + '"target="_blank">' + result.fields.title + ' ' + result.fields.date + ' ' + result.fields.category + ' ' + image + '</a></li>';
			        });
			        $('#results').html(results + '</ul>');
			        if (d.data.hits.found <= size) {
						$('div#moreLink').empty();
			        } else {
			        	$('div#moreLink').html('<a href="javascript:void(0);" name="more" id="more">+ ' + object_name.more_results + '</a>');
			        }
			        $('div#sortLinks').html('<a href="javascript:void(0);" class="changeSort" name="sortByAscDate" id="sortByAscDate">' +  object_name.sort_by_asc_date + '</a> <a href="javascript:void(0);" class="changeSort" name="sortByDescDate" id="sortByDescDate">' +  object_name.sort_by_desc_date + '</a> <a href="javascript:void(0);" class="changeSort" name="sortByPopular" id="sortByPopular">' +  object_name.sort_by_popular + '</a>');
				} else {
					$('div#sortLinks').empty();
					$('div#moreLink').empty();
					$('#results').html(object_name.no_results);
				}

			}, 'json');

		}

		return true;
	
	});

	// Links de cambiar ordenación
	$("a.changeSort").click(function(e) {
		
		e.preventDefault();
		e.stopPropagation();

		var sortBy = $(this).attr("id");
		console.log(sortBy);
		$("#inputSortBy").val(sortBy);

		return true;

	});

	// Link para mostrar más publicaciones
	$(document).on("click", "a#more", function(e) {
		
		e.preventDefault();
		e.stopPropagation();

		var size = $("#size").val();

		$("#size").val(size * 2);
		$("form#form_filter").submit();

		return true;

	});

});