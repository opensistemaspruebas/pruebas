jQuery(document).ready(function($) {
	
	$('select[name="color"]').simplecolorpicker({theme: 'glyphicons'});

});


function toggleFields() {
    if ($("#visualizacion").val() == "circulo")
        $("#parentPermission").show();
    else
        $("#parentPermission").hide();
}