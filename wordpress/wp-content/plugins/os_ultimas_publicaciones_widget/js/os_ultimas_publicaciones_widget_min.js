/*
<li id="noticia_{NUMERO}" class="col-md-4 col-sm-4 col-xs-12 ">
    <figure class="contenidoNoticias_boxImage">
        <img src="{IMAGEN}">
    </figure>
    <div class="contenidoNoticias_boxTexto">
        <p class="item_fecha">{FECHA}</p>
        <h3 class="item_titulo">{TITLE}</h3>
        <p class="item_contenido">{CONTENT}</p>
        <a target="_blank" href="{LINK}">Leer más</a>
    </div>
</li>
*/

jQuery(document).ready(function($) {

	var url_buscador = 'http://dquteo8n8b00y.cloudfront.net/bbva-components/search?&q.parser=lucene&q=(topic:"publicacion")&return=title%2Ctopic%2Ccategory%2Cdate%2Cimage_src&sort=date desc&size=3&start=0&project=irnbsadx';

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


	$("ul.lista_noticias").append("<li>esto es una prueba</li>");
});