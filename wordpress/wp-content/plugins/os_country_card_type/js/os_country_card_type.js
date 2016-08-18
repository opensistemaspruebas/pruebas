/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function($) {

  var count = 0;
  
  jQuery("input#upload_image").click(function(e) {
    e.preventDefault(); 
    var custom_uploader;
    if (custom_uploader) {
      custom_uploader.open();
      return;
    }
    custom_uploader = wp.media.frames.file_frame = wp.media({
        title: 'Choose Image',
        button: {
          text: 'Choose Image'
        },
        multiple: false
    });
    custom_uploader.on('select', function() {
       attachment = custom_uploader.state().get('selection').first().toJSON();
       jQuery('input#image').val(attachment.url);
    });
    custom_uploader.open();
  });
  
  jQuery("#add-office-information").click(function(e) {        
    var div = $(".office-information").last();
    var h2 = div.children("h2").html();
    var title = $("label[for='offices[0][title]']").html();
    var address = $("label[for='offices[0][address]']").html();
    var phone = $("label[for='offices[0][phone]']").html();
    var mail = $("label[for='offices[0][mail]']").html();
    var textExtra = $("label[for='offices[0][textExtra]']").html();
    count++;
    $('<div class="office-information"><h2>' + h2 + '</h2><button id="delete-office-information" type="button">-</button><p><label for="offices[' + count + '][title]">' + title + '</label><input type="text" name="offices[' + count + '][title]" value="" /><label for="offices[' + count + '][address]">' + address + '</label><input type="text" name="offices[' + count + '][address]" value="" /><label for="offices[' + count + '][phone]">' + phone + '</label><input type="tel" name="offices[' + count + '][phone]" value="" /><label for="offices[' + count + '][mail]">' + mail + '</label><input type="email" name="offices[' + count + '][mail]" value="" /><label for="offices[' + count + '][textExtra]">' + textExtra + '</label><input type="text" name="offices[' + count + '][textExtra]" value="" />  </p></div>').insertBefore(this);
  });

  jQuery("#delete-office-information").live("click", function(e) {
    jQuery(this).parent().remove();
  });

});