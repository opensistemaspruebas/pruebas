jQuery(document).ajaxComplete(function(event,jqXHR,ajaxOptions){

  var custom_uploader;

  if(typeof(ajaxOptions.data) !== 'undefined' && ajaxOptions.data.indexOf("action=so_panels_widget_form&widget=OSImagenTituloWidget") != -1) {

    jQuery("input#upload_image").click(function(e) {
      e.preventDefault();
      e.stopPropagation();
      var widget_p = jQuery(this).closest('p').attr('class');
      //If the uploader object has already been created, reopen the dialog
      if (typeof(custom_uploader) != 'undefined') {
          custom_uploader.open();
          return;
      } else {
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Selecciona Imagen',
            button: {
                text: 'Selecciona imagen'
            },
            multiple: false
        });

        //Open the uploader dialog
        custom_uploader.open();
      }

       //When a file is selected, grab the URL and set it as the text field's value
       custom_uploader.on('select', function() {
           attachment = custom_uploader.state().get('selection').first().toJSON();
           jQuery('.' + widget_p + ' input.image-id.os_image_widget-control-target').val(attachment.id);
           jQuery('.' + widget_p + ' img').attr('src',attachment.url);
       });
   });
  }
});