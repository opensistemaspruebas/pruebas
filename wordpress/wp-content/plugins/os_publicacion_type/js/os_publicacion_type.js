/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function($) {

    jQuery("input#upload_imagenCabecera").click(function(e) {
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
            jQuery('input#imagenCabecera').val(attachment.url);
            jQuery('img#show_imagenCabecera').attr("src", attachment.sizes.thumbnail.url);
            jQuery('img#show_imagenCabecera').show();
        });
        custom_uploader.open();
    });

    jQuery("input#upload_logo").click(function(e) {
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
            jQuery('input#organization_logo').val(attachment.url);
            jQuery('img#show_logo').attr("src", attachment.sizes.thumbnail.url);
            jQuery('img#show_logo').show();
        });
        custom_uploader.open();
    });

    jQuery("input#upload_imagenCard").click(function(e) {
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
            jQuery('input#imagenCard').val(attachment.url);
            jQuery('img#show_imagenCard').attr("src", attachment.sizes.thumbnail.url);
            jQuery('img#show_imagenCard').show();
        });
        custom_uploader.open();
    });

    jQuery("input#upload_pdfInterno").click(function(e) {
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
            jQuery('input#pdfInterno').val(attachment.url);
        });
        custom_uploader.open();
    });

    $('#video-type-yt').on('click', function(e) {
        $('.video-youtube').show();
        $('.video-wordpress').hide();
    });

    $('#video-type-wp').on('click', function(e) {
        $('.video-wordpress').show();
        $('.video-youtube').hide();
    });

    $("input#upload_videoPublicacion").click(function(e) {
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

    $("input#upload_videoIntroPublicacion").click(function(e) {
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
            $('input#videoIntro-url').val(attachment.url);
        });
        custom_uploader.open();
    });


});