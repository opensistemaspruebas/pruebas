jQuery(document).ready(function() {
    jQuery('select#color_circulo').simplecolorpicker({theme: 'glyphicons'});
    jQuery('select#color_barra').simplecolorpicker({theme: 'glyphicons'});
    jQuery('select#color_dato').simplecolorpicker({theme: 'glyphicons'});
    jQuery('select#visualizacion').on("change", function() {
        toggleFields();
    });



    jQuery("input#objetivo, input#completado").on("focusout", function() {

    if (jQuery("#visualizacion").val() == "circulo" || jQuery("#visualizacion").val() == "barra"){
    
        var objetivo = parseInt(jQuery('#objetivo').val());
        var completado = parseInt(jQuery('#completado').val());



        if(completado > objetivo){

            jQuery('#publish').addClass('disabled');
            jQuery('#objetivo').css('border-color','rgba(223,4,4,.8)');
            jQuery('#objetivo').css('box-shadow', '0 0 2px rgba(223,4,4,.8)');
            jQuery('#objetivo').css('-webkit-box-shadow', '0 0 2px rgba(223,4,4,.8)');
          
        }
        else{

            jQuery('#publish').removeClass('disabled');
            jQuery('#objetivo').css('border-color','#ddd');
            jQuery('#objetivo').css('box-shadow', '0 0 2px rgba(0,0,0,.07)');
            jQuery('#objetivo').css('-webkit-box-shadow', '0 0 2px rgba(0,0,0,.07)');
        }
    }

    });



});

function toggleFields(){
   if (jQuery("#visualizacion").val() == "circulo") {
        jQuery("#color-circulo").show();
        jQuery("#valor_objetivo").show();
        jQuery("#color-barra").hide();
        jQuery("#color-dato").hide();
    }
    else if (jQuery("#visualizacion").val() == "barra"){
        jQuery("#color-barra").show();
        jQuery("#valor_objetivo").show();
        jQuery("#color-circulo").hide();
        jQuery("#color-dato").hide();
    }
    else {
        jQuery("#color-dato").show();
        jQuery("#color-circulo").hide();
        jQuery("#color-barra").hide();
        jQuery("#valor_objetivo").hide();
    }
}

function myFunction() {
      
    if (jQuery("#visualizacion").val() == "circulo" || jQuery("#visualizacion").val() == "barra"){
    
        var objetivo = jQuery('#objetivo').val();
        var completado = jQuery('#completado').val();



        if(completado > objetivo){

            jQuery('#publish').addClass('disabled');
          
        }
        else{

            jQuery('#publish').removeClass('disabled');
        }
    }
 }
