jQuery(document).ready(function($) {

	//jQuery("select#role").parent().parent().parent().parent().before("<h2>Seleccione perfiles</h2>");
	
	//ocultar_campos();
	
	jQuery('input.permissions').click(function(e) {
		ocultar_campos();
	});


	var count = 0;

	jQuery("#add-trabajo").click(function(e) {        
		count++;
		$('<div style="border: 3px solid white;padding: 5px;margin-bottom: 10px;"><table class="form-table"><tbody><tr><th><label for="trabajos[' + count + '][titulo]">Trabajo relacionado</label></th><td><input type="text" name="trabajos[' + count + '][titulo]" id="trabajos[' + count + '][titulo]" value="" class="regular-text"><br></td></tr><tr><th><label for="trabajos[' + count + '][texto]">Descripción</label></th><td><textarea id="trabajo_texto[' + count + ']" name="trabajos[' + count + '][texto]" rows="5" cols="40"></textarea></td></tr><tr><th><label for="trabajos[' + count + '][enlace]">Enlace al trabajo</label></th><td><input type="url" name="trabajos[' + count + '][enlace]" id="trabajos[' + count + '][enlace]" value="" class="regular-text"></td></tr></tbody></table><button id="delete-trabajo" type="button">Eliminar este trabajo</button></div>').insertBefore(this);
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
	        $('#imagen_perfil').attr("value", attachment.url);
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
	        $('#imagen_cabecera').attr("value", attachment.url);
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
	        $('#logo_trabajo').attr("value", attachment.url);
	        $('#mostrar_imagen_trabajo').attr("src", attachment.url);
	        $('#mostrar_imagen_trabajo').show();
	    });
	    file_frame3.open();
	});


});


function ocultar_campos() {

	// Ocultar campos de WordPress
	/*jQuery(".user-description-wrap").parent().parent().prev().remove();
	jQuery(".user-description-wrap").parent().parent().remove();
	jQuery(".user-rich-editing-wrap").parent().parent().prev().remove();
	jQuery(".user-rich-editing-wrap").parent().parent().remove();*/

	var roles = ["asesor", "ponente", "miembro", "coordinador", "author"];

	var roles_seleccionados = jQuery('select#role').val();

	jQuery("input.permissions:checked").each(function() {
		
		var rol_seleccionado = jQuery(this).val();
	
		if (jQuery.inArray(rol_seleccionado, roles) !== -1) {

			jQuery("tr#password").parent().parent().prev().hide();
			jQuery("tr#password").parent().parent().hide();


			jQuery("input#send_user_notification").attr("checked", false);
			jQuery(".campo_personalizado").show();
			
			jQuery("input#user_login").parent().parent().hide();
			jQuery("input#email").parent().parent().hide();
			jQuery("input#first_name").parent().parent().hide();
			jQuery("input#last_name").parent().parent().hide();
			jQuery("input#url").parent().parent().hide();
			jQuery("button.button.button-secondary.wp-generate-pw.hide-if-no-js").parent().parent().hide();
			jQuery("input#send_user_notification").parent().parent().parent().hide();

		} else {
			
			jQuery("tr#password").parent().parent().prev().show();
			jQuery("tr#password").parent().parent().show();
			
			jQuery(".campo_personalizado").hide();
			jQuery("input#user_login").parent().parent().parent().parent().show();
		}

	});


}