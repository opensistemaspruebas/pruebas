jQuery(document).ready(function() {

	jQuery("input#upload_imagen_fondo").live("click", function(e) {
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
            jQuery('input.imagen_fondo').attr("value", attachment.url);
            jQuery('img#show_imagen_fondo').attr("src", attachment.url);
            jQuery('img#show_imagen_fondo').show();
        });
        custom_uploader.open();
    });

});