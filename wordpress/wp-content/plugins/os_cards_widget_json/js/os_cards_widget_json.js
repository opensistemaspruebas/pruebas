// Ver mas publicaciones
jQuery(document).on("click", "#readmore", function(event) {
	event.preventDefault();
	var tipo = jQuery("#tipo").val();
	var orden = jQuery("#orden").val();
	var path = "/wp-content/jsons/" + tipo + "/";
	jQuery.getJSON(path + orden + ".json", getIndice);
});


// Cambiar el orden
jQuery(document).on("click", '.sort-items-container a', function(event) {
	event.preventDefault();
	var tipo = jQuery("#tipo").val();
	var orden = jQuery(this).attr("data-order");
	jQuery("#orden").val(orden);
	var path = "/wp-content/jsons/" + tipo + "/";
	jQuery('.cards-grid .container div.row').first().html('');
	jQuery('#card-container').html('');
	jQuery('.outstanding-histories .card-container .row').first().html('');
	jQuery("#npc").val(0);
	jQuery.getJSON(path + orden + ".json", getIndice);
	jQuery('.sort-items-container a.selected').removeClass("selected");
	jQuery(this).addClass("selected");
});


// Obtener indice
function getIndice(indice) {
	var npv = parseInt(jQuery("#npv").val());
	var npt = parseInt(jQuery("#npt").val());
	var npc = parseInt(jQuery("#npc").val());
	if (npc == 0) {
		for (var i = npc; i < npc + npt; i++) {
			//console.log(indice[i]);
			if (indice[i] == undefined) {
				// Si el indice no existe, se oculta el boton de mostrar mas y se sale del bucle
				jQuery('a#readmore').hide();
				break;
			}
			jQuery('a#readmore').show();
			crearPost(indice[i]);
		}
		npc += npt;
	} else {
		for (var i = npc; i < npc + npv; i++) {
			//console.log(indice[i]);
			if (indice[i] == undefined) {
				// Si el indice no existe, se oculta el boton de mostrar mas y se sale del bucle
				jQuery('a#readmore').hide();
				break;
			}
			jQuery('a#readmore').show();
			crearPost(indice[i]);
		}
		npc += npv;
	}
	jQuery("#npc").val(npc);
	if (indice.length <= npc) {
		jQuery('a#readmore').hide();
	}
}


// Crear post
function crearPost(indice){
	var tipo = jQuery("#tipo").val();
	var orden = jQuery("#orden").val();
	var path = "/wp-content/jsons/" + tipo + "/";
	jQuery.getJSON(path + indice + ".json", montarPost);
}


// Montar post
function montarPost(post){
	//console.log(post);
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
			html = '<div class="' + numero + ' main-card-container col-xs-12  col-lg-4  col-sm-6 col-md-6  noppading"><section class="container-fluid main-card"><header class="row header-container"><div class="image-container col-xs-12"><img src="' + urlImagen + '" alt="" /></div><div class="hidden-xs floating-text col-xs-9"><p class="date">"' + fecha + '"</p><h1>"' + titulo + '"</h1></div></header><div class="row data-container"><p class="nopadding col-xs-9 date">"' + fecha + '"</p><h1 class="title nopadding col-xs-9">"' + titulo + '"</h1><p><?php echo $post_abstract; ?></p><a href="<?php echo $post_guid; ?>" class="hidden-xs readmore">"' + object_name_cards.leer_mas + '"</a><footer class="row">';             	
		    if (cita == true)  {
		        html += '<div class="col-xs-2 col-lg-1"><div class="card-icon"><span class="icon bbva-icon-quote"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div></div>';
		    }
		    if (video == true)  {
		        html += '<div class="col-xs-2 col-lg-1"><div class="card-icon"><span class="icon bbva-icon-audio"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div></div>';
		    }
		    if (pdf == true)  {
		        html += '<div class="col-xs-2 col-lg-1"><div class="card-icon"><span class="icon bbva-icon-comments"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div></div>';
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
			html += '<section class="container-fluid main-card"><header class="row header-container"><div class="image-container nopadding col-xs-12"><img src="' + urlImagen + '" alt=""></div><div class="hidden-xs floating-text col-xs-9"><p class="date">' + fecha + '</p><h1>' + titulo + '</h1></div></header><div class="row data-container"><p class="nopadding col-xs-9 date">' + fecha + '</p><h1 class="title nopadding col-xs-9">' + titulo + '</h1><p>' + descripcion + '</p><a href="' + urlPublicacion  + '" class="hidden-xs readmore">' + object_name_cards.leer_mas + '</a><footer class="row">';		        	
		    if (cita == true)  {
		        html += '<div class="col-xs-2 col-lg-1"><div class="card-icon"><span class="icon bbva-icon-quote"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div></div>';
		    }
		    if (video == true)  {
		        html += '<div class="col-xs-2 col-lg-1"><div class="card-icon"><span class="icon bbva-icon-audio"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div></div>';
		    }
		    if (pdf == true)  {
		        html += '<div class="col-xs-2 col-lg-1"><div class="card-icon"><span class="icon bbva-icon-comments"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div></div>';
			}
			html += '</footer></div></section></div>';
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
			html += '<section class="container-fluid main-card"><header class="row header-container"><div class="image-container nopadding col-xs-12"><img class="img-responsive" src="' + urlImagen + '" alt=""></div><div class="hidden-xs floating-text col-xs-9"><p class="date">' + fecha + '</p><h1>' + titulo + '</h1></div></header><div class="row data-container"><p class="nopadding col-xs-9 date">' + fecha + '</p><h1 class="title nopadding col-xs-9">' + titulo + '</h1><p>' + descripcion + '</p><a href="' + urlPublicacion  + '" class="hidden-xs readmore">' + object_name_cards.leer_mas + '</a><footer class="row">';		        	
		    if (cita == true)  {
		        html += '<div class="col-xs-2 col-lg-1"><div class="card-icon"><span class="icon bbva-icon-quote"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div></div>';
		    }
		    if (video == true)  {
		        html += '<div class="col-xs-2 col-lg-1"><div class="card-icon"><span class="icon bbva-icon-audio"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div></div>';
		    }
		    if (pdf == true)  {
		        html += '<div class="col-xs-2 col-lg-1"><div class="card-icon"><span class="icon bbva-icon-comments"></span><div class="triangle triangle-up-left"></div><div class="triangle triangle-down-right"></div></div></div>';
			}
			html += '</footer></div></section></div>';
			break;

	}

	return html;
}