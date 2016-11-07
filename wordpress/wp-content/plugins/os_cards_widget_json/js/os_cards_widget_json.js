// Ver mas publicaciones
jQuery(document).on("click", "#publishing-view #readmore", function(event) {
	event.preventDefault();
	if (buscando) {
		return;
	}
	var tipo = jQuery("#tipo").val();
	var orden_cards = jQuery("#orden").val();
	var path = "/wp-content/jsons/" + tipo + "/";
	jQuery.getJSON(path + orden_cards + ".json", getIndice);
});


// Cambiar el orden
jQuery(document).on("click", '#publishing-view .sort-items-container a', function(event) {
	event.preventDefault();
	var orden_cards = jQuery(this).attr("data-order");
	console.log(orden_cards);
	if (orden_cards !== "DESTACADOS" && buscando) {
		return;
	}
	buscando = false;
	var tipo = jQuery("#tipo").val();
	orden_filter = jQuery(this).attr("data-order-filter");
	jQuery("input#sortBy").val(orden_filter);
	jQuery("#orden").val(orden_cards);
	var path = "/wp-content/jsons/" + tipo + "/";
	jQuery('.cards-grid .container div.row').first().html('');
	jQuery('#card-container').html('');
	jQuery('.outstanding-histories .card-container .row').first().html('');
	jQuery("#npc").val(0);
	jQuery.getJSON(path + orden_cards + ".json", getIndice);
	jQuery('.sort-items-container a.selected').removeClass("selected");
	jQuery(this).addClass("selected");
});


// Obtener indice
function getIndice(indice) {
	var npv = parseInt(jQuery("#npv").val());
	var npt = parseInt(jQuery("#npt").val());
	var npc = parseInt(jQuery("#npc").val());

	var fin = 0;
	if (npc == 0) {
		fin = npc + npt;
	} else {
		fin = npc + npv;
	}
	loop(npc, fin, indice);

}


function loop(i, fin, indice, onDone){
    if (i >= indice.length || i >= fin){
        //base case
        if (i >= indice.length)
        	jQuery('a#readmore').hide();
        else
        	jQuery('a#readmore').show();
        jQuery("#npc").val(i);
    } else {
		
		var tipo = jQuery("#tipo").val();
		var orden_cards = jQuery("#orden").val();
		var path = "/wp-content/jsons/" + tipo + "/";
		
		jQuery.getJSON(path + indice[i] + ".json", function(post) {
			var plantilla = jQuery("#plantilla").val();
			switch(plantilla) {

			case 'plantilla_1':
				jQuery('section.latests-posts .card-container div:first').append(getPost(post));
				break;

			case 'plantilla_2':
				jQuery('.cards-grid .container div.row').first().append(getPost(post));
				break;

			case 'plantilla_3':
				jQuery('section.outstanding-histories .card-container div:first').first().append(getPost(post));
				break;

			}
			loop(i+1, fin, indice);
		});
    
    }
}


