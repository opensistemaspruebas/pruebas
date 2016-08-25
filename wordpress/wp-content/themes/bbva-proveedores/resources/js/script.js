<!-- Custom Theme JavaScript -->

$(document).ready(function(){

	/****************************
		Menu principal
	****************************/
	$("[id^=menu-menu-principal] > li").on("mouseover", function() { 
		$(this).children(".sub-menu").css("display", "block");
		$(this).addClass("abierto");
	});
	$("[id^=menu-menu-principal] > li").on("mouseout", function() { 
		$(this).children(".sub-menu").css("display", "none");
		$(this).removeClass("abierto");
	});

	
	/************************************************
		Acordeon del footer
	************************************************/
	$('#accordion_tab1').on( "click", function() {
		//e.preventDefault();
        //e.stopPropagation();
		if($(this).hasClass('closed')) {
			$('#accordion_tab1').removeClass('closed');
			$('#accordion_tab1').addClass('open');
			$('#accordion_content1').slideDown(1000);
		} else {
			$('#accordion_content1').slideUp(1000).delay(100).queue(function(next){
		    $('#accordion_tab1').removeClass('open');
				$('#accordion_tab1').addClass('closed');
		    next();
			});
		}
	});
	
	/************************************************
		Caja Buscador
	************************************************/
	$("#toggleBuscadorGeneral").click(function(){
		if ( $("#buscadorGeneralExtensible").is(":visible") ) {
			$("#buscadorGeneralExtensible").hide();
			$("#inpbuscar_general").animate({width:'0px'},"slow");
			$("#header_tools .wrapperPosicionado").animate({right:'50px'},"slow");
		} else {
			$("#buscadorGeneralExtensible").show();
			$("#inpbuscar_general").animate({width:'176px'},"slow");
			$("#header_tools .wrapperPosicionado").animate({right:'280px'},"slow");
		}
	});
	
	/****************************************
		Select bonitos con selectbox
	****************************************/
	$("#selectSupplier_centroEspecialEmpleo").selectbox();
	//$("#selectSupplier_pais").selectbox();
	
	/*$("#selectPaises_filtrosNoticias").selectbox();
	$("#selectPaises_filtrosHerramientas").selectbox();
	$("#selectPaises_filtrosFaqs").selectbox();*/


	/****************************************
		Flecha para volver hacia arriba
	****************************************/
	if ($('#back-to-top').length) {
	    var scrollTrigger = 100, // px
	        backToTop = function () {
	            var scrollTop = $(window).scrollTop();
	            if (scrollTop > scrollTrigger) {
	                $('#back-to-top').addClass('show');
	            } else {
	                $('#back-to-top').removeClass('show');
	            }
	        };
	    backToTop();
	    $(window).on('scroll', function () {
	        backToTop();
	    });
	    $('#back-to-top').on('click', function (e) {
	        e.preventDefault();
	        $('html,body').animate({
	            scrollTop: 0
	        }, 700);
	    });
	}

	/****************************************
		Flecha para ir hacia abajo
	****************************************/
	if ($('#back-to-bottom').length) {
		$(document).ready(function() {
		    if ($(window).height() >= $(window).scrollTop()) {
		        $('#back-to-bottom').addClass("show");
		    }
		    $(window).scroll(function() {
		        if ($(window).scrollTop() == 0) {
		            $('#back-to-bottom').addClass("show");
		        } else {
		            $('#back-to-bottom').removeClass("show");
		        }
		        if ($(window).scrollTop() >= $(window).height()) {
		            $('#back-to-bottom').removeClass("show");
		        } else {
		            $('#back-to-bottom').addClass("show");
		        }
		    });
		    $('#back-to-bottom').on('click', function (e) {
		        e.preventDefault();
		        $('html,body').animate({
		            scrollTop: $(window).height()
		        }, 700);
			});
		});
	}


	
	/************************************************
		Cambiar la imagen del carrusel a bg
	************************************************/
	var getImageSrc = $('.moduloCarrusel_boxImagen img').attr('src');
	$('.moduloCarrusel_boxImagen').css('background-image', 'url(' + getImageSrc + ')');
	$('.moduloCarrusel_boxImagen img').css("display", "none");
	
	$('.carruselPromocional .tab_boton').on('click',function(){
		var id = $(this).attr('id');
		var getImageSrc = $('.tab_box#'+id+' .moduloCarrusel_boxImagen img').attr('src');
		$('.tab_box#'+id+' .moduloCarrusel_boxImagen').css('background-image', 'url(' + getImageSrc + ')');
		$('.tab_box#'+id+' .moduloCarrusel_boxImagen img').css("display", "none");	
	});
	
	var boxImages =	$('.contenidoNoticias_boxImage img');
	for(var i = 0; i < boxImages.length; i++) {
		var getImageSrc = $(boxImages[i]).attr('src');
		$(boxImages[i]).parent().css('background-image', 'url(' + getImageSrc + ')');
		$(boxImages[i]).css("display", "none");
	}

	/****************************************
		Lupa y Menu navegacion en solo movil
	****************************************/	
	/*solo movil*/
	if( jQuery(window).width() <= 750) 
	{
		var element = document.getElementById("buscadorGeneral_mostrarClick_escritorio");
		//element.remove();

		// Al cargar la pagina el buscador siempre esta cerrado
		jQuery.cookie('buscadorMov','closed',{ expires: 30, path: '/'});
		// Boton lupa buscador movil
		jQuery('#toggleBuscadorGeneral').bind('click',function(e){
			e.preventDefault();
      e.stopPropagation();
			var open = jQuery.cookie('buscadorMov');
			var open_menu = jQuery.cookie('menuMov');
			if(open == 'open') {
				jQuery.cookie('buscadorMov','closed',{ expires: 30, path: '/'});
				jQuery('#buscadorGeneral_mostrarClick_movil').slideUp(1000).delay(100).queue(function(next){
				    jQuery('#toggleBuscadorGeneral').removeClass('open');
						jQuery('#toggleBuscadorGeneral').addClass('closed');
				    next();
				});
			} else {
				// Si el menÃº esta abierto, primero lo cerramos
				if(open_menu == 'open') {
					jQuery.cookie('menuMov','closed',{ expires: 30, path: '/'});
					jQuery('#header_tools .wrapperPosicionado').slideUp(300);
					jQuery('#menuPrincipalWeb_mostrarClick_movil').slideUp(1000).delay(100).queue(function(next){
					    jQuery('#toggleMainMenuSmartphone').removeClass('open');
							jQuery('#toggleMainMenuSmartphone').addClass('closed');
					  	next();
					});
				}
				jQuery.cookie('buscadorMov','open',{ expires: 30, path: '/'});
				jQuery('#buscadorGeneral_mostrarClick_movil').slideDown(1000);
				jQuery('#toggleBuscadorGeneral').removeClass('closed');
			    jQuery('#toggleBuscadorGeneral').addClass('open');
			}
		});

		// Al cargar la pagina el menÃº siempre esta cerrado
		jQuery.cookie('menuMov','closed',{ expires: 30, path: '/'});
		// Boton mostrar menÃº movil
		jQuery('#toggleMainMenuSmartphone').on('click',function(){
			var open = jQuery.cookie('menuMov');
			var open_buscador = jQuery.cookie('buscadorMov');
			if(open == 'open') {
				jQuery.cookie('menuMov','closed',{ expires: 30, path: '/'});
				jQuery('#header_tools .wrapperPosicionado').slideUp(300);
				jQuery('#menuPrincipalWeb_mostrarClick_movil').slideUp(1000).delay(100).queue(function(next){
				    jQuery('#toggleMainMenuSmartphone').removeClass('open');
						jQuery('#toggleMainMenuSmartphone').addClass('closed');
				  	next();
				});
			} else {
				// Si esta abierto el buscador, primero lo cerramos
				if(open_buscador == 'open') {
					jQuery.cookie('buscadorMov','closed',{ expires: 30, path: '/'});
					jQuery('#buscadorGeneral_mostrarClick_movil').slideUp(1000).delay(100).queue(function(next){
					    jQuery('#toggleBuscadorGeneral').removeClass('open');
							jQuery('#toggleBuscadorGeneral').addClass('closed');
					    next();
					});
				}
				jQuery.cookie('menuMov','open',{ expires: 30, path: '/'});
				jQuery('#menuPrincipalWeb_mostrarClick_movil').slideDown(1000);
				jQuery('#header_tools .wrapperPosicionado').slideDown(1100);
				jQuery('#toggleMainMenuSmartphone').removeClass('closed');
			  jQuery('#toggleMainMenuSmartphone').addClass('open');
			}
		});
	}
	 
});