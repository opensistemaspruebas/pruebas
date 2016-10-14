/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function($) {
    var numWidgets = $('.people-grid').length;
    // Por si hay varios widgets iguales en la misma página, hacemos lo mismo para todos los que haya
    if(numWidgets > 0) {
        for(var j = 0; j < numWidgets; j++) {
            var miembrosID = [];
            var parentId = $('.people-grid-wrapper.medium')[j].id;
            var miembros = $('#' + parentId + ' div.card-container[id^=' + parentId + ']');
            var numInicial = $('#' + parentId + ' #num_cards').html();
            var numPartners = miembros.length;
            var miembrosToShow = (numPartners > numInicial) ? numInicial : numPartners;

            // Mostramos miembros aleatorios
            if(numPartners > 0) {
                var id = miembros[0].id.split('_')[0];
                while(miembrosID.length < miembrosToShow){

                    var randomNumber = Math.ceil(Math.random()*numPartners)-1;
                    var found=false;

                    for(var i=0;i<miembrosID.length;i++) {

                        if(miembrosID[i]==randomNumber) {
                            found=true;break
                        }

                    }

                    if(!found) {

                        miembrosID[miembrosID.length] = randomNumber;

                    }

                }
            }

            for(var i = 0; i < miembrosID.length; i++) {
                var parent = $('#' + parentId + ' div.card-container#' + id + '_' + miembrosID[i]).parent();
                var imagen = $('#' + parentId + ' div.card-container#' + id + '_' + miembrosID[i])[0];
                $('#' + parentId + ' div.card-container#' + id + '_' + miembrosID[i]).remove();

                imagen.setAttribute("style","");
                $(imagen.outerHTML).appendTo(parent);
            }
        }
    }

    jQuery('.readmore').click(function() {
        var id_grupo = jQuery(this).attr('id');
        jQuery('#' + id_grupo + ' div.card-container[id^=' + id_grupo + ']').fadeIn();
    });
});