// HTML del post
function getPost(post){

	var plantilla = jQuery("#plantilla").val();

	var html = '';

	var titulo = post['titulo'];
	var descripcion = post['descripcion'];
	var fecha = new Date(post['fecha'].substring(0, 10));
	var urlImagen = post['urlImagen'];
	var urlPublicacion = post['urlPublicacion'];
	var cita = post['cita'];
	var video = post['video'];
	var pdf = post['pdf'];

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

	switch(plantilla) {
		
		case 'plantilla_1':
			numero = jQuery('section.latests-posts .card-container div:first').children().length;
			html = '<div class="' + numero + ' main-card-container col-xs-12  col-lg-4  col-sm-6 col-md-6  noppading"><section class="container-fluid main-card"><header class="row header-container"><div class="image-container col-xs-12"><a href="' + urlPublicacion + '" class="link-header-layer visible-xs"><img src="' + urlImagen + '" alt="" /></a><img src="' + urlImagen + '" alt="" class="hidden-xs" /></div><div class="hidden-xs floating-text col-xs-9"><p class="date">' + fecha + '</p><h1>' + titulo + '</h1></div></header><div class="row data-container"><a href="' + urlPublicacion + '" class="link-layer visible-xs">&nbsp;</a><div class="nopadding date">' + fecha + '</div><div class="main-card-data-container-title-wrapper"><h1 class="title nopadding"> ' + titulo + ' </h1></div><p class="main-card-data-container-description-wrapper">' + descripcion +'</p><a href="' + urlPublicacion + '" class="hidden-xs mb-xs readmore">' + object_name_cards.leer_mas +'</a><footer>';
		    if (false)  {
		        html += '<div class="card-icon"><span class="icon bbva-icon-quote2"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div>';
		    }
		    if (video == true)  {
		        html += '<div class="card-icon"><span class="icon bbva-icon-audio2"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div>';
		    }
		    if (false)  {
		        html += '<div class="card-icon"><span class="icon bbva-icon-chat2"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div>';
			}
 			html += '</footer></div></section></div>';
			break;
		
		case 'plantilla_2':
			order = ['double', 'double', 'triple', 'triple', 'triple'];
			i = jQuery('.card-container').size();
			grid = order[(i % 5)];
			if (grid == "double") {
				html = '<div class="col-xs-12 col-sm-6 double-card card-container">';
			} else {
				html = '<div class="col-xs-12 col-sm-4 triple-card card-container">';
			}
			html += '<section class="container-fluid main-card"><header class="row header-container"><div class="image-container col-xs-12"><a href="' + urlPublicacion + '" class="link-header-layer visible-xs"><img src="' + urlImagen + '" alt=""></a><img src="' + urlImagen + '" alt="" class="hidden-xs"></div><div class="hidden-xs floating-text col-xs-9"><p class="date">' + fecha + '</p><h1>' + titulo + '</h1></div></header><div class="row data-container"><a href="#" class="link-layer visible-xs">&nbsp;</a><div class="nopadding date">' + fecha + '</div><div class="main-card-data-container-title-wrapper"><h1 class="title nopadding">' + titulo + '</h1></div><p class="main-card-data-container-description-wrapper">' + descripcion + '</p><a href="' + urlPublicacion + '" class="hidden-xs mb-xs readmore">' + object_name_cards.leer_mas + '</a><footer><div class="icon-row">';
		    if (false)  {
		        html += '<div class="card-icon"><span class="icon bbva-icon-quote2"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div>';
		    }
		    if (video == true)  {
		        html += '<div class="card-icon"><span class="icon bbva-icon-audio2"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div>';
		    }
		    if (false)  {
		        html += '<div class="card-icon"><span class="icon bbva-icon-chat2"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div>';
			}
			html += '</div></footer></div></section></div>';
			break;
		
		case 'plantilla_3':
			order = ["main", "secondary", "secondary"];
			i = jQuery('.outstanding-histories .card-container .row').first().children().size();
			grid = order[(i % 3)];
			if (grid == "main") {
				html = '<div class="_main-card col-xs-12 col-sm-6 noppading _main-card">';
			} else if (grid == "secondary") {
				html = '<div class="_main-card col-xs-12 col-sm-6 noppading _secondary-card">';
			}
			html += '<section class="container-fluid main-card"><header class="row header-container"><div class="image-container col-xs-12"><a href="' + urlPublicacion + '" class="link-header-layer visible-xs"><img src="' + urlImagen + '" alt="" /></a><img src="' + urlImagen + '" alt="" class="hidden-xs" /></div><div class="hidden-xs floating-text col-xs-9"><p class="date">27 Agosto 2016</p><h1>' + titulo + '</h1></div></header><div class="row data-container"><a href="' + urlPublicacion + '" class="link-layer visible-xs">&nbsp;</a><div class="nopadding date">27 Agosto 2016</div><div class="main-card-data-container-title-wrapper"><h1 class="title nopadding">' + titulo + '</h1></div><p class="main-card-data-container-description-wrapper">' + descripcion + '</p><a href="' + urlPublicacion + '" class="hidden-xs mb-xs readmore">' + object_name_cards.leer_mas + '</a><footer>';		        	
		    if (false)  {
		        html += '<div class="card-icon"><span class="icon bbva-icon-quote2"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div>';
		    }
		    if (video == true)  {
		        html += '<div class="card-icon"><span class="icon bbva-icon-audio2"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div>';
		    }
		    if (false)  {
		        html += '<div class="card-icon"><span class="icon bbva-icon-chat2"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div>';
			}
			html += '</div></footer></div></section></div>';
			break;

	}

	return html;
}