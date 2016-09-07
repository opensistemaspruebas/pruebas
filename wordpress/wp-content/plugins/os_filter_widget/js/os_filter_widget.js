$(document).ready(function() {
	
	/*$('#f').keyup(function() {
    	//$('#field2hidden').val($(this).val());
    	console.log($(this).val());
	
	});*/

	// Submit del formulario del filtro
	$("form#form_filter").submit(function(e) {
		
		e.preventDefault();
		
		console.log('Form is submitting....');

		var texto = $("input#inputText").val();
		var categoria = $("input#inputCategory").val();
		var autor = $("input#inputAuthor").val();
		var geografia = $("input#inputGeography").val();

		if (texto || categoria || autor || geografia) {

			//var query = '*' + texto + '* AND topic:"post"';
			var query = '';

			(texto) ? query += '(title:"*' + texto + '*" OR content:"*' + texto + '*")' : query += '';
			
			(texto) ? query += ' AND ' : query += '';
			(categoria) ? query += 'category:"' + categoria + '"' : query += '';
			
			(categoria) ? query += ' AND ' : query += '';
			(autor) ? query += 'author:"' + autor + '"' : query += '';
			
			(autor) ? query += ' AND ' : query += '';
			(geografia) ? query += 'geography:"' + geografia + '"' : query += '';
			
			(geografia) ? query += ' AND ' : query += '';
			query += 'topic:"post"';
			
			var url_buscador = 'http://dquteo8n8b00y.cloudfront.net/bbva-components/search?&q=' + query + '&q.parser=lucene&return=title%2Cresourcename%2Cdescription%2Cdomain%2Cimage_src%2Ctopic%2Ccategory%2Cdate&size=50&start=0&project=irnbsadx';

			jQuery.get(url_buscador, function(d) {

				if (d.code === 200 && d.data.hits.found > 0) {
					var results = '<ul>';
			        jQuery.each(d.data.hits.hit, function(i, result) {
			            results += '<li><a href="/' + result.fields.resourcename + '"target="_blank">' + result.fields.title + '</a></li>';
			        });
			        jQuery('#results').html(results + '</ul>');
				} else {
					jQuery('#results').html("No hay resultados.");
				}

			}, 'json');

		}

		return true;
	
	});

});