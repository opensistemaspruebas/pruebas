/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function($){

    // Validación de campos que tengan la clase required
    jQuery("#post").validate({
        rules: {
            "meta-autor-nombre": {
                required: true
            },
            "meta-autor-estudios": {
                required: true
            },
            "tipo-perfil[]": {
              required: true
            }
        },
        messages: {
            "meta-autor-nombre": {
                required: "Campo obligatorio"
            },
            "meta-autor-estudios": {
                required: "Campo obligatorio"
            }
        }
      });

    jQuery('#detalles').hide();
    jQuery('#detalles-asesor').hide();

    if(jQuery('#tipo-perfil\\[consejero\\]').is(':checked') || jQuery('#tipo-perfil\\[coordinador\\]').is(':checked')) {
      jQuery('#detalles').show();
    }

    if(jQuery('#tipo-perfil\\[asesor\\]').is(':checked')) {
      jQuery('#detalles-asesor').show();
    }    

    jQuery("input#upload_foto_asesor").click(function(e) {
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
            library: { type: 'image' },
        });
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery('input#asesor-foto-perfil').val(attachment.url);
            jQuery('img#show_foto_asesor').attr("src", attachment.url);
            jQuery('img#show_foto_asesor').show();
        });
        custom_uploader.open();
    });

    jQuery("input#upload_foto").click(function(e) {
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
            library: { type: 'image' },
        });
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery('input#foto-perfil').val(attachment.url);
            jQuery('img#show_foto').attr("src", attachment.url);
            jQuery('img#show_foto').show();
        });
        custom_uploader.open();
    });

    jQuery("input#upload_logo").click(function(e) {
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
            library: { type: 'image' },
        });
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery('input#logo-trabajo').val(attachment.url);
            jQuery('img#show_logo').attr("src", attachment.url);
            jQuery('img#show_logo').show();
        });
        custom_uploader.open();
    });

    jQuery("input#upload_foto_grande").click(function(e) {
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
            library: { type: 'image' },
        });
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery('input#foto-grande').val(attachment.url);
            jQuery('img#show_foto_grande').attr("src", attachment.url);
            jQuery('img#show_foto_grande').show();
        });
        custom_uploader.open();
    });

});
