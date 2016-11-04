jQuery(document).ready(function($) {

	buscando = false;

	jQuery('.btn-group.languages-buttons a').on('click', function($) {
		window.location = jQuery(this).attr('href');
	});


	numero_trabajos_ocultos = jQuery('article#otros_trabajos .content .data-block:hidden').length;
	if (numero_trabajos_ocultos == 0) {
	    jQuery('a#readmore_trabajos').hide();
	}
	numero_trabajos_visibles = jQuery('article#otros_trabajos .content .data-block:visible').length;
	jQuery('#readmore_trabajos').on('click', function(e) {
	    e.preventDefault();
	    numero_trabajos_ocultos = jQuery('article#otros_trabajos .content .data-block:hidden').length;
	    i = 1;
	    jQuery('article#otros_trabajos .content .data-block:hidden').each(function() {
	        jQuery('article#otros_trabajos .content #trabajo_' + numero_trabajos_visibles).show();
	        numero_trabajos_visibles++;
	        if (i == 3) {
	            return false;
	        } else {
	            i++;
	        }
	    });
	    numero_trabajos_ocultos = jQuery('article#otros_trabajos .content .data-block:hidden').length;
	    if (numero_trabajos_ocultos == 0) {
	        jQuery('a#readmore_trabajos').hide();
	    }
	});


	jQuery('#readmore_talleres').on('click', function(e) {
	    e.preventDefault();
		pais = jQuery('.workshops:visible').attr("class").split(' ')[1];
	    numero_talleres_visibles = jQuery('.' + pais +  ' article#otros_talleres .content .data-block:visible').length;
	    numero_talleres_ocultos = jQuery('.' + pais +  ' article#otros_talleres .content .data-block:hidden').length;
	    i = 1;
	    jQuery('.' + pais +  ' article#otros_talleres .content .data-block:hidden').each(function() {
	        jQuery('.' + pais +  ' article#otros_talleres .content #taller_' + numero_talleres_visibles).show();
	        numero_talleres_visibles++;
	        if (i == 6) {
	            return false;
	        } else {
	            i++;
	        }
	    });
	    numero_talleres_ocultos = jQuery('.' + pais +  ' article#otros_talleres .content .data-block:hidden').length;
	    if (numero_talleres_ocultos == 0) {
	        jQuery('#esconder').hide();
	    } else {
	    	jQuery('#esconder').show();
	    }
	});


	jQuery('.navbar button.btn-bbva-aqua.publishing-filter-search-btn, a.btn-bbva-aqua.publishing-filter-search-btn').on("click", function(e) {
		e.preventDefault();
		e.stopPropagation();
		buscar_general(false, false, false);
	}); 


	jQuery('body').on('click', '#publishes footer a.readmore', function(event) {
		event.preventDefault();
		start = parseInt(jQuery("input#startPublicaciones").val()) + 10;
		jQuery("input#startPublicaciones").attr('value', start);
		buscar_general(true, false, false);
	});


	jQuery('body').on('click', '#histories footer a.readmore', function(event) {
		event.preventDefault();
		start = parseInt(jQuery("input#startHistorias").val()) + 10;
		jQuery("input#startHistorias").attr('value', start);
		buscar_general(true, false, false);
	});

	jQuery('body').on('click', '#workshops footer a.readmore', function(event) {
		event.preventDefault();
		start = parseInt(jQuery("input#startTalleres").val()) + 6;
		jQuery("input#startTalleres").attr('value', start);
		buscar_general(true, false, false);
	});

	jQuery('body').on('click', '#publishes .sort-items-container a', function(event) {
		event.preventDefault();
		orden = jQuery(this).attr("data-order-filter");
		jQuery("input#sortByPublicaciones").attr('value', orden);
		jQuery('#publishes .sort-items-container a.selected').removeClass("selected");
		jQuery(this).addClass("selected");
		jQuery("input#startPublicaciones").attr('value', 0);
		buscar_general(false, true, false);
	});

	jQuery('body').on('click', '#histories .sort-items-container a', function(event) {
		event.preventDefault();
		orden = jQuery(this).attr("data-order-filter");
		jQuery("input#sortByHistorias").attr('value', orden);
		jQuery('#histories .sort-items-container a.selected').removeClass("selected");
		jQuery(this).addClass("selected");
		jQuery("input#startHistorias").attr('value', 0);
		buscar_general(false, true, false);
	});

	jQuery('body').on('click', 'ul#results-tabs li a', function() {
		jQuery('#currentTab').attr('value', jQuery(this).attr('class'));
	});

	jQuery('body').on('change', 'select#select-tab-results', function() {
		opcion = jQuery(this).children('option:selected').val();
		jQuery('a.' + opcion).trigger('click');
	});

	jQuery('body').on('change', '#select-country', function() {
		console.log("cambio");
		opcion = jQuery(this).children('option:selected').val();
		jQuery.each(paisesJson, function(index, value) {
			if (value[0] == opcion) {
				jQuery('a.link-web').attr('href', value[2]);
				jQuery('a.link-web .nombre').html('<span class="nombre">' + value[1] + '</span>');
				jQuery('#workshops span.current-country').html(value[0]);
				buscar_general(false, false, true);
				return;
			}
		});
	});
	 
});


