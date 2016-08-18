/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function($) {
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
});