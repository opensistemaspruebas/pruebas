/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(document).ready(function($) {
    var custom_uploader_slider1;
    var custom_uploader_slider2;
    var custom_uploader_slider3;


    jQuery('input[name^="subir_imagen"]').click(function(e) {
        var id = jQuery(this).attr('name');
        var subid = id.substring('12', '13');

        e.preventDefault();
        var widget_id = jQuery(this).closest(".open").attr("id");

        if (subid == '1') {

            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader_slider1) {
                custom_uploader_slider1.open();
                return;
            }

            //Extend the wp.media object
            custom_uploader_slider1 = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader_slider1.on('select', function() {
                attachment = custom_uploader_slider1.state().get('selection').first().toJSON();
                jQuery("#" + widget_id + " .url_imagen" + subid).val(attachment.url);
            });

            //Open the uploader dialog
            custom_uploader_slider1.open();
        }
        if (subid == '2') {
            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader_slider2) {
                custom_uploader_slider2.open();
                return;
            }

            //Extend the wp.media object
            custom_uploader_slider2 = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader_slider2.on('select', function() {
                attachment = custom_uploader_slider2.state().get('selection').first().toJSON();
                jQuery("#" + widget_id + " .url_imagen" + subid).val(attachment.url);
            });

            //Open the uploader dialog
            custom_uploader_slider2.open();
        }
        if (subid == '3') {
            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader_slider3) {
                custom_uploader_slider3.open();
                return;
            }

            //Extend the wp.media object
            custom_uploader_slider3 = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader_slider3.on('select', function() {
                attachment = custom_uploader_slider3.state().get('selection').first().toJSON();
                jQuery("#" + widget_id + " .url_imagen" + subid).val(attachment.url);
            });

            //Open the uploader dialog
            custom_uploader_slider3.open();
        }
    });


    jQuery(".numero_items").change(function() {
        var widget_id = jQuery(this).closest(".open").attr("id");
        var numero_items = this.value;

        switch (numero_items) {
            case '1':
                jQuery("#" + widget_id + " .un_item").css("display", "block");
                jQuery("#" + widget_id + " .dos_items").css("display", "none");
                jQuery("#" + widget_id + " .tres_items").css("display", "none");

                jQuery("#" + widget_id + " .slider-tab1").css("display", "block");
                jQuery("#" + widget_id + " .slider-tab2").css("display", "none");
                jQuery("#" + widget_id + " .slider-tab3").css("display", "none");
                break;

            case '2':
                jQuery("#" + widget_id + " .dos_items").css("display", "block");
                jQuery("#" + widget_id + " .tres_items").css("display", "none");
                jQuery("#" + widget_id + " .un_item").css("display", "none");

                jQuery("#" + widget_id + " .slider-tab1").css("display", "block");
                jQuery("#" + widget_id + " .slider-tab2").css("display", "block");
                jQuery("#" + widget_id + " .slider-tab3").css("display", "none");
                break;

            case '3':
                jQuery("#" + widget_id + " .tres_items").css("display", "block");
                jQuery("#" + widget_id + " .un_item").css("display", "none");
                jQuery("#" + widget_id + " .dos_items").css("display", "none");

                jQuery("#" + widget_id + " .slider-tab1").css("display", "block");
                jQuery("#" + widget_id + " .slider-tab2").css("display", "block");
                jQuery("#" + widget_id + " .slider-tab3").css("display", "block");
                break;
        }

        var lang = jQuery(this).closest("div[data-lang]").attr('data-lang');

        if (lang == 'es') {
            cont_lang = 'en';
        } else {
            cont_lang = 'es';
        }

        jQuery('#' + widget_id + ' div[data-lang="' + cont_lang + '"] .valor-campo-slider_2 select').val(numero_items);
    });


    jQuery("[class ^='type_slider']").each(function() {
        var widget_id = jQuery(this).closest(".open").attr("id");
        switch (jQuery(this).val()) {

            case 'none':
                var b = jQuery(this).attr('class');
                var bloque = b.substring(11, 12);
                jQuery("#" + widget_id + " .campos_tipo1[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo2[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo3[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo4[id='" + bloque + "']").hide();
                break;

            case 'evento':
                var b = jQuery(this).attr('class');
                var bloque = b.substring(11, 12);
                jQuery("#" + widget_id + " .campos_tipo1[id='" + bloque + "']").show();
                jQuery("#" + widget_id + " .campos_tipo2[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo3[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo4[id='" + bloque + "']").hide();
                break;

            case 'testimonio':
                var b = jQuery(this).attr('class');
                var bloque = b.substring(11, 12);
                jQuery("#" + widget_id + " .campos_tipo1[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo2[id='" + bloque + "']").show();
                jQuery("#" + widget_id + " .campos_tipo3[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo4[id='" + bloque + "']").hide();
                break;

            case 'enviocv':
                var b = jQuery(this).attr('class');
                var bloque = b.substring(11, 12);
                jQuery("#" + widget_id + " .campos_tipo1[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo2[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo3[id='" + bloque + "']").show();
                jQuery("#" + widget_id + " .campos_tipo4[id='" + bloque + "']").hide();
                break;

            case 'acceso':
                var b = jQuery(this).attr('class');
                var bloque = b.substring(11, 12);
                jQuery("#" + widget_id + " .campos_tipo1[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo2[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo3[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo4[id='" + bloque + "']").show();
                break;
        }


    });


    jQuery("select[class ^='type_slider']").change(function() {
        var widget_id = jQuery(this).closest(".open").attr("id");
        var b = jQuery(this).attr('class');
        var bloque = b.substring(11, 12);
        var tipo_items = this.value;

        switch (tipo_items) {
            case 'none':
                jQuery("#" + widget_id + " .campos_tipo1[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo2[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo3[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo4[id='" + bloque + "']").hide();
                break;

            case 'evento':
                jQuery("#" + widget_id + " .campos_tipo1[id='" + bloque + "']").show();
                jQuery("#" + widget_id + " .campos_tipo2[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo3[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo4[id='" + bloque + "']").hide();
                break;

            case 'testimonio':
                jQuery("#" + widget_id + " .campos_tipo1[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo2[id='" + bloque + "']").show();
                jQuery("#" + widget_id + " .campos_tipo3[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo4[id='" + bloque + "']").hide();
                break;

            case 'enviocv':
                jQuery("#" + widget_id + " .campos_tipo1[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo2[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo3[id='" + bloque + "']").show();
                jQuery("#" + widget_id + " .campos_tipo4[id='" + bloque + "']").hide();
                break;

            case 'acceso':
                jQuery("#" + widget_id + " .campos_tipo1[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo2[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo3[id='" + bloque + "']").hide();
                jQuery("#" + widget_id + " .campos_tipo4[id='" + bloque + "']").show();
                break;
        }

    });

    jQuery('.tipo select').change(function(e) {
        e.preventDefault();
        var widget_id = jQuery(this).closest(".open").attr("id");
        var lang = jQuery(this).closest("div[data-lang]").attr('data-lang');
        var val = this.value;
        var b = jQuery(this).attr('class');
        var bloque = b.substring(11, 12);

        if (lang == 'es') {
            cont_lang = 'en';
        } else {
            cont_lang = 'es';
        }

        jQuery('#' + widget_id + ' div[data-lang="' + cont_lang + '"] div.slider-tab' + bloque + ' .tipo select').val(val);
    });

    jQuery('.eventos select').change(function(e) {
        e.preventDefault();
        var widget_id = jQuery(this).closest(".open").attr("id");
        var lang = jQuery(this).closest("div[data-lang]").attr('data-lang');
        var val = this.value;
        var bloque = jQuery(this).parent().parent().attr('id');
        if (lang == 'es') {
            cont_lang = 'en';
        } else {
            cont_lang = 'es';
        }

        jQuery('#' + widget_id + ' div[data-lang="' + cont_lang + '"] div.slider-tab' + bloque + ' .eventos select').val(val);
    });

    jQuery('.introductions select').change(function(e) {
        e.preventDefault();
        var widget_id = jQuery(this).closest(".open").attr("id");
        var lang = jQuery(this).closest("div[data-lang]").attr('data-lang');
        var val = this.value;
        var bloque = jQuery(this).parent().parent().attr('id');
        if (lang == 'es') {
            cont_lang = 'en';
        } else {
            cont_lang = 'es';
        }

        jQuery('#' + widget_id + ' div[data-lang="' + cont_lang + '"] div.slider-tab' + bloque + ' .introductions select').val(val);
    });

});
