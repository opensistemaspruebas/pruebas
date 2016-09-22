/* Custom Theme JavaScript */

jQuery(document).ready(function($) {

	/****************************
		Menu principal
	****************************/
	if( $(window).width() > 684)
	{
		$("#menu-menu-principal li").on("mouseover", function() { 
			$(this).children(".sub-menu").css("display", "block");
			$(this).addClass("abierto");
		});
		$("#menu-menu-principal li").on("mouseout", function() { 
			$(this).children(".sub-menu").css("display", "none");
			$(this).removeClass("abierto");
		});
	}
	
	
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
	/*$("#selectPaises_filtrosNoticias").selectbox();
	$("#selectPaises_filtrosHerramientas").selectbox();
	$("#selectPaises_filtrosFaqs").selectbox();*/
	 
});