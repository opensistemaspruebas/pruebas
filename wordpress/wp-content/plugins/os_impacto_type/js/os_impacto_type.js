jQuery(document).ready(function() {
	jQuery('select#color').simplecolorpicker({theme: 'glyphicons'});
	jQuery('select#visualizacion').on("change", function() {
		toggleFields();
	});
});

function toggleFields(){
   if (jQuery("#visualizacion").val() == "circulo") {
        jQuery("#form1").show();
        jQuery("#form2").hide();
        jQuery("#form3").hide();
    }
    else if (jQuery("#visualizacion").val() == "barra"){
        jQuery("#form2").show();
        jQuery("#form1").hide();
        jQuery("#form3").hide();
    }
    else {
        jQuery("#form3").show();
        jQuery("#form1").hide();
        jQuery("#form2").hide();
    }
}