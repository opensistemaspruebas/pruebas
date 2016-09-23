/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function($) {
    var numWidgets = $('.council-members').length;
    // Por si hay varios widgets iguales en la misma página, hacemos lo mismo para todos los que haya
    if(numWidgets > 0) {
        for(var j = 0; j < numWidgets; j++) {
            var partnersID = [];
            var parentId = $('.council-members')[j].id;
            var partners = $('#' + parentId + ' img[data-target^=#modal-' + parentId +']');
            var numPartners = partners.length;
            var partnersToShow = (numPartners > 5) ? 5 : numPartners;

            // Mostramos partners aleatorios
            if(numPartners > 0) {
                var id = partners[0].id.split('_')[0];
                while(partnersID.length < partnersToShow){

                    var randomNumber = Math.ceil(Math.random()*numPartners)-1;
                    var found=false;

                    for(var i=0;i<partnersID.length;i++) {

                        if(partnersID[i]==randomNumber) {
                            found=true;break
                        }

                    }

                    if(!found) {

                        partnersID[partnersID.length] = randomNumber;

                    }

                }
            }

            for(var i = 0; i < partnersID.length; i++) {
                var parent = $('#' + parentId + ' img#' + id + '_' + partnersID[i]).parent();
                var imagen = $('#' + parentId + ' img#' + id + '_' + partnersID[i])[0];
                $('#' + parentId + ' img#' + id + '_' + partnersID[i]).remove();

                imagen.setAttribute("style","");
                $(imagen.outerHTML).appendTo(parent);
            }
        }
    }
});