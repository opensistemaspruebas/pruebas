jQuery(document).ajaxComplete(function(event,jqXHR,ajaxOptions){

  if(typeof(loaded) == 'undefined') {
    var loaded = true;  
    jQuery("input.tipo_checkbox").click(function(e) {
      if(jQuery(this).val() == 'consejo_asesor') {
        jQuery(this).parent().siblings('.asesores_destacados').show();
        jQuery(this).parent().siblings('.miembros_asesores').show();
        jQuery(this).parent().siblings('.coordinador_destacado').hide();
        jQuery(this).parent().siblings('.miembros_posibles').hide();
      } else {
        jQuery(this).parent().siblings('.coordinador_destacado').show();
        jQuery(this).parent().siblings('.miembros_posibles').show();
        jQuery(this).parent().siblings('.asesores_destacados').hide();
        jQuery(this).parent().siblings('.miembros_asesores').hide();
      }
    });
  }

});