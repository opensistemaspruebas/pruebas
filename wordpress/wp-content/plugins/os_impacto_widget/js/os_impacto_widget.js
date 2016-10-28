jQuery(document).ajaxComplete(function(event,jqXHR,ajaxOptions){

  if(typeof(ajaxOptions.data) !== 'undefined' && ajaxOptions.data.indexOf("action=so_panels_widget_form&widget=os_impactos_widget") != -1) {
      
    jQuery("input.tipo_widget").click(function(e) {
        widget_class = jQuery(this).parent().parent().attr('class').split(' ')[0];

      if(jQuery(this).val() == 'widgetHome') {
        jQuery(this).parent().siblings('#url_home').show();
        jQuery('.barra').attr('checked',false);
        jQuery('.dato').attr('checked',false);
        jQuery('.barra').attr('disabled',true);
        jQuery('.dato').attr('disabled',true);
        jQuery('.circulo').attr('checked',true);
        jQuery('#impactosCirculo').show();
        jQuery('#impactosBarra').hide();
        jQuery('#impactosDato').hide();;

      } 
      else  if(jQuery(this).val() == 'widgetSubhomeIntroduccion') {
        jQuery(this).parent().siblings('#url_home').hide();
        jQuery('.barra').removeAttr("disabled");
        jQuery('.dato').removeAttr("disabled");

      } 
      else  if(jQuery(this).val() == 'widgetSubhomeSecundario') {
        jQuery(this).parent().siblings('#url_home').hide();
        jQuery('.barra').removeAttr("disabled");
        jQuery('.dato').removeAttr("disabled");

      }
    });

    jQuery("input.tipo_impactos").click(function(e) {
        widget_class = jQuery(this).parent().parent().attr('class').split(' ')[0];

      if(jQuery(this).val() == 'circulo') {
        jQuery('#impactosCirculo').show();
        jQuery('#impactosBarra').hide();
        jQuery('#impactosDato').hide();;

        
      } 
      else  if(jQuery(this).val() == 'barra') {
        jQuery('#impactosCirculo').hide();
        jQuery('#impactosBarra').show();
        jQuery('#impactosDato').hide();

      } 
      else  if(jQuery(this).val() == 'dato') {
        jQuery('#impactosCirculo').hide();
        jQuery('#impactosBarra').hide();
        jQuery('#impactosDato').show();

      }
    });

  }

});