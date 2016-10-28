jQuery(document).ready(function() {
    jQuery('select#color_circulo').simplecolorpicker({theme: 'glyphicons'});
    jQuery('select#color_barra').simplecolorpicker({theme: 'glyphicons'});
    jQuery('select#color_dato').simplecolorpicker({theme: 'glyphicons'});
    jQuery('select#visualizacion').on("change", function() {
        toggleFields();
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