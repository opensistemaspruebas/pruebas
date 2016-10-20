jQuery(document).ready(function($) {

    $('#video-type-yt').on('click', function(e) {
        $('.video-youtube').show();
        $('.video-wordpress').hide();
    });

    $('#video-type-wp').on('click', function(e) {
        $('.video-wordpress').show();
        $('.video-youtube').hide();
    });

    if ($('input#ponencia').checked) {
        jQuery(this).parent().parent().children(":nth-child(5)").show();
        jQuery(this).parent().parent().children(":nth-child(6)").show();
        jQuery(this).parent().parent().children(":nth-child(7)").show();
    }


    if ($('input#descanso').checked) {
        jQuery(this).parent().parent().children(":nth-child(5)").hide();
        jQuery(this).parent().parent().children(":nth-child(6)").hide();
        jQuery(this).parent().parent().children(":nth-child(7)").hide();
    }

    $('input#ponencia').live('click', function(e) {
        jQuery(this).parent().parent().children(":nth-child(5)").show();
        jQuery(this).parent().parent().children(":nth-child(6)").show();
        jQuery(this).parent().parent().children(":nth-child(7)").show();
    });

    $('input#descanso').live('click', function(e) {
        jQuery(this).parent().parent().children(":nth-child(5)").hide();
        jQuery(this).parent().parent().children(":nth-child(6)").hide();
        jQuery(this).parent().parent().children(":nth-child(7)").hide();
    });

    count = 0;
    jQuery("#add-elemento-programa").click(function(e) {        
        count++;
        $('<div class="elementos_de_programa"><p class="radiobuttons"><input type="radio" name="evento_elemento_programa[' + count + '][tipo]" id="ponencia" value="ponencia" checked>Ponencia<br><input type="radio" name="evento_elemento_programa[' + count + '][tipo]" id="descanso" value="descanso">Descanso<br></p><p><label for="evento_elemento_programa[' + count + '][inicio]">Hora de inicio</label><input class="widefat" id="evento_elemento_programa[' + count + '][inicio]" name="evento_elemento_programa[' + count + '][inicio]" type="time" value=""><span class="description">(Formato: HH:MM)</span></p><p><label for="evento_elemento_programa[' + count + '][duracion]">Duración</label><input class="widefat" id="evento_elemento_programa[' + count + '][duracion]" name="evento_elemento_programa[' + count + '][duracion]" type="text" value=""><span class="description">(Por ejemplo: 15min)</span></p><p><label for="evento_elemento_programa[' + count + '][titulo]">Titulo</label><input class="widefat" id="evento_elemento_programa[' + count + '][titulo]" name="evento_elemento_programa[' + count + '][titulo]" type="text" value=""></p><p><label for="evento_elemento_programa[' + count + '][descripcion]">Descripción</label><textarea rows="1" cols="4' + count + '" maxlength="28' + count + '" name="evento_elemento_programa[' + count + '][descripcion]" id="evento_elemento_programa[' + count + '][descripcion]"></textarea></p><p><label for="evento_elemento_programa[' + count + '][ponentes]">Ponentes</label><select class="ponentes widefat" id="evento_elemento_programa[' + count + '][ponentes][]" name="evento_elemento_programa[' + count + '][ponentes][]" multiple="multiple"></select></p><p><label for="evento_elemento_programa[' + count + '][moderador]">Moderador</label><input class="widefat" id="evento_elemento_programa[' + count + '][moderador]" name="evento_elemento_programa[' + count + '][moderador]" type="text" value=""></p><button id="delete-elemento-programa" type="button">Eliminar este elemento</button></div>').insertBefore(this);
        $('select.ponentes').first().find('option').each(function() {
            valor = jQuery(this).val();
            name = jQuery(this).html();
            jQuery("select.ponentes").last().append('<option value="' + valor + '">' + name + '</option>');
        });
    });

    jQuery("#delete-elemento-programa").live("click", function(e) {
        jQuery(this).parent().remove();
    });

    $("input#upload_videoEvento").click(function(e) {
        e.preventDefault();
        var custom_uploader;
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: object_name.choose_source_logo,
            button: {
                text: object_name.choose_source_logo
            },
            multiple: false,
            library: { type: 'video' },
        });
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('input#wp-video-url').val(attachment.url);
        });
        custom_uploader.open();
    });

    $("input#upload_videoIntroEvento").click(function(e) {
        e.preventDefault();
        var custom_uploader;
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: object_name.choose_source_logo,
            button: {
                text: object_name.choose_source_logo
            },
            multiple: false,
            library: { type: 'video' },
        });
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('input#videoIntro-url').val(attachment.url);
        });
        custom_uploader.open();
    });

    $("#evento_imagen input#upload_evento_imagenCabecera").click(function(e) {
        e.preventDefault();
        var imagen_cabecera_file_frame;
        if (imagen_cabecera_file_frame) {
            imagen_cabecera_file_frame.open();
            return;
        }
        imagen_cabecera_file_frame = wp.media.frames.file_frame = wp.media({
            title: object_name.choose_source_logo,
            button: {
                text: object_name.choose_source_logo
            },
            multiple: false,
            library: { type: 'image' },
        });
        imagen_cabecera_file_frame.on('select', function() {
            var attachment = imagen_cabecera_file_frame.state().get('selection').first().toJSON();
            $('input#imagenCabecera').val(attachment.url);
            if(typeof(attachment.sizes.thumbnail) !== 'undefined') {
                $('img#show_imagenCabecera').attr("src", attachment.sizes.thumbnail.url);
            } else {
                $('img#show_imagenCabecera').attr("src", attachment.sizes.full.url);
            }
            $('img#show_imagenCabecera').show();
        });
        imagen_cabecera_file_frame.open();
    });

    $("#evento_imagen_card input#upload_evento_imagenCard").click(function(e) {
        e.preventDefault();
        var imagen_card_file_frame;
        if (imagen_card_file_frame) {
            imagen_card_file_frame.open();
            return;
        }
        imagen_card_file_frame = wp.media.frames.file_frame = wp.media({
            title: object_name.choose_source_logo,
            button: {
                text: object_name.choose_source_logo
            },
            multiple: false,
            library: { type: 'image' },
        });
        imagen_card_file_frame.on('select', function() {
            var attachment = imagen_card_file_frame.state().get('selection').first().toJSON();
            $('input#imagenCard').val(attachment.url);
            if(typeof(attachment.sizes.thumbnail) !== 'undefined') {
                $('img#show_imagenCard').attr("src", attachment.sizes.thumbnail.url);
            } else {
                $('img#show_imagenCard').attr("src", attachment.sizes.full.url);
            }
            $('img#show_imagenCard').show();
        });
        imagen_card_file_frame.open();
    });

    $("#evento_documento input#upload_evento_documento").click(function(e) {
        e.preventDefault();
        var pdf_file_frame;
        if (pdf_file_frame) {
            pdf_file_frame.open();
            return;
        }
        pdf_file_frame = wp.media.frames.file_frame = wp.media({
            title: object_name.choose_source_logo,
            button: {
                text: object_name.choose_source_logo
            },
            multiple: false,
            library: { type: 'application/pdf' },
        });
        pdf_file_frame.on('select', function() {
            var attachment = pdf_file_frame.state().get('selection').first().toJSON();
            $('input#evento_documento').val(attachment.url);
        });
        pdf_file_frame.open();
    });

    $("#evento_persona_de_contacto input#upload_evento_imagen_perfil").click(function(e) {
        e.preventDefault();
        var imagen_perfil_file_frame;
        if (imagen_perfil_file_frame) {
            imagen_perfil_file_frame.open();
            return;
        }
        imagen_perfil_file_frame = wp.media.frames.file_frame = wp.media({
            title: object_name.choose_source_logo,
            button: {
                text: object_name.choose_source_logo
            },
            multiple: false,
            library: { type: 'image' },
        });
        imagen_perfil_file_frame.on('select', function() {
            var attachment = imagen_perfil_file_frame.state().get('selection').first().toJSON();
            $('#evento_persona_de_contacto p:nth-child(6) input').val(attachment.url);
            if(typeof(attachment.sizes.thumbnail) !== 'undefined') {
                $('img#show_imagen_perfil').attr("src", attachment.sizes.thumbnail.url);
            } else {
                $('img#show_imagen_perfil').attr("src", attachment.sizes.full.url);
            }
            $('img#show_imagen_perfil').show();
        });
        imagen_perfil_file_frame.open();
    });

});