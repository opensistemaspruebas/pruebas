/*jQuery(document).ready(function() {

	jQuery("input#inputText").focusin(function() {
		jQuery(this).val("");
		jQuery("div#caja_categorias").hide();
		jQuery("div#caja_paises").hide();
		jQuery("div#caja_autores").hide();
	});


	// Autocompletado de categorías, autores y ámbitos geográficos
	jQuery("input#inputText").on('input', function() {
		myText = getCleanedString(jQuery(this).val());
		if (myText.length < 3) {
			return false;
		}
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

});*/
 

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


function getSelectedTags() {
	texto = [];
	categorias = [];
	autores = [];
	paises = [];
	targetContainer = jQuery('#publishing-filter .selected-tags-container');
	if (targetContainer.is(':empty') == false) {
		targetContainer.children('.tag.selected-tag').each(function(i) {
			console.log(jQuery(this));
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


function getPostFiltro(post){

	var html = '';

	var titulo = post['title'];
	var descripcion = post['content'];
	var fecha = new Date(post['date'].substring(0, 10));
	var urlImagen = post['image_src'];
	var urlPublicacion = post['resourcename'];
	var cita = true;
	var video = true;
	var pdf = true;


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
    if (cita == true || true)  {
        html += '<div class="card-icon"><span class="icon bbva-icon-quote2"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div>';
    }
    if (video == true || true)  {
        html += '<div class="card-icon"><span class="icon bbva-icon-audio2"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div>';
    }
    if (pdf == true || true)  {
        html += '<div class="card-icon"><span class="icon bbva-icon-chat2"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div>';
	}
	html += '</div></footer></div></section></div>';

	return html;
}


jQuery(document).ready(function($) {
	
	$('button.btn-bbva-aqua.publishing-filter-search-btn').on('click', function(e) {

		e.preventDefault();
		e.stopPropagation();
		
		console.log("He hecho click");
		
		tags = getSelectedTags();
		
		texto = tags[0].join(' ');
		categorias = tags[1];
		autores = tags[2];
		paises = tags[3];
		
		query_paises="";
		query_autores="";
		query_categorias="";

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
			
		if (texto == "" && filter == false)
			return false;

		var url_buscador = 'http://d1xkg658gp8s5n.cloudfront.net/bbva-components/search?&q.parser=lucene&q=*' + texto + '*&project=is8lyryw';
		if(filter)
			url_buscador += '&fq=(and '+query_categorias+ ' ' + query_autores + ' ' + query_paises + ')';

		var url_buscador = 'http://d1xkg658gp8s5n.cloudfront.net/bbva-components/search?&q.parser=lucene&q=*' + texto + '*&project=is8lyryw';
		if (filter) {
		    url_buscador += '&fq=(and' + query_categorias + query_autores + query_paises + ')';
		}

		//var d = {"code":200, "data":{"status":{"rid":"i4vxuf8q2gMKYY/r", "time-ms":18 }, "hits":{"found":21, "start":0, "hit":[{"id":"is8lyrywhistoria/heterogeneidad-y-difusion-de-la-economia-digital-el-caso-espanol-2/index.html", "fields":{"project":"is8lyryw", "title":"Heterogeneidad y difusión de la economía digital: el caso español", "image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/informe3.png", "content":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris rutrum lacus eu gravida aliquam. Vestibulum scelerisque tempor velit ut dapibus. Phasellus vitae tincidunt est. Nulla auctor, est id porta pulvinar, ipsum nunc tincidunt sem, eget ultrices neque eros et massa. Nunc a pulvinar est. Fusce convallis tellus orci, a gravida sem eleifend at. Sed dapibus suscipit quam et sollicitudin. Praesent molestie tristique justo in blandit. Integer. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris rutrum lacus eu gravida aliquam. Vestibulum scelerisque tempor velit ut dapibus. Phasellus vitae tincidunt est.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris rutrum lacus eu gravida aliquam. Vestibulum scelerisque tempor velit ut dapibus. Phasellus vitae tincidunt est.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris rutrum lacus eu gravida aliquam. Vestibulum scelerisque tempor velit ut dapibus. Phasellus vitae tincidunt est. Nulla auctor, est id porta pulvinar, ipsum nunc tincidunt sem, eget ultrices neque eros et massa. Nunc a pulvinar est. Fusce convallis tellus orci, a gravida sem eleifend at. Sed dapibus suscipit quam et sollicitudin. Praesent molestie tristique justo in blandit. Integer.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris rutrum lacus eu gravida aliquam. Vestibulum scelerisque tempor velit ut dapibus. Phasellus vitae tincidunt est.", "topic":"historia", "content_language":"es", "date":"2016-10-21T17:00:00Z", "resourcename":"historia/heterogeneidad-y-difusion-de-la-economia-digital-el-caso-espanol-2/index.html", "wp_double_array":["17.0"], "wp_text_array":["marta oliver"] } }, {"id":"is8lyrywpublicacion/proin-luctus-mi-ut-nibh-iaculis-fermentum-9/index.html", "fields":{"project":"is8lyryw", "title":"Pdf 2016-10-18", "image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/historia2.png", "content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.", "topic":"publicacion", "content_language":"es", "date":"2005-10-05T17:00:00Z", "resourcename":"publicacion/proin-luctus-mi-ut-nibh-iaculis-fermentum-9/index.html", "wp_double_array":["17.0", "19.0", "30.0"], "wp_text_array":["marta oliver"] } }, {"id":"is8lyrywpublicacion/pellentesque-sem-tortor-bibendum-et-ante-id-aliquet-imperdiet-lorem/index.html", "fields":{"project":"is8lyryw", "title":"Pdf 2016-10-07 d", "image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/informe2.png", "content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.", "topic":"publicacion", "content_language":"es", "date":"2016-01-05T17:00:00Z", "resourcename":"publicacion/pellentesque-sem-tortor-bibendum-et-ante-id-aliquet-imperdiet-lorem/index.html", "wp_double_array":["32.0", "19.0"], "wp_text_array":["marta oliver", "katie morell"] } }, {"id":"is8lyrywhistoria/heterogeneidad-y-difusion-de-la-economia-digital-el-caso-espanol/index.html", "fields":{"project":"is8lyryw", "title":"Heterogeneidad y difusión de la economía digital: el caso español", "image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/historia1.png", "content":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris rutrum lacus eu gravida aliquam. Vestibulum scelerisque tempor velit ut dapibus. Phasellus vitae tincidunt est. Nulla auctor, est id porta pulvinar, ipsum nunc tincidunt sem, eget ultrices neque eros et massa. Nunc a pulvinar est. Fusce convallis tellus orci, a gravida sem eleifend at. Sed dapibus suscipit quam et sollicitudin. Praesent molestie tristique justo in blandit. Integer. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris rutrum lacus eu gravida aliquam. Vestibulum scelerisque tempor velit ut dapibus. Phasellus vitae tincidunt est.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris rutrum lacus eu gravida aliquam. Vestibulum scelerisque tempor velit ut dapibus. Phasellus vitae tincidunt est.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris rutrum lacus eu gravida aliquam. Vestibulum scelerisque tempor velit ut dapibus. Phasellus vitae tincidunt est. Nulla auctor, est id porta pulvinar, ipsum nunc tincidunt sem, eget ultrices neque eros et massa. Nunc a pulvinar est. Fusce convallis tellus orci, a gravida sem eleifend at. Sed dapibus suscipit quam et sollicitudin. Praesent molestie tristique justo in blandit. Integer.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris rutrum lacus eu gravida aliquam. Vestibulum scelerisque tempor velit ut dapibus. Phasellus vitae tincidunt est.", "topic":"historia", "content_language":"es", "date":"2016-10-21T17:00:00Z", "resourcename":"historia/heterogeneidad-y-difusion-de-la-economia-digital-el-caso-espanol/index.html", "wp_double_array":["17.0"], "wp_text_array":["marta oliver"] } }, {"id":"is8lyrywpublicacion/proin-luctus-mi-ut-nibh-iaculis-fermentum-2/index.html", "fields":{"project":"is8lyryw", "title":"Pdf 2016-10-10 d", "image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/historia2.png", "content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.", "topic":"publicacion", "content_language":"es", "date":"2013-10-05T17:00:00Z", "resourcename":"publicacion/proin-luctus-mi-ut-nibh-iaculis-fermentum-2/index.html", "wp_double_array":["17.0", "19.0", "30.0"], "wp_text_array":["marta oliver", "katie morell"] } }, {"id":"is8lyrywpublicacion/proin-luctus-mi-ut-nibh-iaculis-fermentum-3/index.html", "fields":{"project":"is8lyryw", "title":"Pdf 2016-10-12", "image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/historia2.png", "content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.", "topic":"publicacion", "content_language":"es", "date":"2011-10-05T17:00:00Z", "resourcename":"publicacion/proin-luctus-mi-ut-nibh-iaculis-fermentum-3/index.html", "wp_double_array":["17.0", "19.0", "30.0"], "wp_text_array":["marta oliver", "katie morell"] } }, {"id":"is8lyrywpublicacion/lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-2/index.html", "fields":{"project":"is8lyryw", "title":"Pdf 2016-10-06 d", "image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/09/publicacion6.jpg", "content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.", "topic":"publicacion", "content_language":"es", "date":"2016-02-12T17:00:00Z", "resourcename":"publicacion/lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-2/index.html", "wp_double_array":["38.0", "19.0"], "wp_text_array":["marta oliver", "katie morell"] } }, {"id":"is8lyrywpublicacion/lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-3/index.html", "fields":{"project":"is8lyryw", "title":"Pdf 2016-10-08", "image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/historia2.png", "content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.", "topic":"publicacion", "content_language":"es", "date":"2015-10-05T17:00:00Z", "resourcename":"publicacion/lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-3/index.html", "wp_double_array":["18.0", "27.0"], "wp_text_array":["marta oliver", "katie morell"] } }, {"id":"is8lyrywpublicacion/proin-luctus-mi-ut-nibh-iaculis-fermentum-7/index.html", "fields":{"project":"is8lyryw", "title":"Pdf 2016-10-16", "image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/historia2.png", "content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.", "topic":"publicacion", "content_language":"es", "date":"2007-10-05T17:00:00Z", "resourcename":"publicacion/proin-luctus-mi-ut-nibh-iaculis-fermentum-7/index.html", "wp_double_array":["17.0", "19.0", "30.0"], "wp_text_array":["marta oliver"] } }, {"id":"is8lyrywpublicacion/in-laoreet-accumsan-nibh-sit-amet-euismod-urna-rhoncus-sed/index.html", "fields":{"project":"is8lyryw", "title":"Pdf 2016-10-30 d", "image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/informe3.png", "content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.", "topic":"publicacion", "content_language":"es", "date":"2016-04-05T17:00:00Z", "resourcename":"publicacion/in-laoreet-accumsan-nibh-sit-amet-euismod-urna-rhoncus-sed/index.html", "wp_double_array":["18.0", "19.0", "30.0"], "wp_text_array":["marta oliver", "katie morell"] } } ] } } };

		jQuery.get(url_buscador, function(d) {

		    if (d.code === 200 && d.data.hits.found > 0) {
		        jQuery('.cards-grid .container div.row').first().empty();
		        jQuery.each(d.data.hits.hit, function(i, result) {
		        	if (result.fields.topic == 'publicacion') {
		        		jQuery('.cards-grid .container div.row').first().append(getPostFiltro(result.fields));
		        	}
		        });
		    } else {
		        jQuery('.cards-grid .container div.row').html(object.no_results);
		    }

		}, 'json');
	});
});