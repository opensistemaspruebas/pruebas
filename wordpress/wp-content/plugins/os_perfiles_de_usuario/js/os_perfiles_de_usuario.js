jQuery(document).ready(function($) {
	
	jQuery("#taxonomy-perfil input").each(function() {
		perfil = jQuery.trim(jQuery(this).parent().text());
		if (jQuery(this).is(':checked') && (perfil == "Ponente")) {
			 jQuery('#taxonomy-perfil input').each(function(index, value) {
				perfil_aux = jQuery.trim(jQuery(this).parent().text());
				if (perfil_aux !== perfil && (perfil_aux !== 'Asesor')) {
					jQuery(this).attr('checked', false);
					jQuery(this).attr('disabled', true);
				}
			});
			return false;
		} else if (jQuery(this).is(':checked') && perfil == "Asesor") {
			jQuery('#taxonomy-perfil input').each(function(index, value) {
				perfil_aux = jQuery.trim(jQuery(this).parent().text());
				if (perfil_aux !== 'Ponente' && perfil_aux !== 'Autor' && perfil_aux !== 'Coordinador' && perfil_aux !== perfil) {
					jQuery(this).attr('checked', false);
					jQuery(this).attr('disabled', true);
				}
			});
		} else if (jQuery(this).is(':checked') && perfil == "Autor") {
			jQuery('#taxonomy-perfil input').each(function(index, value) {
				perfil_aux = jQuery.trim(jQuery(this).parent().text());
				if (perfil_aux !== 'Asesor' && perfil_aux !== 'Coordinador' && perfil_aux !== perfil) {
					jQuery(this).attr('checked', false);
					jQuery(this).attr('disabled', true);
				}
			});
		} else if (jQuery(this).is(':checked') && perfil == "Coordinador") {
			jQuery('#taxonomy-perfil input').each(function(index, value) {
				perfil_aux = jQuery.trim(jQuery(this).parent().text());
				if (perfil_aux !== 'Asesor' && perfil_aux !== 'Autor' && perfil_aux !== perfil) {
					jQuery(this).attr('checked', false);
					jQuery(this).attr('disabled', true);
				}
			});
		} else if (jQuery(this).is(':checked') && (perfil == "Miembro")) {
			 jQuery('#taxonomy-perfil input').each(function(index, value) {
				perfil_aux = jQuery.trim(jQuery(this).parent().text());
				if (perfil_aux !== perfil) {
					jQuery(this).attr('checked', false);
					jQuery(this).attr('disabled', true);
				}
			});
		} else {
			var desmarcar = true;
			jQuery('#taxonomy-perfil input').each(function(index, value) {
				perfil_aux = jQuery.trim(jQuery(this).parent().text());
				if (perfil_aux == "Ponente" || perfil_aux == "Autor" || perfil_aux == "Asesor" || perfil_aux == "Coordinador") {
					if (jQuery(this).is(":checked")) {
						desmarcar = false;
						return;
					}
				}
			});
			if(desmarcar)
				jQuery("#taxonomy-perfil input").removeAttr('disabled');
		}
	});
	jQuery(".campo_personalizado").hide();
	ocultar_campos();
	cambia_tipo(jQuery('input[name=tipo]:checked').val());
	
	jQuery("#taxonomy-perfil input").change(function(e) {
		perfil = jQuery.trim(jQuery(this).parent().text());
		if (jQuery(this).is(':checked') && (perfil == "Ponente")) {
			 jQuery('#taxonomy-perfil input').each(function(index, value) {
				perfil_aux = jQuery.trim(jQuery(this).parent().text());
				if (perfil_aux !== perfil && (perfil_aux !== 'Asesor')) {
					jQuery(this).attr('checked', false);
					jQuery(this).attr('disabled', true);
				}
			});
			return false;
		} else if (jQuery(this).is(':checked') && perfil == "Asesor") {
			jQuery('#taxonomy-perfil input').each(function(index, value) {
				perfil_aux = jQuery.trim(jQuery(this).parent().text());
				if (perfil_aux !== 'Ponente' && perfil_aux !== 'Autor' && perfil_aux !== 'Coordinador' && perfil_aux !== perfil) {
					jQuery(this).attr('checked', false);
					jQuery(this).attr('disabled', true);
				}
			});
		} else if (jQuery(this).is(':checked') && perfil == "Autor") {
			jQuery('#taxonomy-perfil input').each(function(index, value) {
				perfil_aux = jQuery.trim(jQuery(this).parent().text());
				if (perfil_aux !== 'Asesor' && perfil_aux !== 'Coordinador' && perfil_aux !== perfil) {
					jQuery(this).attr('checked', false);
					jQuery(this).attr('disabled', true);
				}
			});
		} else if (jQuery(this).is(':checked') && perfil == "Coordinador") {
			jQuery('#taxonomy-perfil input').each(function(index, value) {
				perfil_aux = jQuery.trim(jQuery(this).parent().text());
				if (perfil_aux !== 'Asesor' && perfil_aux !== 'Autor' && perfil_aux !== perfil) {
					jQuery(this).attr('checked', false);
					jQuery(this).attr('disabled', true);
				}
			});
		} else if (jQuery(this).is(':checked') && (perfil == "Miembro")) {
			 jQuery('#taxonomy-perfil input').each(function(index, value) {
				perfil_aux = jQuery.trim(jQuery(this).parent().text());
				if (perfil_aux !== perfil) {
					jQuery(this).attr('checked', false);
					jQuery(this).attr('disabled', true);
				}
			});
		} else {
			var desmarcar = true;
			jQuery('#taxonomy-perfil input').each(function(index, value) {
				perfil_aux = jQuery.trim(jQuery(this).parent().text());
				if (perfil_aux == "Ponente" || perfil_aux == "Autor" || perfil_aux == "Asesor" || perfil_aux == "Coordinador") {
					if (jQuery(this).is(":checked")) {
						desmarcar = false;
						//return;
					}
				}
			});
			if(desmarcar)
				jQuery("#taxonomy-perfil input").removeAttr('disabled');
		}
		jQuery(".campo_personalizado").hide();
		ocultar_campos();
		cambia_tipo(jQuery('input[name=tipo]:checked').val());
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
		// Añado en español e inglés
		$('<div class="campo_personalizado es" style="border: 1px solid #e5e5e5;padding: 5px;margin-bottom: 10px;"><table class="form-table"><tbody><tr><th><label for="trabajos-es[' + count + '][titulo]">Trabajo relacionado</label></th><td><input type="text" name="trabajos-es[' + count + '][titulo]" id="trabajos-es[' + count + '][titulo]" value="" class="regular-text"><br></td></tr><tr><th><label for="trabajos-es[' + count + '][texto]">Descripción</label></th><td><textarea id="trabajo_texto[' + count + ']" name="trabajos-es[' + count + '][texto]" rows="5" cols="40"></textarea></td></tr><tr><th><label for="trabajos-es[' + count + '][enlace]">Enlace al trabajo</label></th><td><input type="url" name="trabajos-es[' + count + '][enlace]" id="trabajos-es[' + count + '][enlace]" value="" class="regular-text"></td></tr></tbody></table><button id="delete-trabajo" type="button">Eliminar este trabajo</button></div>').insertBefore(jQuery(this).parent().parent().find('p'));
		$('<div class="campo_personalizado en" style="border: 1px solid #e5e5e5;padding: 5px;margin-bottom: 10px;"><table class="form-table"><tbody><tr><th><label for="trabajos-en[' + count + '][titulo]">Trabajo relacionado</label></th><td><input type="text" name="trabajos-en[' + count + '][titulo]" id="trabajos-en[' + count + '][titulo]" value="" class="regular-text"><br></td></tr><tr><th><label for="trabajos-en[' + count + '][texto]">Descripción</label></th><td><textarea id="trabajo_texto[' + count + ']" name="trabajos-en[' + count + '][texto]" rows="5" cols="40"></textarea></td></tr><tr><th><label for="trabajos-en[' + count + '][enlace]">Enlace al trabajo</label></th><td><input type="url" name="trabajos-en[' + count + '][enlace]" id="trabajos-en[' + count + '][enlace]" value="" class="regular-text"></td></tr></tbody></table><button id="delete-trabajo" type="button">Eliminar este trabajo</button></div>').insertBefore(jQuery(this).parent().parent().find('p'));
		lang = jQuery('.cambio-idioma a.selected').attr('id');
		if(lang == 'es') {
			jQuery('.es').show();
			jQuery('.en').hide();
		} else {
			jQuery('.en').show();
			jQuery('.es').hide();
		}
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


	$('input[name=tipo]').on('click', function() {
		tipo = jQuery(this).val();
		cambia_tipo(tipo);
	});

	jQuery('.cambio-idioma a').on('click',function() {
		lang = jQuery(this).attr('id');
		if(lang == 'es') {
			jQuery(this).addClass('selected');
			jQuery(this).parent().find('#en').removeClass('selected');
			jQuery('.es').show();
			jQuery('.en').hide();
		} else {
			jQuery(this).addClass('selected');
			jQuery(this).parent().find('#es').removeClass('selected');
			jQuery('.en').show();
			jQuery('.es').hide();
		}
	});


});

function cambia_tipo(tipo) {

	var marcadoSoloMiembroPonente = false;
	jQuery('#taxonomy-perfil input:checked').each(function(index, value) {
		perfil = jQuery.trim(jQuery(this).parent().text());
		if (perfil !== 'Miembro' && perfil !== 'Ponente' && perfil !== 'Autor') {
			marcadoSoloMiembroPonente = true;
			return;
		}
	});


	if (marcadoSoloMiembroPonente) {
		if (jQuery('input[name=' + tipo + ']').is(":checked")) {
			if (tipo == "maximos") {
				ocultar_campos();
			} else if (tipo == "minimos") {
				jQuery('div#informacion_contacto').show();
				jQuery('div#informacion_expertise, div#informacion_cabecera, div#informacion_trabajos_relacionados').hide();
			}
		} else {
			if (tipo == "maximos") {
				ocultar_campos();
			} else if (tipo == "minimos") {
				jQuery('div#informacion_contacto').show();
				jQuery('div#informacion_expertise, div#informacion_cabecera, div#informacion_trabajos_relacionados').hide();
			}
		}
	} else {
		jQuery('div#informacion_contacto').hide();
	}
}

function ocultar_campos() {
	if (jQuery("#perfilchecklist input:checked").size() !== 0) {
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
	} else {
		jQuery('div.campo_personalizado').hide();
	}

	jQuery('.campo_personalizado:hidden input[type=text]').val('');
	jQuery('.campo_personalizado:hidden input[type=url]').val('');
	jQuery('.campo_personalizado:hidden textarea').html('');
	jQuery('.campo_personalizado:hidden img').attr('src', '').hide();
	jQuery('div#informacion_trabajos_relacionados').children("p").children("div").remove();

	// Muestro los campos del idioma activo
	lang = jQuery('.cambio-idioma a.selected').attr('id');
	if(lang == 'es') {
		jQuery('.es').show();
		jQuery('.en').hide();
	} else {
		jQuery('.en').show();
		jQuery('.es').hide();
	}

}


(function($){
  $(document).ready(function() {
     $('.postbox .hndle').unbind('click.postboxes');
     $('.postbox .handlediv').remove();
     $('.postbox').removeClass('closed');
  });
})(jQuery);