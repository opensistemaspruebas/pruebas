jQuery(document).ready(function($) {
	/*ocultar_campos();
	jQuery('div#informacion_perfiles input[type="checkbox"]').change(function(e) {
		ocultar_campos();
	});*/


	var count = 0;

	jQuery("#add-trabajo").click(function(e) {        
		count++;
		$('<div style="border: 3px solid white;padding: 5px;margin-bottom: 10px;"><table class="form-table"><tbody><tr><th><label for="trabajo_titulo[' + count + ']">Trabajo relacionado</label></th><td><input type="text" name="trabajo_titulo[' + count + ']" id="trabajo_titulo[' + count + ']" value="" class="regular-text"><br></td></tr><tr><th><label for="trabajo_texto[' + count + ']">Descripción</label></th><td><textarea id="trabajo_texto[' + count + ']" name="trabajo_texto[' + count + ']" rows="5" cols="40"></textarea></td></tr><tr><th><label for="trabajo_enlace[' + count + ']">Enlace al trabajo</label></th><td><input type="url" name="trabajo_enlace[' + count + ']" id="trabajo_enlace[' + count + ']" value="" class="regular-text"></td></tr></tbody></table><button id="delete-trabajo" type="button">Eliminar este trabajo</button></div>').insertBefore(this);
	});

	jQuery("#delete-trabajo").live("click", function(e) {
		jQuery(this).parent().remove();
	});


	var file_frame;
	$('.additional-user-image').on('click', function(event) {
	    event.preventDefault();
	    if (file_frame) {
	        file_frame.open();
	        return;
	    }
	    file_frame = wp.media.frames.file_frame = wp.media({
	        title: $(this).data('uploader_title'),
	        button: {
	            text: $(this).data('uploader_button_text'),
	        },
	        multiple: false
	    });
	    file_frame.on('select', function() {
	        attachment = file_frame.state().get('selection').first().toJSON();
	        $('#imagen_perfil').val(attachment.url);
	        $('#mostrar_imagen_perfil').attr("src", attachment.url);
	        $('#mostrar_imagen_perfil').show();
	    });
	    file_frame.open();
	});


	var file_frame2;
	$('.additional-cabecera-image').on('click', function(event) {
	    event.preventDefault();
	    if (file_frame2) {
	        file_frame2.open();
	        return;
	    }
	    file_frame2 = wp.media.frames.file_frame = wp.media({
	        title: $(this).data('uploader_title'),
	        button: {
	            text: $(this).data('uploader_button_text'),
	        },
	        multiple: false
	    });
	    file_frame2.on('select', function() {
	        attachment = file_frame2.state().get('selection').first().toJSON();
	        $('#imagen_cabecera').val(attachment.url);
	        $('#mostrar_imagen_cabecera').attr("src", attachment.url);
	        $('#mostrar_imagen_cabecera').show();
	    });
	    file_frame2.open();
	});


	var file_frame3;
	$('.additional-trabajo-image').on('click', function(event) {
	    event.preventDefault();
	    if (file_frame3) {
	        file_frame3.open();
	        return;
	    }
	    file_frame3 = wp.media.frames.file_frame = wp.media({
	        title: $(this).data('uploader_title'),
	        button: {
	            text: $(this).data('uploader_button_text'),
	        },
	        multiple: false
	    });
	    file_frame3.on('select', function() {
	        attachment = file_frame3.state().get('selection').first().toJSON();
	        $('#logo_trabajo').val(attachment.url);
	        $('#mostrar_imagen_trabajo').attr("src", attachment.url);
	        $('#mostrar_imagen_trabajo').show();
	    });
	    file_frame3.open();
	});


});


/*function ocultar_campos() {
	var roles = ["miembro", "coordinador", "asesor", "author", "ponente"];
	var roles_selected = [];
	jQuery('div#informacion_perfiles input[type="checkbox"]:checked').each(function() {
		roles_selected.push(jQuery(this).val());
	}); 

	if (roles_selected.length > 0) {
		for (var i = 0 ; i < roles_selected.length; i++) {
			var role_selected = roles_selected[i];
			if (jQuery.inArray(role_selected, roles) !== -1) {
				jQuery("table.form-table tbody").first().children().each(function() {
					jQuery(this).hide();
				});
				jQuery('input#send_user_notification').attr('checked', false);
				if (role_selected == "author") {
					jQuery("#informacion_personal").show();	
					jQuery("#información_acerca_de").hide();	
					jQuery("#informacion_trabajo").hide();	
					jQuery("#informacion_expertise").hide();	
					jQuery("#informacion_contacto").hide();	
					jQuery("#informacion_cabecera").hide();	
				}
			} else {
				jQuery("table.form-table tbody").first().children().show();
			}
		}
	}
}*/