function getNumResultados(d, tipo) {
	if (d.code !== 200 || d.data.hits.found == 0)
		return 0;
	else {
		num = 0;
		for (var i = 0; i < d.data.hits.hit.length; i++) {
        	result = d.data.hits.hit[i];
        	if (result.fields.topic == tipo)
        		num++;
        }
        return num;
	}
}


function buscar_general(ver_mas, reordenar, cambiando_talleres) {

	//jQuery('.search-mobile.hidden-sm.hidden-md.hidden-lg').addClass('closed');
	//jQuery('div#search-layer, div#menu-search').hide();

	tags = getSelectedTags_general();
	textoInput = jQuery('input.input-search.navbar-search-input').val();
	if (textoInput == '') {
		textoInput = jQuery('input.publishing-filter-search-input.form-control').val();
	}
	texto = textoInput + ' ' + tags[0].join(' ');
	texto = getCleanedString(texto);

	categorias = tags[1];
	autores = tags[2];
	paises = tags[3];

	if (!ver_mas) {
		jQuery("input#startPublicaciones").attr('value', 0);
		jQuery("input#startHistorias").attr('value', 0);
		jQuery("input#startTalleres").attr('value', 0);
	}

	if (!ver_mas && !reordenar) {
		jQuery('#sortByPublicaciones').attr('value', 'date desc');
		jQuery('#sortByHistorias').attr('value', 'date desc');
		jQuery('#currentTab').attr('value', 'publishes');
	}

	start_publicaciones = jQuery("input#startPublicaciones").val();
	order_publicaciones = jQuery("input#sortByPublicaciones").val();
	size_publicaciones = jQuery("input#sizePublicaciones").val();
		
	start_historias = jQuery("input#startHistorias").val();
	order_historias = jQuery("input#sortByHistorias").val();
	size_historias = jQuery("input#sizeHistorias").val();

	start_talleres = jQuery("input#startTalleres").val();
	order_talleres = jQuery("input#sortByTalleres").val();
	size_talleres = jQuery("input#sizeTalleres").val();
	
	query_paises = "";
	query_autores = "";
	query_categorias = "";
	query_destacados_publicaciones = '';
	query_destacados_historias = '';

	if (!ver_mas && !cambiando_talleres) {
		jQuery('.contents div:nth-child(2)').first().children().children().children().not(jQuery('.prefooter-bbva')).remove();
		codigoBuscador = '<div class="contents">\
							<div id="search-layer"></div>\
								<div class="results">\
									<div class="tabs container">\
										<header class="title-description mt-lg">\
											<h1>' + object_name_script_os_js.resultado_de_busqueda + '</h1>\
											<div class="description-container">\
												<p>' + object_name_script_os_js.se_han_encontrado + ' <span class="num_resultados">0</span> ' + object_name_script_os_js.resultados_que_coinciden_con_la_palabra + ' <strong>Millenials</strong> ' + object_name_script_os_js.y_las_etiquetas + ' <strong>Fintech, Educación financiera</strong></p>\
											</div> \
										</header>\
										<section class="mt-lg results-content-tabs workshops-results">\
											<div class="controls">\
												<select id="select-tab-results" class="selectpicker-form visible-xs">\
													<option value="publishes">' + object_name_script_os_js.publicaciones + ' (0)</option>\
													<option value="histories">' + object_name_script_os_js.historias + ' (0)</option>\
													<option value="workshops">' + object_name_script_os_js.talleres + ' (0)</option>\
												</select>\
												<ul id="results-tabs" class="nav nav-tabs" role="tablist">\
													<li class="hidden-xs active">\
														<a class="publishes" href="#publishes" aria-controls="publishes" role="tab" data-toggle="tab">' + object_name_script_os_js.publicaciones + ' (0)</a>\
													</li>\
														<li class="hidden-xs">\
															<a class="histories" href="#histories" aria-controls="histories" role="tab" data-toggle="tab">' + object_name_script_os_js.historias + ' (0)</a>\
														</li>\
														<li class="hidden-xs">\
															<a class="workshops" href="#workshops" aria-controls="workshops" role="tab" data-toggle="tab">' + object_name_script_os_js.talleres + ' (0)</a>\
													</li>\
												</ul>\
											</div>\
											<div class="tab-content">\
												<div role="tabpanel" class="tab-pane active" id="publishes">\
													<section class="publishes-wrapper">\
														<div class="sort-items-container">\
															<a data-order-filter="date desc" data-order="DESC" href="#" class="">\
																<span class="icon bbva-icon-arrow arrowUp"></span>\
																<span class="text">' + object_name_script_os_js.mas_recientes + '</span>\
															</a>\
															<a data-order-filter="date asc" data-order="ASC" href="#" class="">\
																<span class="icon bbva-icon-arrow arrowDown"></span>\
																<span class="text">' + object_name_script_os_js.mas_antiguos + '</span>\
															</a>\
															<a data-order-filter="destacados" data-order="DESTACADOS" href="#" class="">\
																<span class="icon bbva-icon-view extra-space "></span>\
																<span class="text">' + object_name_script_os_js.mas_leidos + '</span>\
															</a>\
														</div>\
														<article class="cards-grid">\
															<section class="container">\
																<div class="row"></div>\
																<footer class="grid-footer">\
																	<div class="row">\
																		<div class="col-md-12 text-center">\
																			<a href="#" class="readmore">\
																				<span class="bbva-icon-more font-xs mr-xs"></span>\
																				' + object_name_script_os_js.ver_mas_publicaciones + '\
																			</a>\
																		</div>\
																	</div>\
																</footer>\
															</section>\
														</article>\
													</section>\
												</div>\
											<div role="tabpanel" class="tab-pane" id="histories">\
												<section class="histories-wrapper">\
													<div class="sort-items-container">\
															<a data-order-filter="date desc" data-order="DESC" href="#" class="">\
																<span class="icon bbva-icon-arrow arrowUp"></span>\
																<span class="text">' + object_name_script_os_js.mas_recientes + '</span>\
															</a>\
															<a data-order-filter="date asc" data-order="ASC" href="#" class="">\
																<span class="icon bbva-icon-arrow arrowDown"></span>\
																<span class="text">' + object_name_script_os_js.mas_antiguos + '</span>\
															</a>\
															<a data-order-filter="destacados" data-order="DESTACADOS" href="#" class="">\
																<span class="icon bbva-icon-view extra-space "></span>\
																<span class="text">' + object_name_script_os_js.mas_leidos + '</span>\
															</a>\
													</div>\
													<article class="cards-grid">\
														<section class="container">\
															<div class="row"></div>\
															<footer class="grid-footer">\
																<div class="row">\
																	<div class="col-md-12 text-center">\
																		<a href="#" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span>' + object_name_script_os_js.ver_mas_historias + '</a>\
																	</div>\
																</div>\
															</footer>\
														</section>\
													</article>\
												</section>\
											</div>\
												<div role="tabpanel" class="tab-pane" id="workshops">\
													<section class="workshops-wrapper">\
														<div class="workshops-results container removePadding">\
															<div class="controls">\
																<select id="select-country" class="selectpicker-form countries">';
																if (paises.length == 0){
																	jQuery.each(paisesJson, function( index, value ) {
																	  selected = '';
																	  if (value[0] == 'Mexico' || value[0] == 'México') {
																	  	selected = 'selected';
																	  }
																	  codigoBuscador += '<option value="' + value[0] + '" ' + selected + '>' + value[0] + '</option>';
																	});
																} else {
																	jQuery.each(paises, function( index1, value1 ) {
																		jQuery.each(data.availableTags, function( index2, value2 ) {
																			id = value2['id'].replace('tag-', '');
																			selected = '';
																			if (index2 == 0) {
																				selected = 'selected';
																			}
																			if (id == value1) {
																				codigoBuscador += '<option ' + selected + ' value="' + value2['text'] + '">' + value2['text'] + '</option>';
																			}	
																		});
																	});
																}
															codigoBuscador += '</select>';
															if (paises.length == 0) {
																jQuery.each(paisesJson, function( index, value ) {
																	if (value[0] == 'Mexico' || value[0] == 'México') {
																		codigoBuscador += '<a target="_blank" href="' + value[2] + '" class="link-web"><span class="nombre">' + value[1] + '</span><span class="icon bbva-icon-link_external font-xs mr-xs"></span></a>';
																	  	return;
																	}
																});
															} else {
																codigoBuscador += '<a target="_blank" href="' + paisesJson[paises[0]][2] + '" class="link-web"><span class="nombre">' + paisesJson[paises[0]][1] + '</span><span class="icon bbva-icon-link_external font-xs mr-xs"></span></a>';

															}
															codigoBuscador += '</div>\
														</div>\
													<article class="container data-grid">\
														<header>\
															<h1>' + object_name_script_os_js.talleres + ' ' + object_name_script_os_js.de + ' <span class="current-country">';
															if (paises.length == 0) {
																jQuery.each(paisesJson, function( index, value ) {
																  if (value[0] == 'Mexico' || value[0] == 'México') {
																  	codigoBuscador += value[0];
																  	return;
																  }
																});
															} else {
																codigoBuscador +=  paisesJson[paises[0]][0];
															}
													codigoBuscador += '</span></h1>\
														</header>\
														<div class="content">\
															<div class="grid-wrapper"></div>\
														</div>\
														<footer class="grid-footer">\
															<div class="row">\
																<div class="col-md-12 text-center">\
																	<a href="#" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span> ' + object_name_script_os_js.ver_mas_talleres + '</a>\
																</div>\
															</div>\
														</footer>\
													</article>\
												</section>\
											</div>\
										</div>\
									</section>\
								</div>\
							</div>\
							</div>';
		jQuery('.prefooter-bbva').before(codigoBuscador);
		jQuery('.prefooter-bbva').removeClass('background-gray');
		jQuery('select#select-country').selectpicker('refresh');

	} else if (!cambiando_talleres) {
		jQuery('#sortByPublicaciones').attr('value', 'date desc');
		jQuery('#sortByHistorias').attr('value', 'date desc')
	} else {
		jQuery('#startTalleres').attr('value', 0);
	}

	filter = false;
	if (paises.length > 0){
		filter = true;
		query_paises = "(or wp_double_array:" + paises.join(" wp_double_array:") + ")";
		//query_paises_talleres = "(or wp_double_array:'" +  paises[0] + "')";
		pais = jQuery('#select-country option:selected').text();
		query_paises_talleres = "";
		jQuery.each(data.availableTags, function(index, value) {
			if (value['text'] == pais) {
				id = value['id'].replace('tag-', '');
				query_paises_talleres = "(or wp_double_array:'" + id + "')";
				return;
			}
		});
	} else {
		query_paises_talleres = '';
		jQuery.each(data.availableTags, function( index, value ) {
			selected = '';
			if (value['text'] == 'Mexico' || value['text'] == 'México') {
				id = value['id'].replace('tag-', '');
				query_paises_talleres = "(or wp_double_array:'" + id + "')";
				return;
			}
		});
	}
	if (autores.length > 0){
		filter = true;
		query_autores = "(or wp_text_array:'" + autores.join("' wp_text_array:'") + "')";
	}
	if (categorias.length > 0){
		filter = true;
		query_categorias = "(or wp_double_array:" + categorias.join(" wp_double_array:") + ")";	
	}
	if (order_publicaciones == 'destacados') {
		order_publicaciones = 'date desc';
		query_destacados_publicaciones += '(or keywords:\'destacada\')';
	}
	if (order_historias == 'destacados') {
		order_historias = 'date desc';
		query_destacados_historias += '(or keywords:\'destacada\')';
	}

	var url_buscador = 'http://d1xkg658gp8s5n.cloudfront.net/bbva-components/search?&q.parser=lucene&q=*' + texto + '*&project=is8lyryw';
	if (filter) {
		url_buscador_publicaciones = url_buscador + '&fq=(and' + query_categorias + query_autores + query_paises + query_destacados_publicaciones + '(or topic:\'publicacion\')(or content_language:\'' + object_name_script_os_js.lang + '\'))';
		url_buscador_historias = url_buscador + '&fq=(and' + query_categorias + query_autores + query_paises + query_destacados_historias + '(or topic:\'historia\')(or content_language:\'' + object_name_script_os_js.lang + '\'))';
		url_buscador_talleres = url_buscador + '&fq=(and' + query_categorias + query_autores + query_paises_talleres + '(or topic:\'taller\')(or content_language:\'' + object_name_script_os_js.lang + '\'))';
	} else {
		url_buscador_publicaciones = url_buscador + '&fq=(and(or topic:\'publicacion\')(or content_language:\'' + object_name_script_os_js.lang + '\')' + query_destacados_publicaciones + ')';
		url_buscador_historias = url_buscador + '&fq=(and(or topic:\'historia\')(or content_language:\'' + object_name_script_os_js.lang + '\')' + query_destacados_historias + ')';
		url_buscador_talleres = url_buscador + '&fq=(and(or topic:\'taller\')(or content_language:\'' + object_name_script_os_js.lang + '\')' + query_paises_talleres + ')';
	}
	url_buscador_publicaciones += '&start=' + start_publicaciones + '&sort=' + order_publicaciones + '&size=' + size_publicaciones;
	url_buscador_historias += '&start=' + start_historias + '&sort=' + order_historias + '&size=' + size_historias;
	url_buscador_talleres += '&start=' + start_talleres + '&sort=' + order_talleres + '&size=' + size_talleres;


	ordenacion = jQuery('#sortByPublicaciones').val();
	jQuery('#publishes .sort-items-container a[data-order-filter="' + ordenacion + '"]').addClass('selected');

	ordenacion = jQuery('#sortByHistorias').val();
	jQuery('#histories .sort-items-container a[data-order-filter="' + ordenacion + '"]').addClass('selected');

	if (!cambiando_talleres && !ver_mas) {
		tab = jQuery('#currentTab').val();
		jQuery('ul#results-tabs li').removeClass('active');
		jQuery('a.' + tab).trigger('click');
		jQuery('span.num_resultados').html('0');
	} else {
		jQuery('span.num_resultados').html('0');
	}


	//publicaciones
	jQuery.get(url_buscador_publicaciones, function(d) {
		if (d.code === 200 && d.data.hits.found > 0) {
			if (!cambiando_talleres || !ver_mas) {
				jQuery('#publishes a[data-order-filter="destacados"]').hide();
				if (start_publicaciones == 0) {
					jQuery('#publishes .cards-grid .container div.row').first().empty();
				}
				jQuery.each(d.data.hits.hit, function(i, result) {
					jQuery('a.publishes').html(object_name_script_os_js.publicaciones + ' (' + d.data.hits.found + ')');
					jQuery('select#select-tab-results option[value="publishes"]').html(object_name_script_os_js.publicaciones + ' (' + d.data.hits.found + ')');
					keywords = result.fields['keywords'];
					if (keywords !== undefined) {
						if (jQuery.inArray('destacada', keywords) > -1 ) {
						    jQuery('#publishes a[data-order-filter="destacados"]').show();
						}
					}
					jQuery('#publishes .cards-grid .container div.row').first().append(getPostFiltro_general(result.fields, 'publishes'));
				});
		        if (d.data.hits.found == jQuery('#publishes .cards-grid .container div.row').first().children().size()) {
		        	jQuery('#publishes footer a.readmore').hide();
		        }
	    	}
	        num_resultados = parseInt(jQuery('span.num_resultados').html()) + d.data.hits.found; 
	        jQuery('span.num_resultados').html(num_resultados);
		} else {
			jQuery('#publishes footer a.readmore').hide();
			jQuery('#publishes .sort-items-container').children('a').hide();
		}
	});


	//historias
	jQuery.get(url_buscador_historias, function(d) {
		if (d.code === 200 && d.data.hits.found > 0) {
			if (!cambiando_talleres || !ver_mas) {
			jQuery('#histories a[data-order-filter="destacados"]').hide();
			if (start_publicaciones == 0) {
				jQuery('#histories .cards-grid .container div.row').first().empty();
			}
				jQuery.each(d.data.hits.hit, function(i, result) {
					jQuery('a.histories').html(object_name_script_os_js.historias + ' (' + d.data.hits.found + ')');
					jQuery('select#select-tab-results option[value="histories"]').html(object_name_script_os_js.historias + ' (' + d.data.hits.found + ')');
					keywords = result.fields['keywords'];
					if (keywords !== undefined) {
						if (jQuery.inArray('destacada', keywords) > -1 ) {
						    jQuery('#histories a[data-order-filter="destacados"]').show();
						}
					}
					jQuery('#histories .cards-grid .container div.row').first().append(getPostFiltro_general(result.fields, 'histories'));
				});
		        if (d.data.hits.found == jQuery('#histories .cards-grid .container div.row').first().children().size()) {
		        	jQuery('#histories footer a.readmore').hide();
		        }
		    }
	        num_resultados = parseInt(jQuery('span.num_resultados').html()) + d.data.hits.found; 
	        jQuery('span.num_resultados').html(num_resultados);
		} else {
			jQuery('#histories footer a.readmore').hide();
			jQuery('#histories .sort-items-container').children('a').hide();
		}
	});



	//talleres
	jQuery.get(url_buscador_talleres, function(d) {
		if (d.code === 200 && d.data.hits.found > 0) {
			jQuery('a.workshops').html(object_name_script_os_js.talleres + ' (' + d.data.hits.found + ')');
			jQuery('select#select-tab-results option[value="workshops"]').html(object_name_script_os_js.talleres + ' (' + d.data.hits.found + ')');
			if (cambiando_talleres) {
				jQuery('#workshops .grid-wrapper').first().empty();
			}
			jQuery.each(d.data.hits.hit, function(i, result) {
				jQuery('#workshops .grid-wrapper').first().append(getPostFiltro_general(result.fields, 'workshops'));
			});
	        if (d.data.hits.found == jQuery('#workshops .grid-wrapper').first().children().size()) {
	        	jQuery('#workshops footer a.readmore').hide();
	        } else {
	        	jQuery('#workshops footer a.readmore').show();
	        }
	       	num_resultados = parseInt(jQuery('span.num_resultados').html()) + d.data.hits.found; 
	        jQuery('span.num_resultados').html(num_resultados);
		} else {
			jQuery('#workshops footer a.readmore').hide();
			//jQuery('#workshops article.container.data-grid').hide();
			//jQuery('#workshops .sort-items-container').children('a').hide();
			//jQuery('#workshops article.container.data-grid').hide();
			//jQuery('#workshops .btn-group.bootstrap-select.-form.countries').hide();
			//jQuery('#workshops a.link-web').hide();
			num_resultados = parseInt(jQuery('span.num_resultados').html()) + 0; 
	        jQuery('span.num_resultados').html(num_resultados);
			jQuery('#workshops .grid-wrapper').first().empty();
		}
	});


}


