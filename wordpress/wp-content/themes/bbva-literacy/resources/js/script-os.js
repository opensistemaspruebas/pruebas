jQuery(document).ready(function($) {

	buscando = false;


	jQuery('.btn-group.languages-buttons a').on('click', function($) {
		window.location = jQuery(this).attr('href');
	});


	numero_trabajos_ocultos = jQuery('article#otros_trabajos .content .data-block:hidden').length;
	if (numero_trabajos_ocultos == 0) {
	    jQuery('a#readmore_trabajos').remove();
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
	        jQuery('a#readmore_trabajos').remove();
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

	jQuery('.navbar button.btn-bbva-aqua.publishing-filter-search-btn').on("click", function(e) {
		
		e.preventDefault();
		e.stopPropagation();
		
		console.log("hago click en buscar");

		buscar_general();
	
	}); 

	jQuery('#publishes a.readmore').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();

		start = parseInt(jQuery("input#start").val()) + 10;
		
		$("input#start").attr('value', start);
		
		buscar();		
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


function buscar_general() {
	tags = getSelectedTags_general();
	textoInput = jQuery('.navbar .search input.publishing-filter-search-input').val();
	texto = textoInput + ' ' + tags[0].join(' ');
	texto = getCleanedString(texto);


	if (tags[0].length == 0 && tags[1].length == 0 && tags[2].length == 0 && tags[3].length == 0 && texto.length == 0) {
		jQuery('a[data-order=DESTACADOS]').show();
	}


	categorias = tags[1];
	autores = tags[2];
	paises = tags[3];

	/*start = jQuery("input#start").val();
	order = jQuery("input#sortBy").val();
	if (order == 'destacados') {
		jQuery('a[data-order=DESTACADOS]').removeClass('selected');
		jQuery('a[data-order=DESC]').addClass('selected');
		order = 'date desc';
		tipo = 'publicacion';
	} else {
		tipo = 'publicacion';
	}*/

	start = 0;
	order = 'date desc';
	tipo = 'publicacion';
	
	query_paises = "";
	query_autores = "";
	query_categorias = "";

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
	    url_buscador += '&fq=(and' + query_categorias + query_autores + query_paises + '(or topic:\'publicacion\' topic:\'historia\' topic:\'taller\')(or content_language:\'' + object_name_script_os_js.lang + '\'))';
	} else {
		url_buscador += '&fq=(and(or topic:\'' + tipo + '\')(or content_language:\'' + object_name_script_os_js.lang + '\'))';
	}
	url_buscador += '&start=' + start + '&sort=' + order;

	var d = {"code":200,"data":{"status":{"rid":"0tfT1IErxC0KYA2p","time-ms":15},"hits":{"found":64,"start":0,"hit":[{"id":"is8lyrywtaller/taller-1-paraguay-lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-vestibulum-ullamcorper-eleifend-","fields":{"project":"is8lyryw","title":"Taller 1 Paraguay: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ullamcorper eleifend mi, vel varius nisi suscipit quis. Curabitur condimentum, ante vel cursus lacinia, augue sem volutpat eros, non vehicula nunc libero sed urna. Duis iaculis ligula sed odio convallis mattis. Suspendisse potenti. Nulla euismod turpis ut orci lacinia viverra id at lectus. Vestibulum dictum vehicula mi a scelerisque. Sed interdum sollicitudin lorem quis finibus. Phasellus tristique aliquam diam non tincidunt. Donec et iaculis sem, eu faucibus tortor. Mauris porta eu libero quis tristique.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ullamcorper eleifend mi, vel varius nisi suscipit quis. Curabitur condimentum, ante vel cursus lacinia, augue sem volutpat eros, non vehicula nunc libero sed urna. Duis iaculis ligula sed odio convallis mattis. Suspendisse potenti. Nulla euismod turpis ut orci lacinia viverra id at lectus. Vestibulum dictum vehicula mi a scelerisque. Sed interdum sollicitudin lorem quis finibus. Phasellus tristique aliquam diam non tincidunt. Donec et iaculis sem, eu faucibus tortor. Mauris porta eu libero quis tristique.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ullamcorper eleifend mi, vel varius nisi suscipit quis. Curabitur condimentum, ante vel cursus lacinia, augue sem volutpat eros, non vehicula nunc libero sed urna. Duis iaculis ligula sed odio convallis mattis. Suspendisse potenti. Nulla euismod turpis ut orci lacinia viverra id at lectus. Vestibulum dictum vehicula mi a scelerisque. Sed interdum sollicitudin lorem quis finibus. Phasellus tristique aliquam diam non tincidunt. Donec et iaculis sem, eu faucibus tortor. Mauris porta eu libero quis tristique.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ullamcorper eleifend mi, vel varius nisi suscipit quis. Curabitur condimentum, ante vel cursus lacinia, augue sem volutpat eros, non vehicula nunc libero sed urna. Duis iaculis ligula sed odio convallis mattis. Suspendisse potenti. Nulla euismod turpis ut orci lacinia viverra id at lectus. Vestibulum dictum vehicula mi a scelerisque. Sed interdum sollicitudin lorem quis finibus. Phasellus tristique aliquam diam non tincidunt. Donec et iaculis sem, eu faucibus tortor. Mauris porta eu libero quis tristique.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ullamcorper eleifend mi, vel varius nisi suscipit quis. Curabitur condimentum, ante vel cursus lacinia, augue sem volutpat eros, non vehicula nunc libero sed urna. Duis iaculis ligula sed odio convallis mattis. Suspendisse potenti. Nulla euismod turpis ut orci lacinia viverra id at lectus. Vestibulum dictum vehicula mi a scelerisque. Sed interdum sollicitudin lorem quis finibus. Phasellus tristique aliquam diam non tincidunt. Donec et iaculis sem, eu faucibus tortor. Mauris porta eu libero quis tristique.","image_src":"https://www.google.es/","content":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tellus metus, iaculis pretium nisl et, pulvinar lobortis tortor. Ut gravida ipsum quam, quis ornare diam facilisis et.","topic":"taller","content_language":"es-ES","date":"2016-10-31T17:00:00Z","resourcename":"taller/taller-1-paraguay-lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-vestibulum-ullamcorper-eleifend-mi-vel-varius-nisi-suscipit-quis-curabitur-condimentum-ante-vel-cursus-lacinia-augue-sem/index.html","wp_double_array":["107.0"],"wp_text_array":["Probando nombre enlace"]}},{"id":"is8lyrywtaller/taller-1-chile/index.html","fields":{"project":"is8lyryw","title":"Taller 1 Chile","image_src":"https://www.google.es/","content":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tellus metus, iaculis pretium nisl et, pulvinar lobortis tortor. Ut gravida ipsum quam, quis ornare diam facilisis et.","topic":"taller","content_language":"es-ES","date":"2016-10-31T17:00:00Z","resourcename":"taller/taller-1-chile/index.html","wp_double_array":["101.0"],"wp_text_array":["Probando nombre enlace"]}},{"id":"is8lyrywpublicacion/in-laoreet-accumsan-nibh-sit-amet-euismod-urna-rhoncus-sed/index.html","fields":{"project":"is8lyryw","title":"Pdf 2016-10-30 d","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/informe3.png","content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.","topic":"publicacion","content_language":"es-ES","date":"2016-10-30T17:00:00Z","resourcename":"publicacion/in-laoreet-accumsan-nibh-sit-amet-euismod-urna-rhoncus-sed/index.html","wp_double_array":["18.0","19.0","30.0"],"wp_text_array":["marta oliver","katie morell"]}},{"id":"is8lyrywen/publicacion/in-laoreet-accumsan-nibh-sit-amet-euismod-urna-rhoncus-sed/index.html","fields":{"project":"is8lyryw","title":"Pdf 2016-10-30 d","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/informe3.png","content":"Vestibulum ipsum magna, lacinia eget lectus ac, vulputate porta lorem. Pellentesque dui velit, aliquam sed varius sit amet, sollicitudin id sapien. Donec et mauris non orci hendrerit consectetur. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras finibus imperdiet felis. Phasellus nec euismod nisl. Aliquam eu sem in lacus eleifend laoreet a sit amet nisl. Ut consequat cursus lorem eget rutrum. Suspendisse non purus nisi. Sed a quam iaculis, interdum neque in, auctor enim. Sed in rhoncus lectus. Curabitur pulvinar ac justo a accumsan. Donec vehicula enim sit amet turpis cursus faucibus. Pellentesque at pellentesque magna. Nullam venenatis congue ligula non convallis. Donec mollis iaculis auctor. Proin ut egestas dui. Curabitur eget pretium eros. In lacinia volutpat tortor tempus mollis. Maecenas ac consectetur sapien.","topic":"publicacion","content_language":"es-ES","date":"2016-10-30T17:00:00Z","resourcename":"en/publicacion/in-laoreet-accumsan-nibh-sit-amet-euismod-urna-rhoncus-sed/index.html","wp_double_array":["18.0","19.0","30.0"],"wp_text_array":["marta oliver","katie morell"]}},{"id":"is8lyrywpublicacion/plan-de-educacion-financiera-de-la-cnmv-y-el-banco-de-espana/index.html","fields":{"project":"is8lyryw","title":"Plan de Educación Financiera de la CNMV y el Banco de España","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/annual-summit-2014.png","content":"La CNMV y el Banco de España han presentado un Plan de Educación Financiera La CNMV y el Banco de España han presentado un Plan de Educación Financiera con el objetivo de contribuir a la mejora de la cultura financiera de los ciudadanos, dotándoles de herramientas, habilidades y conocimientos para adoptar decisiones financieras informadas y apropiadas. Con fecha 4 de junio de 2013 la CNMV y el Banco de España renovaron el Plan de Educación Financiera que ambos organismos pusieron en marcha en 2008 y por la que extienden sus actividades hasta 2017.","topic":"publicacion","content_language":"es-ES","date":"2016-10-28T17:00:00Z","resourcename":"publicacion/plan-de-educacion-financiera-de-la-cnmv-y-el-banco-de-espana/index.html","wp_double_array":["125.0","107.0"],"wp_text_array":["xe62139","perfil de maximos"]}},{"id":"is8lyrywpublicacion/que-dicen-los-analistas-de-los-resultados-3t16-de-bbva/index.html","fields":{"project":"is8lyryw","title":"¿Qué dicen los analistas de los resultados 3T16 de BBVA?","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/Captura-de-pantalla-2016-10-27-a-las-14.55.43.png","content":"Los analistas de mercado han valorado de forma positiva los resultados presentados por BBVA que, en muchos casos, han superado sus estimaciones previas. En sus informes han destacado, principalmente, la fortaleza de los ingresos y la generación de capital que ha permitido al Grupo alcanzar de forma anticipada su objetivo de CET1 fully loaded 11% previsto para 2017. Si se comparan con el consenso de analistas, los resultados presentados han sido mejores de lo esperado en las principales líneas de negocio y en prácticamente Ver más geografías. Ello ha permitido que algunos continúen manteniendo a BBVA como su valor preferido dentro del sector financiero español e, incluso, que se anticipen subidas de estimaciones de resultados. Algún analista describe a BBVA como “una de las historias de crecimiento más atractivas que cubren”. A pesar del buen comportamiento de la acción en las últimas semanas, la mayoría ha anticipado una reacción positiva de la misma tras conocer los resultados. Ésta se ha materializado en una subida del 2,80% en la jornada de presentación de resultados, por encima de comparables españoles y del índice bancario Stoxx Banca que ha ascendido un 1,18%.En el conjunto del Grupo:Sorpresa positiva en capital: la generación de 29 puntos básicos en el trimestre ha batido Ver más expectativas y ha permitido a BBVA alcanzar un ratio CET1 fully loaded del 11% antes de la fecha prevista (2017) incluso asumiendo el impacto de la bajada del rating de Turquía.Buen comportamiento de los ingresos. No obstante, el hecho de que el catalizador principal de este crecimiento hayan sido los resultados por operaciones financieras (ROF), ha rebajado algo la valoración positiva del mercado al tratarse de ingresos menos sostenibles.Se vuelve a destacar la diversificación del Grupo como un factor determinante de la fortaleza de sus resultados.Pese al esfuerzo realizado en control de costes, éstos se mantienen en línea o ligeramente por encima de estimaciones.Por áreas de negocio:En España, valoraciones más positivas que en trimestres anteriores. Se destaca el descenso de saneamientos que permiten mitigar, en parte, la caída de los ingresos recurrentes.En lo que respecta a EE.UU, se ha valorado positivamente el crecimiento del margen de intereses y comisiones. Los saneamientos estuvieron en línea con lo esperado después de las mayores dotaciones realizadas en el primer trimestre del año asociadas a la cartera de petróleo y gas.En Turquía, llama la atención la fortaleza de los ingresos recurrentes (margen de intereses más comisiones) y aún más teniendo en cuenta la debilidad de la lira turca. Peor comportamiento del esperado en costes y provisiones.Las cifras de México están en línea con lo esperado. De cara a final de año, la evolución de los tipos de interés puede tener un impacto positivo en los resultados. También se destaca la resistencia de la cuenta en un entorno de debilidad del peso mexicano.El área de América del Sur registró un resultado algo inferior a lo esperado por los analistas.","topic":"publicacion","content_language":"es-ES","date":"2016-10-28T17:00:00Z","resourcename":"publicacion/que-dicen-los-analistas-de-los-resultados-3t16-de-bbva/index.html","wp_double_array":["38.0","17.0","18.0"],"wp_text_array":["xe41768","katie morell"]}},{"id":"is8lyrywhistoria/las-crisis-financieras-en-espana-1850-2012/index.html","fields":{"project":"is8lyryw","title":"Las Crisis Financieras En España, 1850-2012","content":"La crisis financieras que se sucedieron en Estados Unidos tras el fin de la Guerra Civil tuvieron en 1907 la gota que colmó el vaso. Esto fue lo que condujo a la creación de la Reserva Federal en 1913, en una reunión de los principales banqueros del país. La Reserva Federal recibió el mandato de proporcionar una moneda uniforme y elásticaque diera amplia cabida a los movimientos estacionales, cíclicos y seculares de la economía de Estados Unidos, y también para que sirviera como prestamista de último recurso a los bancos privados. Este es el origen del sistema de la Reserva Federal, el Banco Central de Estados Unidos que este lunes cumple cien años.El Sistema de la Reserva Federal pertenece a la última generación de bancos centrales surgida a comienzos del siglo XX. Este sistema fue creado principalmente para consolidar los distintos sistemas financieros que se estaban empleando para el uso de la moneda y para proporcionar estabilidad financiera al mercado. En sus orígenes, este banco fue creado para gestionar el estándar del oro, tal como lo establecieron la mayoría de los bancos centrales en el siglo XVIII.","topic":"historia","content_language":"es-ES","date":"2016-10-27T17:00:00Z","resourcename":"historia/las-crisis-financieras-en-espana-1850-2012/index.html","wp_text_array":["perfil de maximos"],"wp_double_array":["19.0","30.0"]}},{"id":"is8lyrywhistoria/los-origenes-del-sistema-financiero/index.html","fields":{"project":"is8lyryw","title":"Los orígenes del sistema financiero:A propósito de los cien años de la Reserva Federal que se celebran la próxima semana, hablaremos un poco de los bancos centrales, describiendo su historia, sus funciones y sus objetivos de política. Los bancos centrales emergieron en los países industrializados de occidente mucho más tardíamente que los bancos privados. Hay señas de bancos privados 2.000 años antes de Cristo, lo que indica que los bancos privados tienen una data de 4.000 años.","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/federal-reserve.jpg","content":"A propósito de los cien años de la Reserva Federal que se celebran la próxima semana, hablaremos un poco de los bancos centrales, describiendo su historia, sus funciones y sus objetivos de política. Los bancos centrales emergieron en los países industrializados de occidente mucho más tardíamente que los bancos privados. Hay señas de bancos privados 2.000 años antes de Cristo, lo que indica que los bancos privados tienen una data de 4.000 años. Pero los bancos privados se potenciaron a medida que el sistema mercantilista de los siglos XV, XVI y XVII generó la necesidad de almacenar en forma segura el oro y los metales preciosos que llegaban a Europa provenientes del saqueo en los confines del mundo. La corriente mercantilista señalaba que el atesoramiento de los metales preciosos era la clave de la prosperidad de los países y la familia Médici detectó las ventajas del atesoramiento y ofreció los servicios de la custodia del oro a otras ricas familias europeas. Los bancos centrales nacieron en el fulgor del mercantilismo y surgieron como mediadores financieros de los bancos privados. En un principio los bancos centrales se encargaban de facilitar los pagos entre los bancos privados, pero no siempre tuvieron el rol de ser prestamistas de última instancia cuando un banco carecía de liquidez. Con el tiempo se convirtieron en la autoridad responsable de las políticas que afectan la oferta de dinero y el crédito. Luego fueron incorporando herramientas para operaciones monetarias de políticas de mercado: préstamos por ventanilla a la banca privada, cambios en las exigencias de reservas que podían afectar las tasas de interés a corto plazo, y el control de la base monetaria para lograr objetivos de política económica.En la actualidad existen tres objetivos fundamentales de política monetaria que administran los bancos centrales. El primero y más importante es la estabilidad de precios o la estabilidad en el valor del dinero. Esto significa mantener una baja tasa de inflación, con un objetivo actual del 2 por ciento. El segundo objetivo es mantener la estabilidad macroeconómica para evitar las perturbaciones financieras. Esto significa que se espera que la política monetaria aplique medidas para suavizar el ciclo económico y compensar los shocks de la economía. El tercer objetivo es la estabilidad financiera y el normal funcionamiento de los pagos externos e internos. Esto significa la existencia de un sistema de pagos eficiente que de credibilidad a todo el sistema.Los primeros bancos centralesLa historia de la banca central se remonta al menos al siglo XVII, con la fundación de la primera institución reconocida como un banco central, el Banco de Suecia. Este banco se estableció en 1668 con un fondo de acciones de los bancos privados y se destinó a prestar fondos al gobierno y actuar como centro de intercambio para el comercio. Casi tres décadas más tarde, en 1694, se creó el Banco de Inglaterra, que sería el más famoso banco central durante casi 300 años. Este banco también se fundó como una sociedad por acciones para la compra de deuda pública. Los otros bancos centrales que se establecieron más tarde en Europa tuvieron la misma concepción: eran una rama de la banca privada que se destinaba a lidiar con el desorden monetario y a prestar a los gobiernos. Por ejemplo, el Banco de Francia fue creado por Napoleón en 1800 para estabilizar la moneda después de la hiperinflación del papel moneda generado durante la Revolución Francesa y las conquistas napoleónicas, así como para ayudar en las finanzas del gobierno. Estos primeros bancos centrales emitían notas privadas que servían como moneda, y pronto adquirieron el monopolio en la emisión de esta notas de deuda.","topic":"historia","content_language":"es-ES","date":"2016-10-27T17:00:00Z","resourcename":"historia/los-origenes-del-sistema-financiero/index.html","wp_double_array":["18.0","27.0","83.0"],"wp_text_array":["perfil de maximos"]}},{"id":"is8lyrywen/publicacion/la-evolucion-de-la-financiacion-de-las-comunidades/index.html","fields":{"project":"is8lyryw","title":"La evolución de la financiación de las comunidades autónomas de régimen común, 2002-2014","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/summit.png","content":"En este trabajo se construyen series homogeneizadas de financiación regional a competencias homogéneas e igual esfuerzo fiscal desde 2002 hasta 2014, así como series complementarias de financiación por caja y financiación destinada a competencias singulares. En este trabajo se construyen series homogeneizadas de financiación regional a competenciashomogéneas e igual esfuerzo fiscal desde 2002 hasta 2014, así como series complementarias definanciación por caja y financiación destinada a competencias singulares. También se recopilan otrosagregados de interés que pueden servir para relativizar la financiación autonómica, incluyendo la poblaciónajustada regional. Estas series se utilizan para ilustrar algunos rasgos de interés de la evolución de lafinanciación agregada regional y de la posición relativa de las distintas comunidades autónomas en términosde financiación por unidad de necesidad.","topic":"publicacion","content_language":"es-ES","date":"2016-10-26T17:00:00Z","resourcename":"en/publicacion/la-evolucion-de-la-financiacion-de-las-comunidades/index.html","wp_double_array":["32.0","101.0","17.0","18.0","27.0","19.0","107.0","95.0"],"wp_text_array":["katie morell"]}},{"id":"is8lyrywen/historia/moltacte-cumple-una-decada-de-crecimiento-y-creacion-de-empleo/index.html","fields":{"project":"is8lyryw","title":"Moltacte cumple una década de crecimiento y creación de empleo","image_src":"http://d6fve07q425ph.cloudfront.net/wp-content/uploads/2016/10/moltacte-624x178.png","content":"Moltacte entró hace cinco años en la primera edición de Momentum Project, convirtiéndose en una de las primeras empresas en formar parte de su ecosistema. Su objetivo era muy claro: “crear puestos de trabajo sanadores”. En la actualidad, esta compañía catalana que da trabajo a personas con trastorno mental severo, cumple una década en la que no ha parado de crecer, aumentar su impacto positivo y mejorar las vidas de sus empleados.Esta cooperativa, que arrancó en el año 2006, se dedica a la reinserción laboral y a sensibilizar a la población acerca de un trastorno que, hoy en día, sigue siendo un estigma: la enfermedad mental. Su modelo de negocio comenzó en 2008 con la apertura de un establecimiento de ropa de distintas marcas en Manresa, que ofrecía modelos de otras temporadas, a precios asequibles, en formato boutique. En 2009 abrieron su segundo outlet en Sant Boi de Llobregat.En 2012, Moltacte abrió la primera tienda ‘for&amp;from’ de Stradivarius en Manresa, a la que después ha sumado dos de la marca Massimo Dutti. La primera se inauguró en 2014 en Llagostera (Gerona) y en abril de este año en Igualada (Barcelona). “Hay relaciones entre empresas que uno debe regar y cuidar durante muchos años y llega un día que fructifican. Momentum Project ha favorecido la fructificación de la relación entre Moltacte y el grupo Inditex”, explicaba Miquel Isanta, gerente de Moltacte.","topic":"historia","content_language":"es-ES","date":"2016-10-26T17:00:00Z","resourcename":"en/historia/moltacte-cumple-una-decada-de-crecimiento-y-creacion-de-empleo/index.html","wp_double_array":["32.0","38.0","113.0"],"wp_text_array":["e020952"]}}]}}};

	//jQuery.get(url_buscador, function(d) {
	    if (d.code === 200 && d.data.hits.found > 0) {


	    	numPublicaciones = getNumResultados(d, 'publicacion');
	    	numHistorias = getNumResultados(d, 'historia');
	    	numTalleres = getNumResultados(d, 'taller');


	    	if (d.data.hits.start == 0)
	        	jQuery('.contents div:nth-child(2)').first().html('<div class="contents">\
	        															<div id="search-layer"></div>\
	        															<div class="results">\
	        																<div class="tabs container">\
	        																	<header class="title-description mt-lg">\
	        																		<h1>' + object_name_script_os_js.resultado_de_busqueda + '</h1>\
	        																		<div class="description-container">\
	        																			<p>' + object_name_script_os_js.se_han_encontrado + ' ' + d.data.hits.found + ' ' + object_name_script_os_js.resultados_que_coinciden_con_la_palabra + ' <strong>Millenials</strong> ' + object_name_script_os_js.y_las_etiquetas + ' <strong>Fintech, Educación financiera</strong></p>\
	        																		</div> \
	        																	</header>\
	        																	<section class="mt-lg results-content-tabs workshops-results">\
	        																		<div class="controls">\
	        																			<select id="select-tab-results" class="selectpicker-form visible-xs">\
	        																				<option value="publishes">' + object_name_script_os_js.publicaciones + ' (' + numPublicaciones + ')</option>\
	        																				<option value="histories">' + object_name_script_os_js.historias + ' (' + numHistorias + ')</option>\
	        																				<option value="workshops">' + object_name_script_os_js.talleres + ' (' + numTalleres + ')</option>\
	        																			</select>\
	        																			<ul id="results-tabs" class="nav nav-tabs" role="tablist">\
	        																				<li class="hidden-xs active">\
	        																					<a class="publishes" href="#publishes" aria-controls="publishes" role="tab" data-toggle="tab">' + object_name_script_os_js.publicaciones + ' (' + numPublicaciones + ')</a>\
	        																				</li>\
	        																					<li class="hidden-xs">\
	        																						<a class="histories" href="#histories" aria-controls="histories" role="tab" data-toggle="tab">' + object_name_script_os_js.historias + ' (' + numHistorias + ')</a>\
	        																					</li>\
	        																					<li class="hidden-xs">\
	        																						<a class="workshops" href="#workshops" aria-controls="workshops" role="tab" data-toggle="tab">' + object_name_script_os_js.talleres + ' (' + numTalleres + ')</a>\
	        																				</li>\
	        																			</ul>\
	        																		</div>\
	        																		<div class="tab-content">\
	        																			<div role="tabpanel" class="tab-pane active" id="publishes">\
	        																				<section class="publishes-wrapper">\
	        																					<div class="sort-items-container">\
	        																						<a href="#" class=" selected ">\
	        																							<span class="icon bbva-icon-arrow arrowUp"></span>\
	        																							<span class="text">' + object_name_script_os_js.mas_recientes + '</span>\
	        																						</a>\
	        																						<a href="#" class="">\
	        																							<span class="icon bbva-icon-arrow arrowDown"></span>\
	        																							<span class="text">' + object_name_script_os_js.mas_antiguos + '</span>\
	        																						</a>\
	        																						<a href="#" class="">\
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
	        																					<a href="#" class=" selected ">\
	        																						<span class="icon bbva-icon-arrow arrowUp"></span>\
	        																						<span class="text">' + object_name_script_os_js.mas_recientes + '</span>\
	        																					</a>\
	        																					<a href="#" class="">\
	        																						<span class="icon bbva-icon-arrow arrowDown"></span>\
	        																						<span class="text">' + object_name_script_os_js.mas_antiguos + '</span>\
	        																					</a>\
	        																					<a href="#" class="">\
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
	        																							<select id="select-country" class="selectpicker-form countries">\
	        																								<option value="">Mexico</option>\
	        																								<option value="">España</option>\
	        																								<option value="">Perú</option>\
	        																								<option value="">Francia</option>\
	        																							</select>\
	        																							<a href="#" class="link-web">' + object_name_script_os_js.ir_a_la_web_bancomer + ' <span class="current-country"></span><span class="icon bbva-icon-link_external font-xs mr-xs"></span></a>\
	        																						</div>\
	        																					</div>\
	        																				<article class="container data-grid">\
	        																					<header>\
	        																						<h1>' + object_name_script_os_js.talleres + ' ' + object_name_script_os_js.de + '<span class="current-country"></span></h1>\
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
	        													</div>');
	        // publicaciones
	        jQuery.each(d.data.hits.hit, function(i, result) {
	        	if (result.fields.topic == 'publicacion')
	        		jQuery('#publishes .cards-grid .container div.row').first().append(getPostFiltro_general(result.fields, 'publishes'));
	        });
	        // historias
	        jQuery.each(d.data.hits.hit, function(i, result) {
	        	if (result.fields.topic == 'historia')
	        		jQuery('#histories .cards-grid .container div.row').first().append(getPostFiltro_general(result.fields, 'histories'));
	        });
	        // talleres
	        jQuery.each(d.data.hits.hit, function(i, result) {
	        	if (result.fields.topic == 'taller')
	        		jQuery('#workshops .grid-wrapper').first().append(getPostFiltro_general(result.fields, 'workshops'));
	        });
	        if (d.data.hits.found == jQuery(".card-container").size()) {
	        	jQuery('a#readmore').hide();
	        } else {
	        	jQuery('a#readmore').show();
	        }
	    } else {
	        jQuery('.cards-grid .container div.row').first().html('<p>' + object_name_script_os_js.no_results + '</p>');
	        jQuery('a#readmore').hide();
	    }
	//}, 'json');
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
		var fecha = new Date(post['date'].substring(0, 10));
		var urlImagen = post['image_src'];
		var urlPublicacion = post['resourcename'];
		var cita = true;
		var video = true;
		var pdf = true;


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

		fecha = fecha.getDate() + ' ' +  meses[fecha.getMonth()] + ' ' + fecha.getFullYear();
		fecha = fecha.toString();
		fecha = fecha.toUpperCase();


		order = ['double', 'double', 'triple', 'triple', 'triple'];
		i = jQuery('#' + id + ' .card-container').size();
		grid = order[(i % 5)];
		if (grid == "double") {
			html = '<div class="col-xs-12 col-sm-6 double-card card-container">';
		} else {
			html = '<div class="col-xs-12 col-sm-4 triple-card card-container">';
		}
		html += '<section class="container-fluid main-card"><header class="row header-container"><div class="image-container col-xs-12"><a href="' + urlPublicacion + '" class="link-header-layer visible-xs"><img src="' + urlImagen + '" alt=""></a><img src="' + urlImagen + '" alt="" class="hidden-xs"></div><div class="hidden-xs floating-text col-xs-9"><p class="date">' + fecha + '</p><h1>' + titulo + '</h1></div></header><div class="row data-container"><a href="#" class="link-layer visible-xs">&nbsp;</a><div class="nopadding date">' + fecha + '</div><div class="main-card-data-container-title-wrapper"><h1 class="title nopadding">' + titulo + '</h1></div><p class="main-card-data-container-description-wrapper">' + descripcion + '</p><a href="' + urlPublicacion + '" class="hidden-xs mb-xs readmore">' + object_name_script_os_js.leer_mas + '</a><footer><div class="icon-row">';
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

	}

	return html;
}