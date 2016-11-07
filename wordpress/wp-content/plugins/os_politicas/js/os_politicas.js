var loadedOSPoliticas = false;

jQuery(document).ajaxComplete(function(event,jqXHR,ajaxOptions){


 if(typeof(ajaxOptions.data) !== 'undefined' && ajaxOptions.data.indexOf("action=so_panels_widget_form&widget=OSPoliticas") != -1 && loadedOSPoliticas == false) {

   loadedOSPoliticas = true;



    jQuery(document).on("click", "#add-texto_destacado", function(e) { 

        var count = jQuery(this).parent().parent().find('textarea.textoDestacado').length;
        count = count - 1;     
      
        textoDestacado = jQuery(this).parent().prev().html(); 

        id = jQuery(this).parent().prev().find('textarea').attr('id');
        posCorchete = id.lastIndexOf('[');
        idNuevo = id.substr(0,posCorchete);

        name = jQuery(this).parent().prev().find('textarea').attr('name');
        posCorchete = name.lastIndexOf('[');
        nameNuevo = name.substr(0,posCorchete);

        count++;
        jQuery('<div style="border: 1px solid #e5e5e5;padding: 5px;margin-bottom: 10px;"><p><label for="' + idNuevo + '[' + count + ']">Texto destacado:</label><textarea rows="4" class="widefat textoDestacado" id="' + idNuevo + '[' + count + ']" name="' + nameNuevo + '[' + count + ']" type="text"></textarea></p><button id="delete-texto_destacado" type="button">Eliminar este texto destacado</button></div>').insertBefore(this);
    });

    jQuery(document).on("click", "#delete-texto_destacado", function(e) {
        jQuery(this).parent().remove();
    });



    jQuery(document).on("click", "#add-texto", function(e) { 

        var count = jQuery(this).parent().parent().find('textarea.texto').length;
        count = count - 1;     
      
        texto = jQuery(this).parent().prev().html(); 

        id = jQuery(this).parent().prev().find('textarea').attr('id');
        posCorchete = id.lastIndexOf('[');
        idNuevo = id.substr(0,posCorchete);

        name = jQuery(this).parent().prev().find('textarea').attr('name');
        posCorchete = name.lastIndexOf('[');
        nameNuevo = name.substr(0,posCorchete);

        count++;
        jQuery('<div style="border: 1px solid #e5e5e5;padding: 5px;margin-bottom: 10px;"><p><label for="' + idNuevo + '[' + count + ']">Texto:</label><textarea rows="4" class="widefat texto" id="' + idNuevo + '[' + count + ']" name="' + nameNuevo + '[' + count + ']" type="text"></textarea></p><button id="delete-texto" type="button">Eliminar este texto</button></div>').insertBefore(this);
    });

    jQuery(document).on("click", "#delete-texto", function(e) {
        jQuery(this).parent().remove();
    });

}

});