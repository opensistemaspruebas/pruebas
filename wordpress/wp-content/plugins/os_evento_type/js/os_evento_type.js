jQuery(document).ready(function($) {

    $('#video-type-yt').on('click', function(e) {
        $('.video-youtube').show();
        $('.video-wordpress').hide();
    });

    $('#video-type-wp').on('click', function(e) {
        $('.video-wordpress').show();
        $('.video-youtube').hide();
    });

    $("#evento_video input#upload_evento_videoEvento").click(function(e) {
        e.preventDefault();
        var video_file_frame;
        if (video_file_frame) {
            video_file_frame.open();
            return;
        }
        video_file_frame = wp.media.frames.file_frame = wp.media({
            title: object_name.choose_source_logo,
            button: {
                text: object_name.choose_source_logo
            },
            multiple: false,
            library: { type: 'video' },
        });
        video_file_frame.on('select', function() {
            var attachment = video_file_frame.state().get('selection').first().toJSON();
            $('input#wp-video-url').val(attachment.url);
        });
        video_file_frame.open();
    });

    $("#evento_imagen input#upload_evento_imagenCabecera").click(function(e) {
        e.preventDefault();
        var imagen_cabecera_file_frame;
        if (imagen_cabecera_file_frame) {
            imagen_cabecera_file_frame.open();
            return;
        }
        imagen_cabecera_file_frame = wp.media.frames.file_frame = wp.media({
            title: object_name.choose_source_logo,
            button: {
                text: object_name.choose_source_logo
            },
            multiple: false,
            library: { type: 'image' },
        });
        imagen_cabecera_file_frame.on('select', function() {
            var attachment = imagen_cabecera_file_frame.state().get('selection').first().toJSON();
            $('input#imagenCabecera').val(attachment.url);
            if(typeof(attachment.sizes.thumbnail) !== 'undefined') {
                $('img#show_imagenCabecera').attr("src", attachment.sizes.thumbnail.url);
            } else {
                $('img#show_imagenCabecera').attr("src", attachment.sizes.full.url);
            }
            $('img#show_imagenCabecera').show();
        });
        imagen_cabecera_file_frame.open();
    });

    $("#evento_imagen_card input#upload_evento_imagenCard").click(function(e) {
        e.preventDefault();
        var imagen_card_file_frame;
        if (imagen_card_file_frame) {
            imagen_card_file_frame.open();
            return;
        }
        imagen_card_file_frame = wp.media.frames.file_frame = wp.media({
            title: object_name.choose_source_logo,
            button: {
                text: object_name.choose_source_logo
            },
            multiple: false,
            library: { type: 'image' },
        });
        imagen_card_file_frame.on('select', function() {
            var attachment = imagen_card_file_frame.state().get('selection').first().toJSON();
            $('input#imagenCard').val(attachment.url);
            if(typeof(attachment.sizes.thumbnail) !== 'undefined') {
                $('img#show_imagenCard').attr("src", attachment.sizes.thumbnail.url);
            } else {
                $('img#show_imagenCard').attr("src", attachment.sizes.full.url);
            }
            $('img#show_imagenCard').show();
        });
        imagen_card_file_frame.open();
    });

    $("#evento_documento input#upload_evento_documento").click(function(e) {
        e.preventDefault();
        var pdf_file_frame;
        if (pdf_file_frame) {
            pdf_file_frame.open();
            return;
        }
        pdf_file_frame = wp.media.frames.file_frame = wp.media({
            title: object_name.choose_source_logo,
            button: {
                text: object_name.choose_source_logo
            },
            multiple: false,
            library: { type: 'application/pdf' },
        });
        pdf_file_frame.on('select', function() {
            var attachment = pdf_file_frame.state().get('selection').first().toJSON();
            $('input#evento_documento').val(attachment.url);
        });
        pdf_file_frame.open();
    });

});