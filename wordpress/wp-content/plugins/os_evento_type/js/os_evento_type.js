jQuery(document).ready(function($) {

    $('#video-type-yt').on('click', function(e) {
        $('.video-youtube').show();
        $('.video-wordpress').hide();
    });

    $('#video-type-wp').on('click', function(e) {
        $('.video-wordpress').show();
        $('.video-youtube').hide();
    });

    $("input#upload_videoEvento").click(function(e) {
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
            library: { type: 'video' },
        });
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('input#wp-video-url').val(attachment.url);
        });
        custom_uploader.open();
    });

    $("input#upload_imagenCabecera").click(function(e) {
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
            $('input#imagenCabecera').val(attachment.url);
            if(typeof(attachment.sizes.thumbnail) !== 'undefined') {
                $('img#show_imagenCabecera').attr("src", attachment.sizes.thumbnail.url);
            } else {
                $('img#show_imagenCabecera').attr("src", attachment.sizes.full.url);
            }
            $('img#show_imagenCabecera').show();
        });
        custom_uploader.open();
    });

    $("input#upload_imagenCard").click(function(e) {
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
            $('input#imagenCard').val(attachment.url);
            if(typeof(attachment.sizes.thumbnail) !== 'undefined') {
                $('img#show_imagenCard').attr("src", attachment.sizes.thumbnail.url);
            } else {
                $('img#show_imagenCard').attr("src", attachment.sizes.full.url);
            }
            $('img#show_imagenCard').show();
        });
        custom_uploader.open();
    });

});