function getSelectedTags_general() {
	texto = [];
	categorias = [];
	autores = [];
	paises = [];
	targetContainer = jQuery('.navbar .selected-tags-container');
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
	targetContainer = jQuery('#mobile-filter .selected-tags-container');
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


function getCleanedString(cadena) {

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


function getPostFiltro_general(post, id) {

	var html = '';

	var tipo = post['topic'];

	if (tipo == 'taller') {

		var titulo = post['title'];
		var descripcion = post['content'];
		var urlPublicacion = post['image_src'];
		var nombreLink = post['wp_text_array'];

		html += '<section class="data-block"><h2>' + titulo + '</h2><p class="description">' + descripcion + '</p><p class="link"><a target="blank" href="' + urlPublicacion + '">' + nombreLink + '<span class="icon bbva-icon-link_external font-xs mr-xs"></span></a></p></section>';

	} else {

		var titulo = post['title'];
		var descripcion = post['content'];
		var fecha = '';
		if (post['date'] !== undefined) {
			fecha = new Date(post['date'].substring(0, 10));
		}
		var urlImagen = post['image_src'];
		var urlPublicacion = post['resourcename'];
		
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
			object_name_script_os_js.enero, 
			object_name_script_os_js.febrero,
			object_name_script_os_js.marzo,
			object_name_script_os_js.abril,
			object_name_script_os_js.mayo,
			object_name_script_os_js.junio,
			object_name_script_os_js.julio,
			object_name_script_os_js.agosto,
			object_name_script_os_js.septiembre,
			object_name_script_os_js.octubre,
			object_name_script_os_js.noviembre,
			object_name_script_os_js.diciembre,
		];

		if (fecha !== '') {
			fecha = fecha.getDate() + ' ' +  meses[fecha.getMonth()] + ' ' + fecha.getFullYear();
			fecha = fecha.toString();
			fecha = fecha.toUpperCase();
		}


		order = ['double', 'double', 'triple', 'triple', 'triple'];
		i = jQuery('#' + id + ' .card-container').size();
		grid = order[(i % 5)];
		if (grid == "double") {
			html = '<div class="col-xs-12 col-sm-6 double-card card-container">';
		} else {
			html = '<div class="col-xs-12 col-sm-4 triple-card card-container">';
		}
		html += '<section class="container-fluid main-card"><header class="row header-container"><div class="image-container col-xs-12"><a href="' + urlPublicacion + '" class="link-header-layer visible-xs"><img src="' + urlImagen + '" alt=""></a><img src="' + urlImagen + '" alt="" class="hidden-xs"></div><div class="hidden-xs floating-text col-xs-9"><p class="date">' + fecha + '</p><h1>' + titulo + '</h1></div></header><div class="row data-container"><a href="#" class="link-layer visible-xs">&nbsp;</a><div class="nopadding date">' + fecha + '</div><div class="main-card-data-container-title-wrapper"><h1 class="title nopadding">' + titulo + '</h1></div><p class="main-card-data-container-description-wrapper">' + descripcion + '</p><a href="' + urlPublicacion + '" class="hidden-xs mb-xs readmore">' + object_name_script_os_js.leer_mas + '</a><footer><div class="icon-row">';
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

	}

	return html;
}