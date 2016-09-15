/*Open top panel*/
jQuery(document).ready(function() {

	// Si es IE10 añado las clases ie10, ie a html
	if(document.all && window.atob) {
		jQuery('html').addClass('ie10 ie');
	}

	// Si es IE11 añado las clases ie11, ie a html
	var isIE11 = !!navigator.userAgent.match(/Trident.*rv[ :]*11\./);
	if(isIE11) {
		jQuery('html').addClass('ie11 ie');
	}

	language = jQuery('html').attr('lang');
	// Si el navegador es IE 9 o menor
	if(document.all && !window.atob) {
		var oldBrowser = jQuery.cookie('oldBrowser');
		if(oldBrowser == 'true')
			return;
		// Español
		jQuery.cookie('oldBrowser','true',{ expires: 30, path: '/'});
		if(language == 'es-ES') {
			alert('Por favor tenga en cuenta que este sitio web no da sporte a ningÃºn navegador anterior a IE10. Si usted estuviera usando uno de ellos, por favor actualÃ­celo.');
		// Ingles
		} else {
			alert('Please note that this website will not be supporting any browser older than IE10 (e.g. IE9, IE8, IE7,IE6, IE5.5 etc).  If you are running one of these old browsers, please upgrade it.');
		}
	}
	// Inicialmente oculto
	jQuery('#subirMovil').hide();
	jQuery(window).scroll(function() {
		// Si no estamos arriba, se muestra
    if ((jQuery(this).scrollTop()-500) <= 0) {
        jQuery('#subirMovil').fadeOut();
    } else {
    		jQuery('#subirMovil').fadeIn();
    }
	});

	jQuery('#subirMovil').on('click',function(){
		jQuery(this).toTop();
	}); 

   /****************************************
		Select bonitos con selectbox
	****************************************/
	jQuery("#buscarGeneral_selectPais1a").selectbox();
	jQuery("#buscarGeneral_selectPais1b").selectbox();
	jQuery("#buscarGeneral_selectPais2").selectbox();
	jQuery("#ofertasFiltros_selectEstado").selectbox();
	jQuery("#ofertasFiltros_selectCiudad").selectbox();
	jQuery("#ofertasFiltros_selectFechaPublicacion").selectbox();
	jQuery(".select-pagination_f").selectbox();
	
	/****************************
		menu
	****************************/
	if( jQuery(window).width() > 684)
	{
		jQuery(".mainMenu_n1").hover(function(){
			jQuery(this).children(".mainMenuNavegacion_n2_content").css("display", "block");
			jQuery(this).addClass("abierto");
		}, function() {
			jQuery(this).children(".mainMenuNavegacion_n2_content").css("display", "none");
			jQuery(this).removeClass("abierto");
		})	
	}
	if( jQuery(window).width() < 684) 
	{
		jQuery(".mainMenu_n1").hover(function(){
			jQuery(this).children(".mainMenuNavegacion_n2_content").css("display", "none");
			jQuery(this).addClass("abierto");
		}, function() {
			jQuery(this).children(".mainMenuNavegacion_n2_content").css("display", "none");
			jQuery(this).removeClass("abierto");
		})	
	}
	
	/************************************************
		Mostrar capas ocultas con un click
	************************************************/
	jQuery('#accordion_tab1').bind('click',function(e){
		e.preventDefault();
        e.stopPropagation();
		if(jQuery(this).hasClass('closed')) {
			jQuery('#accordion_tab1').removeClass('closed');
			jQuery('#accordion_tab1').addClass('open');
			jQuery('#accordion_content1').slideDown(1000);
		} else {
			jQuery('#accordion_content1').slideUp(1000).delay(100).queue(function(next){
		    jQuery('#accordion_tab1').removeClass('open');
				jQuery('#accordion_tab1').addClass('closed');
		    next();
			});
		}
	});

		
	/*escritorio y tablet*/
	if( jQuery(window).width() > 684) 
	{
		var element = document.getElementById("buscadorGeneral_mostrarClick_movil");
		//element.remove();
		
		/*jQuery('#buscadorGeneral_mostrarClick_escritorio').persistentPanel({
		  toggler: '#toggleBuscadorGeneral',
		  duration: 1000,
		  cookieName: 'panelicous',
		  defaultState: 'closed'
		});
		
		jQuery('#buscadorGeneral_mostrarClick_escritorio').persistentPanel({
		  toggler: '#closeBuscadorGeneral',
		  duration: 1000,
		  cookieName: 'panelicous',
		  defaultState: 'closed'
		});*/
		
		// Al cambiar de pagina el buscador siempre esta cerrado
		jQuery.cookie('buscadorCab','closed',{ expires: 30, path: '/'});

		// Boton cerrar (X) buscador Escritorio
		jQuery('#closeBuscadorGeneral').bind('click',function(e){
			e.preventDefault();
      e.stopPropagation();
			jQuery.cookie('buscadorCab','closed',{ expires: 30, path: '/'});
			jQuery('#buscadorGeneral_mostrarClick_escritorio').slideUp(1000).delay(100).queue(function(next){
			    jQuery('#toggleBuscadorGeneral').removeClass('open');
				jQuery('#toggleBuscadorGeneral').addClass('closed');
			    next();
			});
		
		});

		// Boton lupa escritorio
		jQuery('#toggleBuscadorGeneral').bind('click',function(e){
			e.preventDefault();
      		e.stopPropagation();
			var open = jQuery.cookie('buscadorCab');
			if(open == 'open') {
				jQuery.cookie('buscadorCab','closed',{ expires: 30, path: '/'});
				jQuery('#buscadorGeneral_mostrarClick_escritorio').slideUp(1000).delay(100).queue(function(next){
				    jQuery('#toggleBuscadorGeneral').removeClass('open');
					jQuery('#toggleBuscadorGeneral').addClass('closed');
				    next();
				});
			} else {
				jQuery.cookie('buscadorCab','open',{ expires: 30, path: '/'});
				jQuery('#buscadorGeneral_mostrarClick_escritorio').slideDown(1000);
				jQuery('#toggleBuscadorGeneral').removeClass('closed');
			    jQuery('#toggleBuscadorGeneral').addClass('open');
			}
		});
		
	}
	
	/*solo movil*/
	if( jQuery(window).width() <= 684) 
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

		
		/*jQuery('#buscadorGeneral_mostrarClick_movil').persistentPanel({
		  toggler: '#toggleBuscadorGeneral',
		  duration: 1000,
		  cookieName: 'panelicous',
		  defaultState: 'closed'
		});
		
		jQuery('#menuPrincipalWeb_mostrarClick_movil').persistentPanel({
		  toggler: '#toggleMainMenuSmartphone',
		  duration: 1000,
		  cookieName: 'panelicous',
	  	  defaultState: 'closed'
		});
		
		jQuery('#header_tools').persistentPanel({
		  toggler: '#toggleMainMenuSmartphone',
		  duration: 1300,
		  cookieName: 'panelicous',
		  defaultState: 'closed'
		});*/

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
		
		/*jQuery('#filtrosBox_mostrarClick_movil').persistentPanel({
		  toggler: '#toggleFiltrosSmartphone',
		  duration: 1000,
		  cookieName: 'panelicous',
		  defaultState: 'closed'
		});*/
		// Filtro de fechas en bÃºsqueda de ofertas version movil
		jQuery('#toggleFiltrosSmartphone').on('click',function(){
			var open = jQuery(this).hasClass('open');
			
			if(open) {
				jQuery('#filtrosBox_mostrarClick_movil').slideUp(500).delay(100).queue(function(next){
				    jQuery('#toggleFiltrosSmartphone').removeClass('open');
						jQuery('#toggleFiltrosSmartphone').addClass('closed');
				  	next();
				});
			} else {
				jQuery('#filtrosBox_mostrarClick_movil').slideDown(1000);
				jQuery('#toggleFiltrosSmartphone').removeClass('closed');
			  jQuery('#toggleFiltrosSmartphone').addClass('open');
			}
		});

		// Touch carrusel promocional
		jQuery( ".moduloContenido_carruselPromocionalHeader" ).on( "swipeleft", function(){
			var id = 1;
			var container = jQuery(this);
			var sizeList = container.find('li.tab_boton').length;
			if(sizeList < 2) {
				return '';
			}
			var active = false;
			container.find('li.tab_boton').each(function(index){
					//desactivamos boton y activamos elemento de menu
					if(active) {
						//id = jQuery(this).attr('id');
						return;
					}
					if( index == (sizeList-1) & jQuery(this).hasClass('active') ){
						container.find('li.tab_boton').eq(0).addClass("active");
						id = container.find('li.tab_boton').eq(0).attr('id');
			    	jQuery(this).removeClass("active");
			    	active = true;
					}
			    else if( jQuery(this).hasClass('active') ){
			    	jQuery(this).next().addClass("active");
			    	id = jQuery(this).next().attr('id');
			    	jQuery(this).removeClass("active");
			    	active = true;
				}
			});
			
			container.find('.tab_box').hide();
			container.find('.tab_box#'+id).show("slide", { direction: "right" }, 300);
		});

		jQuery( ".moduloContenido_carruselPromocionalHeader" ).on( "swiperight", function(){
			var id = 1;
			var container = jQuery(this);
			var sizeList = container.find('li.tab_boton').length;
			if(sizeList < 2) {
				return '';
			}
			var active = false;
			container.find('li.tab_boton').each(function(index){
					//desactivamos boton y activamos elemento de menu
					if(active) {
						return;
					}
					if( index == 0 & jQuery(this).hasClass('active') ){
						container.find('li.tab_boton').eq(sizeList-1).addClass("active");
						id = container.find('li.tab_boton').eq(sizeList-1).attr('id');
			    	jQuery(this).removeClass("active");
			    	active = true;
					}
			    else if( jQuery(this).hasClass('active') ){
			    	jQuery(this).prev().addClass("active");
			    	id = jQuery(this).prev().attr('id');
			    	jQuery(this).removeClass("active");
			    	active = true;
				}
			});
			container.find('.tab_box').hide();
			container.find('.tab_box#'+id).show("slide", { direction: "left" }, 300);
		});

	}
	
	
	/********************************************************************************
		Pestañas horizontales > componente carrusel promocional header
	********************************************************************************/

//	jQuery(".tabs_menuHorizontal > li").click(function(e){
//	   var a = e.target.id;
//	   //desactivamos boton y activamos elemento de menu
//	   jQuery(".tabs_menuHorizontal li.active").removeClass("active");
//	   jQuery(".tabs_menuHorizontal #"+a).addClass("active");
//	   //ocultamos divisiones, mostramos la seleccionada
//	   jQuery(".tab_box").css("display", "none");
//	   jQuery("#"+a).fadeIn();
//	 });
	 
//	jQuery(".tab_boton").click(function(e){
//            console.log("entra");
//        });
	
	/********************************************************************************
		Mostrar title dentro del input en buscador general
	********************************************************************************/
//	jQuery('input#buscarGeneral_inputQue').ready(function () {
//			jQuery('input#buscarGeneral_inputQue').val(jQuery('input#buscarGeneral_inputQue').attr('title'));
//		  if (jQuery('input#buscarGeneral_inputQue').attr('title') != "Â¿Que puesto buscas?" && jQuery('input#buscarGeneral_inputQue').hasClass('blur')) {
//			jQuery('input#buscarGeneral_inputQue').removeClass('blur');
//		  }
//		  if (jQuery('input#buscarGeneral_inputQue').attr('title') == "Â¿Que puesto buscas?") {
//			jQuery('input#buscarGeneral_inputQue').addClass('blur');
//		  }	        
//		});
//			  
//		jQuery('input#buscarGeneral_inputQue').blur(function () {
//			if (this.value === '') {
//				if (jQuery('input#buscarGeneral_inputQue').attr('title') == "Â¿Que puesto buscas?")
//				{
//					jQuery('input#buscarGeneral_inputQue').val(jQuery('input#buscarGeneral_inputQue').attr('title')).addClass('blur');
//				}
//			}
//		})
//	});
     
				
            //if (jQuery('input#buscarGeneral_inputQue').hasClass('blur')) 
            //{
            //    jQuery(this).val('');
            //}else
            //{
            	// Placeholder buscador
            	if(language == 'es-ES') {
                jQuery('input#buscarGeneral_inputQue').attr('placeholder','Â¿Que puesto buscas?');
            	} else {
            		jQuery('input#buscarGeneral_inputQue').attr('placeholder','What job are you looking for?');
            	}
            //}
        

        //selecciona el campo buscador al clicar sobre el
        jQuery('input#buscarGeneral_inputQue').click(function(){
            if (jQuery(this).hasClass('blur')) 
            {
                jQuery(this).removeClass('blur');
            }else
            {
                jQuery(this).removeClass('blur');
            }
            jQuery(this).attr('placeholder','');
        });
        
        
        //configura la mascara del video
        jQuery("div[id^=mask_0]").click(function(e){
            e.preventDefault();;
            var mask_id = jQuery(this).attr('id');
//            console.log("mask_id="+mask_id);
            var video_id = 'videoBox_'+mask_id.substring('5');
//            console.log("video_id="+video_id);
            var vcode = jQuery('#'+video_id).attr('name');
//            console.log("vcode="+vcode);
            jQuery
            "use strict";
            jQuery("#"+video_id).attr('src','https://www.youtube.com/embed/'+vcode+
                    '?autoplay=1&loop=1&rel=0&wmode=transparent');
            jQuery("#"+mask_id).hide(); 
        });       
        
        
        //acepta los terminos del aviso de cookies
        jQuery("#btn_aceptar").click(function(e){
            jQuery.ajax({
                url: 'wp-content/themes/bbva-empleo/functions.php',
                dataType: 'json',
                async: false,
                data: {
                    'action': 'accept_cookies',
                    'option': 'acepta'
                },
                type: 'POST',
                
                complete: function() 
                {
                    //jQuery("#termscookie").css("display", "none");
                    jQuery("#termscookie").slideUp(800);
                },
                
                error: function()
                {

                }
              
            })
        });
        
        
        //cambia el idioma en el selector superior y modifica la cookie del idioma
        jQuery(".idiomasPortal li a").click(function(e){
            var idioma = "";
            if (jQuery(this).text() == 'English'){
                idioma = 'en';
            }else{
                idioma = 'es';
            }
            jQuery.cookie('defined_lang',idioma,{ expires: 30, path: '/'});
          
        });
});

// Boton Subir
jQuery.fn.toTop = function() {  
  var body = jQuery("html, body");
  body.animate({scrollTop:10}, '500', 'swing');
	};
