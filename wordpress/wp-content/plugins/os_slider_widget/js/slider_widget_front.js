/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function($) {
    jQuery(".tab_boton").click(function() {

        var id = jQuery(this).attr('id');

        jQuery(".tabs_menuHorizontal li.active").removeClass("active");
        jQuery(".tab_box").css("display", "none");

        jQuery(".tabs_menuHorizontal [id='" + id + "']").addClass("active");
        jQuery(".tab_box[id='" + id + "']").css("display", "block");

        jQuery("[id='" + id + "']").fadeIn();
    });

});
