jQuery(document).ready(function($) {

	$("select#language-header").change(function() {
		console.log("cambio");
		var val = jQuery(this).find(":selected").val();
		window.location.href = val;
	});
	 
});