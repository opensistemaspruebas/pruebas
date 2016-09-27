jQuery(document).ready(function() {
	jQuery("a.readmore").on("click", function(e) {
		e.preventDefault();
		console.log("padipoaisd");
		var last = jQuery(".card-container:visible").last().attr("name");
		var n = last.replace("card_", "");
		console.log(n);
	});
});