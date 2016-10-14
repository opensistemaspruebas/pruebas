jQuery(document).ajaxComplete(function(event,jqXHR,ajaxOptions){

  if(typeof(loaded) == 'undefined') {
    var loaded = true;  
    jQuery("input.tipo_checkbox").click(function(e) {
      if(jQuery(this).val() == 'auto') {
        jQuery(this).parent().siblings('.miembro_destacado').hide()
      } else {
        jQuery(this).parent().siblings('.miembro_destacado').show()
      }
    });
  }

});