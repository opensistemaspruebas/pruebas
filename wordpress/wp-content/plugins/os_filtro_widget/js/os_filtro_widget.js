function getSelectedTags() {
	texto = [];
	categorias = [];
	autores = [];
	paises = [];
	targetContainer = jQuery('#publishing-filter .selected-tags-container');
	if (targetContainer.is(':empty') == false) {
		targetContainer.children('.tag.selected-tag').each(function(i) {
			type = jQuery(this).attr('from');
			id = (jQuery(this).attr('id')).replace('tag-', '');
			nombre = getCleanedString(jQuery(this).children('span').last().html());
			switch(type) {
			    case 'geo-container':
			        paises.push(id);
			        break;
			    case 'author-container':
			        autores.push(nombre);
			        break;
			    case 'tag-container':
			        categorias.push(id);
			        break;
			    default:
			        texto.push(nombre);
			}
		});
	}
	tags = [texto, categorias, autores, paises];
	return tags;	
}


function getPostFiltro(post) {

	var html = '';

	var titulo = post['title'];
	var descripcion = post['content'];
	var fecha = new Date(post['date'].substring(0, 10));
	var urlImagen = post['image_src'];
	var urlPublicacion = '/' + post['resourcename'];

	var keywords = post['keywords'];

	var cita = false;
	var video = false;
	var pdf = false;

	if (keywords !== undefined) {
		if ( jQuery.inArray('video', keywords) > -1 ) {
		    video = true;
		}
	}

	var meses = [
		object_name_cards.enero, 
		object_name_cards.febrero,
		object_name_cards.marzo,
		object_name_cards.abril,
		object_name_cards.mayo,
		object_name_cards.junio,
		object_name_cards.julio,
		object_name_cards.agosto,
		object_name_cards.septiembre,
		object_name_cards.octubre,
		object_name_cards.noviembre,
		object_name_cards.diciembre,
	];

	fecha = fecha.getDate() + ' ' +  meses[fecha.getMonth()] + ' ' + fecha.getFullYear();
	fecha = fecha.toString();
	fecha = fecha.toUpperCase();


	order = ['double', 'double', 'triple', 'triple', 'triple'];
	i = jQuery('.card-container').size();
	grid = order[(i % 5)];
	if (grid == "double") {
		html = '<div class="col-xs-12 col-sm-6 double-card card-container">';
	} else {
		html = '<div class="col-xs-12 col-sm-4 triple-card card-container">';
	}
	html += '<section class="container-fluid main-card"><header class="row header-container"><div class="image-container col-xs-12"><a href="' + urlPublicacion + '" class="link-header-layer visible-xs"><img src="' + urlImagen + '" alt=""></a><img src="' + urlImagen + '" alt="" class="hidden-xs"></div><div class="hidden-xs floating-text col-xs-9"><p class="date">' + fecha + '</p><h1>' + titulo + '</h1></div></header><div class="row data-container"><a href="#" class="link-layer visible-xs">&nbsp;</a><div class="nopadding date">' + fecha + '</div><div class="main-card-data-container-title-wrapper"><h1 class="title nopadding">' + titulo + '</h1></div><p class="main-card-data-container-description-wrapper">' + descripcion + '</p><a href="' + urlPublicacion + '" class="hidden-xs mb-xs readmore">' + object_name_cards.leer_mas + '</a><footer><div class="icon-row">';
    if (cita)  {
        html += '<div class="card-icon"><span class="icon bbva-icon-quote2"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div>';
    }
    if (video)  {
        html += '<div class="card-icon"><span class="icon bbva-icon-audio2"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div>';
    }
    if (pdf)  {
        html += '<div class="card-icon"><span class="icon bbva-icon-chat2"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div>';
	}
	html += '</div></footer></div></section></div>';

	return html;
}


