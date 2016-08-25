<?php
/*Template Name: Pagina Final - Columna 12 */
?>

<?php get_header(); ?>

  	<main id="mainContent" class="template_pagFinal_col-12" data-role="content">
    <div class="wrapperFix">
        <div id="bloque_contenidoPrincipal">
        	<article class="wrapperContent">
                <div class="colCompleta row">
                    <?php get_sidebar( 'grupoPpal_colCompleta' )?>
                </div>
            </article>
        </div>
        <div id="bloque_contenidoSecundario">
            <div class="colCompleta row">
                <?php get_sidebar( 'grupoSec_colCompleta' )?>
            </div>
        </div>
     </div>
</main> 

<?php get_footer(); ?>