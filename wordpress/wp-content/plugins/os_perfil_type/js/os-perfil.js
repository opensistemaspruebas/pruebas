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
            "meta-autor-cargo": {
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
            "meta-autor-cargo": {
                required: "Campo obligatorio"
            },
            "tipo-perfil[]": {
                required: "Campo obligatorio"  
            }
        }
      });

    /** CONTROL DETALLES A MOSTRAR **/
    jQuery('#postdivrich').hide();
    jQuery('#detalles').hide();
    jQuery('#detalles-miembro').hide();

    if(jQuery('#tipo-perfil\\[asesor\\]').is(':checked') || jQuery('#tipo-perfil\\[coordinador\\]').is(':checked')) {
      jQuery('#postdivrich').show();
      jQuery('#detalles-miembro').show();
      jQuery('#detalles').show();
    }

    if(jQuery('#tipo-perfil\\[miembro\\]').is(':checked') || jQuery('#tipo-perfil\\[speaker\\]').is(':checked')) {
      jQuery('#detalles-miembro').show();
    }

    jQuery('#tipo-perfil\\[asesor\\], #tipo-perfil\\[coordinador\\]').on('change',function() {
        if(jQuery(this).is(':checked')) {
            jQuery('#postdivrich').show();
            jQuery('#detalles-miembro').show();
            jQuery('#detalles').show();
        }
    });

    jQuery('#tipo-perfil\\[miembro\\], #tipo-perfil\\[speaker\\]').on('change',function() {
        if(jQuery(this).is(':checked')) {
            jQuery('#detalles').hide();
            jQuery('#detalles-miembro').show();
            jQuery('#postdivrich').show();
        }
    });

    jQuery('#tipo-perfil\\[no-perfil\\]').on('change',function() {
        if(jQuery(this).is(':checked')) {
            jQuery('#postdivrich').hide();
            jQuery('#detalles').hide();
            jQuery('#detalles-miembro').hide();            
        }
    });
    /** FIN CONTROL DETALLES A MOSTRAR **/    


    /** UPLOADERS DE ARCHIVOS MULTIMEDIA **/
    jQuery("input#upload_foto_miembro").click(function(e) {
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
            jQuery('input#miembro-foto-perfil').val(attachment.url);
            jQuery('img#show_foto_miembro').attr("src", attachment.url);
            jQuery('img#show_foto_miembro').show();
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

    jQuery("input#upload_logo_emp").click(function(e) {
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
            jQuery('img#show_logo_emp').attr("src", attachment.url);
            jQuery('img#show_logo_emp').show();
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
    /** FIN UPLOADERS ARCHIVOS MULTIMEDIA **/


    /** MANEJO DE OTROS TRABAJOS **/
    var count = 0;
    jQuery(".delete-adv").click(function(e) {
        e.preventDefault();

    var myClass = jQuery(this).attr("class").split(/\s+/);
        jQuery("."+myClass[0]).remove();
    });

    jQuery("#add-otros-trabajos").click(function(e) {        
        count++;
        //$('<p class="otros-trabajos"><button id="delete-otros-trabajos" type="button">-</button><label for="otros-trabajos[' + count + '][titulo]">' + titulo + '</label><input type="text" name="otros-trabajos[' + count + '][titulo]" value="" /><label for="otros-trabajos[' + count + '][texto]">' + texto + '</label><input type="text" name="otros-trabajos[' + count + '][texto]" value="" /><label for="otros-trabajos[' + count + '][enlace]">' + enlace + '</label><input type="tel" name="otros-trabajos[' + count + '][enlace]" value="" /></p>').insertBefore(this);
        $('<div class="otros-trabajos"><div><label for="otros-trabajos[' + count + '][titulo]" class="autor-row-title">Título</label><input type="text" name="otros-trabajos[' + count + '][titulo]" id="otros-trabajos[' + count + '][titulo]" value=""/></div><div><label class="top" for="otros-trabajos[' + count + '][texto]">Texto</label><textarea id="otros-trabajos[' + count + '][texto]" name="otros-trabajos[' + count + '][texto]"></textarea></div><div><label for="otros-trabajos[' + count + '][enlace]" class="autor-row-title">Enlace</label><input type="text" name="otros-trabajos[' + count + '][enlace]" id="otros-trabajos[' + count + '][enlace]" value=""/></div><span class="alignright adv"><a id="delete-otros-trabajos" href="javascript:void(0);">Borrar</a></span></div>').insertBefore(this.parentElement);
    });

    jQuery("#delete-otros-trabajos").live("click", function(e) {
            jQuery(this).parent().parent().remove();
            count--;
    });
    /** FIN MANEJO DE OTROS TRABAJOS **/

});