function buscar() {
	tags = getSelectedTags();
	textoInput = jQuery('.search input.publishing-filter-search-input').val();
	texto = textoInput + ' ' + tags[0].join(' ');
	texto = getCleanedString(texto);


	if (tags[0].length == 0 && tags[1].length == 0 && tags[2].length == 0 && tags[3].length == 0 && texto.length == 0) {
		jQuery('a[data-order=DESTACADOS]').show();
	}


	categorias = tags[1];
	autores = tags[2];
	paises = tags[3];


	query_paises = "";
	query_autores = "";
	query_categorias = "";
	query_destacados = "";

	start = jQuery("input#start").val();
	order = jQuery("input#sortBy").val();
	if (order == 'destacados') {
		//jQuery('a[data-order=DESTACADOS]').removeClass('selected');
		//jQuery('a[data-order=DESC]').addClass('selected');
		order = 'date desc';
		tipo = 'publicacion';
		query_destacados += '(or keywords:\'destacada\')';
	} else {
		tipo = 'publicacion';
	}

	filter = false;
	if (paises.length > 0){
		filter = true;
		query_paises = "(or wp_double_array:" + paises.join(" wp_double_array:") + ")";
	}
	if (autores.length > 0){
		filter = true;
		query_autores = "(or wp_text_array:'" + autores.join("' wp_text_array:'") + "')";
	}
	if (categorias.length > 0){
		filter = true;
		query_categorias = "(or wp_double_array:" + categorias.join(" wp_double_array:") + ")";	
	}

	var url_buscador = 'http://d1xkg658gp8s5n.cloudfront.net/bbva-components/search?&q.parser=lucene&q=*' + texto + '*&project=is8lyryw';
	if (filter) {
	    url_buscador += '&fq=(and' + query_categorias + query_autores + query_paises + query_destacados + '(or topic:\'' + tipo + '\')(or content_language:\'' + object_name.lang + '\'))';
	} else {
		url_buscador += '&fq=(and(or topic:\'' + tipo + '\')(or content_language:\'' + object_name.lang + '\')' + query_destacados + ')';
	}
	url_buscador += '&start=' + start + '&sort=' + order;

	//var d = {"code":200,"data":{"status":{"rid":"la3OgYArixgKYY/r","time-ms":4},"hits":{"found":17,"start":0,"hit":[{"id":"is8lyrywpublicacion/in-laoreet-accumsan-nibh-sit-amet-euismod-urna-rhoncus-sed/index.html","fields":{"project":"is8lyryw","title":"Pdf 2016-10-30 d","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/informe3.png","content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.","topic":"publicacion","content_language":"es-ES","date":"2016-04-05T17:00:00Z","resourcename":"publicacion/in-laoreet-accumsan-nibh-sit-amet-euismod-urna-rhoncus-sed/index.html","wp_double_array":["18.0","19.0","30.0"],"wp_text_array":["marta oliver","katie morell"]}},{"id":"is8lyrywpublicacion/proin-luctus-mi-ut-nibh-iaculis-fermentum-3/index.html","fields":{"project":"is8lyryw","title":"Pdf 2016-10-12","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/historia2.png","content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.","topic":"publicacion","content_language":"es-ES","date":"2011-10-05T17:00:00Z","resourcename":"publicacion/proin-luctus-mi-ut-nibh-iaculis-fermentum-3/index.html","wp_double_array":["17.0","19.0","30.0"],"wp_text_array":["marta oliver","katie morell"]}},{"id":"is8lyrywpublicacion/proin-luctus-mi-ut-nibh-iaculis-fermentum-2/index.html","fields":{"project":"is8lyryw","title":"Pdf 2016-10-10 d","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/historia2.png","content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.","topic":"publicacion","content_language":"es-ES","date":"2013-10-05T17:00:00Z","resourcename":"publicacion/proin-luctus-mi-ut-nibh-iaculis-fermentum-2/index.html","wp_double_array":["17.0","19.0","30.0"],"wp_text_array":["marta oliver","katie morell"]}},{"id":"is8lyrywpublicacion/lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-2/index.html","fields":{"project":"is8lyryw","title":"Pdf 2016-10-06 d","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/09/publicacion6.jpg","content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.","topic":"publicacion","content_language":"es-ES","date":"2016-02-12T17:00:00Z","resourcename":"publicacion/lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-2/index.html","wp_double_array":["38.0","19.0"],"wp_text_array":["marta oliver","katie morell"]}},{"id":"is8lyrywpublicacion/pellentesque-sem-tortor-bibendum-et-ante-id-aliquet-imperdiet-lorem/index.html","fields":{"project":"is8lyryw","title":"Pdf 2016-10-07 d","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/informe2.png","content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.","topic":"publicacion","content_language":"es-ES","date":"2016-01-05T17:00:00Z","resourcename":"publicacion/pellentesque-sem-tortor-bibendum-et-ante-id-aliquet-imperdiet-lorem/index.html","wp_double_array":["32.0","19.0"],"wp_text_array":["marta oliver","katie morell"]}},{"id":"is8lyrywpublicacion/proin-luctus-mi-ut-nibh-iaculis-fermentum-5/index.html","fields":{"project":"is8lyryw","title":"Pdf 2016-10-14","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/historia2.png","content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.","topic":"publicacion","content_language":"es-ES","date":"2009-10-05T17:00:00Z","resourcename":"publicacion/proin-luctus-mi-ut-nibh-iaculis-fermentum-5/index.html","wp_double_array":["17.0","19.0","30.0"],"wp_text_array":["marta oliver","katie morell"]}},{"id":"is8lyrywpublicacion/lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-4/index.html","fields":{"project":"is8lyryw","title":"Pdf 2016-10-05 d","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/historia3.png","content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.","topic":"publicacion","content_language":"es-ES","date":"2016-03-05T17:00:00Z","resourcename":"publicacion/lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-4/index.html","wp_double_array":["18.0","19.0","30.0"],"wp_text_array":["marta oliver","katie morell"]}},{"id":"is8lyrywpublicacion/lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit/index.html","fields":{"project":"is8lyryw","title":"Pdf 2016-10-09","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/09/informe1.png","content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.","topic":"publicacion","content_language":"es-ES","date":"2015-01-01T17:00:00Z","resourcename":"publicacion/lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit/index.html","wp_double_array":["18.0","27.0"],"wp_text_array":["marta oliver","katie morell"]}},{"id":"is8lyrywpublicacion/lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-3/index.html","fields":{"project":"is8lyryw","title":"Pdf 2016-10-08","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/historia2.png","content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.","topic":"publicacion","content_language":"es-ES","date":"2015-10-05T17:00:00Z","resourcename":"publicacion/lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-3/index.html","wp_double_array":["18.0","27.0"],"wp_text_array":["marta oliver","katie morell"]}},{"id":"is8lyrywpublicacion/proin-luctus-mi-ut-nibh-iaculis-fermentum-8/index.html","fields":{"project":"is8lyryw","title":"Pdf 2016-10-17","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/historia2.png","content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.","topic":"publicacion","content_language":"es-ES","date":"2006-10-05T17:00:00Z","resourcename":"publicacion/proin-luctus-mi-ut-nibh-iaculis-fermentum-8/index.html","wp_double_array":["17.0","19.0","30.0"],"wp_text_array":["marta oliver"]}}]}}};

	jQuery.get(url_buscador, function(d) {
	    if (d.code === 200 && d.data.hits.found > 0) {
	    	if (d.data.hits.start == 0)
	        	jQuery('.cards-grid .container div.row').first().empty();
	        jQuery.each(d.data.hits.hit, function(i, result) {
	        	jQuery('.cards-grid .container div.row').first().append(getPostFiltro(result.fields));
	        });
	        if (d.data.hits.found == jQuery(".card-container").size()) {
	        	jQuery('a#readmore').hide();
	        } else {
	        	jQuery('a#readmore').show();
	        }
	    } else {
	        jQuery('.cards-grid .container div.row').first().html('<p>' + object_name.no_results + '</p>');
	        jQuery('a#readmore').hide();
	    }
	}, 'json');
}


jQuery(document).ready(function($) {

	buscando = false;
	
	$('#publishing-filter .publishing-filter-search-btn').on('click', function(e) {

		e.preventDefault();
		e.stopPropagation();
		
		$("input#start").attr('value', 0);

		buscando = true;
		//$('a[data-order=DESTACADOS]').hide();
		
		buscar();
	
	});

	$(document).on("change", ".selected-tags-container", function(event) {
		$("input#start").attr('value', 0);
	});


	$(document).on("click", "#readmore", function(event) {
		event.preventDefault();
		event.stopPropagation();
		event.stopImmediatePropagation();

		if (!buscando) {
			return;
		}
		start = parseInt(jQuery("input#start").val()) + 10;
		$("input#start").attr('value', start);
		buscar();
	});


	$(document).on("click", '.sort-items-container a', function(event) {
		
		event.preventDefault();
		event.stopPropagation();

		if (!buscando) {
			return;
		}
		orden = jQuery(this).attr("data-order-filter");
		$("input#sortBy").val(orden);
		jQuery('.sort-items-container a.selected').removeClass("selected");
		jQuery(this).addClass("selected");
		$("input#start").attr('value', 0);
		buscar();
	
	});


});