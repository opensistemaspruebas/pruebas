jQuery(function($) {

    $("input#upload_imagenCabeceraPractica").click(function(e) {
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
            $('input#imagenCabeceraPractica').val(attachment.url);
            if(typeof(attachment.sizes.thumbnail) !== 'undefined') {
                $('img#show_imagenCabeceraPractica').attr("src", attachment.sizes.thumbnail.url);
            } else {
                $('img#show_imagenCabeceraPractica').attr("src", attachment.sizes.full.url);
            }
            $('img#show_imagenCabeceraPractica').show();
        });
        custom_uploader.open();
    });

    $("input#upload_imagenCardPractica").click(function(e) {
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
            $('input#imagenCardPractica').val(attachment.url);
            if(typeof(attachment.sizes.thumbnail) !== 'undefined') {
                $('img#show_imagenCardPractica').attr("src", attachment.sizes.thumbnail.url);
            } else {
                $('img#show_imagenCardPractica').attr("src", attachment.sizes.full.url);
            }
            $('img#show_imagenCardPractica').show();
        });
        custom_uploader.open();
    });

});
