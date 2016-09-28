jQuery(document).ready(function($) {

	$("select#language-header").on("change", function() {
		console.log("camio");
		var val = jQuery(this).find(":selected").val();
		window.location.href = val;
	});
	 
});