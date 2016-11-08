jQuery(document).ready(function($) {
	
	jQuery(".campo_personalizado").hide();
	ocultar_campos();
	
	jQuery("#taxonomy-perfil input").change(function(e) {
		
		jQuery("#taxonomy-perfil input").each(function(index, value) {
			perfil = jQuery.trim(jQuery(this).parent().text());
			if (perfil == "Asesor") {
				jQuery('#taxonomy-perfil input').each(function(index, value) {
					perfil_aux = jQuery.trim(jQuery(this).parent().text());
					if (perfil_aux !== 'Autor' && perfil_aux !== 'Coordinador' && perfil_aux !== perfil) {
						jQuery(this).attr('checked', false);
						jQuery(this).attr('disabled', true);
					}
				});
			} else if (perfil == "Autor") {
				jQuery('#taxonomy-perfil input').each(function(index, value) {
					perfil_aux = jQuery.trim(jQuery(this).parent().text());
					if (perfil_aux !== 'Asesor' && perfil_aux !== 'Coordinador' && perfil_aux !== perfil) {
						jQuery(this).attr('checked', false);
						jQuery(this).attr('disabled', true);
					}
				});
			} else if (perfil == "Coordinador") {
				jQuery('#taxonomy-perfil input').each(function(index, value) {
					perfil_aux = jQuery.trim(jQuery(this).parent().text());
					if (perfil_aux !== 'Asesor' && perfil_aux !== 'Autor' && perfil_aux !== perfil) {
						jQuery(this).attr('checked', false);
						jQuery(this).attr('disabled', true);
					}
				});
			} else if (perfil == "Ponente" || perfil == "Miembro") {
				 jQuery('#taxonomy-perfil input').each(function(index, value) {
					perfil_aux = jQuery.trim(jQuery(this).parent().text());
					if (perfil_aux !== perfil) {
						jQuery(this).attr('checked', false);
						jQuery(this).attr('disabled', true);
					}
				});
			} else {
				jQuery("#taxonomy-perfil input").attr('disabled', false);
			}
		});
		
		jQuery(".campo_personalizado").hide();
		ocultar_campos();
	
	});


    $('#publish').click(function(){
        if (jQuery("#perfilchecklist input:checked").length > 0) {
            return true;
        } else {
            alert('No se ha asignado ningún perfil');
            return false;
        }
    });


	var count = 0;

	jQuery("#add-trabajo").click(function(e) {        
		count++;
		$('<div style="border: 1px solid #e5e5e5;padding: 5px;margin-bottom: 10px;"><table class="form-table"><tbody><tr><th><label for="trabajos[' + count + '][titulo]">Trabajo relacionado</label></th><td><input type="text" name="trabajos[' + count + '][titulo]" id="trabajos[' + count + '][titulo]" value="" class="regular-text"><br></td></tr><tr><th><label for="trabajos[' + count + '][texto]">Descripción</label></th><td><textarea id="trabajo_texto[' + count + ']" name="trabajos[' + count + '][texto]" rows="5" cols="40"></textarea></td></tr><tr><th><label for="trabajos[' + count + '][enlace]">Enlace al trabajo</label></th><td><input type="url" name="trabajos[' + count + '][enlace]" id="trabajos[' + count + '][enlace]" value="" class="regular-text"></td></tr></tbody></table><button id="delete-trabajo" type="button">Eliminar este trabajo</button></div>').insertBefore(this);
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
	jQuery("#perfilchecklist input:checked").each(function() {
		perfil = jQuery(this);
		jQuery(".campo_personalizado").each(function() {
			var elem = perfil.attr("value");
			var clases = jQuery(this).attr("class").split(' ');
			if (clases.indexOf(elem) !== -1) {
				jQuery(this).show();
			}
		});
	});

	jQuery('.campo_personalizado:hidden input[type=text]').val('');
	jQuery('.campo_personalizado:hidden input[type=url]').val('');
	jQuery('.campo_personalizado:hidden textarea').html('');
	jQuery('.campo_personalizado:hidden img').attr('src', '').hide();
	jQuery('div#informacion_trabajos_relacionados').children("p").children("div").remove();

}


(function($){
  $(document).ready(function() {
     $('.postbox .hndle').unbind('click.postboxes');
     $('.postbox .handlediv').remove();
     $('.postbox').removeClass('closed');
  });
})(jQuery);