jQuery(document).ajaxComplete(function(event,jqXHR,ajaxOptions){
  var previous1;
  var previous2;

  if(typeof(ajaxOptions.data) !== 'undefined' && ajaxOptions.data.indexOf("action=so_panels_widget_form&widget=OSGrupoAutoresWidget") != -1) {
      
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

    
    jQuery('.destacado_asesor-1 select').on('focus click', function() {
      previous1 = this.value;
      previous2 = jQuery('.destacado_asesor-2 select').value;
    });

    jQuery('.destacado_asesor-1 select').on('change', function() {
      var id = this.value;
      if(previous1 != "" && previous1 != previous2) {
        jQuery(this).parent().parent().siblings('.miembros_asesores').find('input[value='+previous1+']').removeAttr("disabled");
      }
      jQuery(this).parent().parent().siblings('.miembros_asesores').find('input[value='+id+']').attr('checked',false);
      jQuery(this).parent().parent().siblings('.miembros_asesores').find('input[value='+id+']').attr('disabled',true);
    });

    jQuery('.destacado_asesor-2 select').on('focus click', function() {
      previous2 = this.value;
      previous1 = jQuery('.destacado_asesor-1 select').value;
    });

    jQuery('.destacado_asesor-2 select').on('change', function() {
      var id = this.value;
      if(previous2 != "" && previous2 != previous1) {
        jQuery(this).parent().parent().siblings('.miembros_asesores').find('input[value='+previous2+']').removeAttr("disabled");
      }
      jQuery(this).parent().parent().siblings('.miembros_asesores').find('input[value='+id+']').attr('checked',false);
      jQuery(this).parent().parent().siblings('.miembros_asesores').find('input[value='+id+']').attr('disabled',true);
    });
  }

});