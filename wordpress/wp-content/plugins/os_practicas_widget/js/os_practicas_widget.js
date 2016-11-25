jQuery(document).ajaxComplete(function(event,jqXHR,ajaxOptions){

  var custom_uploaderPdfInterno;
  var custom_uploader1;
  var custom_uploader2;
  var custom_uploader3;

  if(typeof(ajaxOptions.data) !== 'undefined' && ajaxOptions.data.indexOf("action=so_panels_widget_form&widget=OSPracticasWidget") != -1) {

    jQuery("input#upload_image1").click(function(e) {
      e.preventDefault();
      e.stopPropagation();
      var widget_p1 = jQuery(this).closest('p').attr('class');
      //If the uploader object has already been created, reopen the dialog
      if (typeof(custom_uploader1) != 'undefined') {
          custom_uploader1.open();
          return;
      } else {
        //Extend the wp.media object
        custom_uploader1 = wp.media.frames.file_frame = wp.media({
            title: 'Selecciona Imagen 1',
            button: {
                text: 'Selecciona imagen 1'
            },
            multiple: false
        });

        //Open the uploader dialog
        custom_uploader1.open();
      }

       //When a file is selected, grab the URL and set it as the text field's value
       custom_uploader1.on('select', function() {
           attachment1 = custom_uploader1.state().get('selection').first().toJSON();
           jQuery('.' + widget_p1 + ' input.image-id1.os_image_widget-control1-target').val(attachment1.id);
           jQuery('.' + widget_p1 + ' img').attr('src',attachment1.url);
       });
   });


    jQuery("input#upload_image2").click(function(e) {
      e.preventDefault();
      e.stopPropagation();
      var widget_p2 = jQuery(this).closest('p').attr('class');
      //If the uploader object has already been created, reopen the dialog
      if (typeof(custom_uploader2) != 'undefined') {
          custom_uploader2.open();
          return;
      } else {
        //Extend the wp.media object
        custom_uploader2 = wp.media.frames.file_frame = wp.media({
            title: 'Selecciona Imagen 2',
            button: {
                text: 'Selecciona imagen 2'
            },
            multiple: false
        });

        //Open the uploader dialog
        custom_uploader2.open();
      }

       //When a file is selected, grab the URL and set it as the text field's value
       custom_uploader2.on('select', function() {
           attachment2 = custom_uploader2.state().get('selection').first().toJSON();
           jQuery('.' + widget_p2 + ' input.image-id2.os_image_widget-control2-target').val(attachment2.id);
           jQuery('.' + widget_p2 + ' img').attr('src',attachment2.url);
       });
   });



    jQuery("input#upload_image3").click(function(e) {
      e.preventDefault();
      e.stopPropagation();
      var widget_p3 = jQuery(this).closest('p').attr('class');
      //If the uploader object has already been created, reopen the dialog
      if (typeof(custom_uploader3) != 'undefined') {
          custom_uploader3.open();
          return;
      } else {
        //Extend the wp.media object
        custom_uploader3 = wp.media.frames.file_frame = wp.media({
            title: 'Selecciona Imagen 3',
            button: {
                text: 'Selecciona imagen 3'
            },
            multiple: false
        });

        //Open the uploader dialog
        custom_uploader3.open();
      }

       //When a file is selected, grab the URL and set it as the text field's value
       custom_uploader3.on('select', function() {
           attachment3 = custom_uploader3.state().get('selection').first().toJSON();
           jQuery('.' + widget_p3 + ' input.image-id3.os_image_widget-control3-target').val(attachment3.id);
           jQuery('.' + widget_p3 + ' img').attr('src',attachment3.url);
       });
    });


    jQuery("input#upload_pdfInterno").click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var widget_p4 = jQuery(this).closest('p').attr('class');

        if (typeof(custom_uploaderPdfInterno) != 'undefined') {
            custom_uploaderPdfInterno.open();
            return;
        } else {
          custom_uploaderPdfInterno = wp.media.frames.file_frame = wp.media({

              title: 'Selecciona Pdf Interno',
              button: {
                 text: 'Selecciona Pdf Interno'
              },
              multiple: false,
               library: { type: 'application/pdf' }
          });
          custom_uploaderPdfInterno.on('select', function() {
              var attachmentPdfInterno = custom_uploaderPdfInterno.state().get('selection').first().toJSON();
              jQuery('.' + widget_p4 + ' input.PdfInterno').attr('value', attachmentPdfInterno.url);
              jQuery('.' + widget_p4 + ' img').attr('src',attachmentPdfInterno.url);
          });
          custom_uploaderPdfInterno.open();
         }
    });

    /*jQuery("input#upload_pdfInterno").click(function(e) {
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
            library: { type: 'application/pdf' },
        });
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery('input#pdfInterno').attr('value', attachment.url);
        });
        custom_uploader.open();
    });*/

  }
});