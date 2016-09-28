(function($) {
    // Remove the textarea before displaying visual editor
    $('#description').parents('tr').remove();
    $('#password').next().remove();
    $('#password').remove();
    
    if( ! $("input[name='is_link_unit']:checkbox").is(':checked') ){
		$("#user_link_unit").prop("disabled", "disabled");
	}

	$("input[name='is_link_unit']:checkbox").change(function() {
   		$("#user_link_unit").prop("disabled", !this.checked);
	});
	
})(jQuery);