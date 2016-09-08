<?php
/*Template Name: Pagina Intermedia - Cab Blanca - Columna 12 */
?>

<?php get_header(); ?>

<main id="mainContent" class="template_pagIntermedia" data-role="content">
    <div class="wrapperFull">
        <div id="bloque_introPagina">
         	<div class="colCompleta row">
            	 <aside class="aside_migasPan"><div class="wrapperContent">
                    <p class="pagina_migas"><?php the_breadcrumb(); ?></p>
                </div></aside>
                 <div class="moduloContenido_introPagina introBlanca"><div class="wrapperContent">
                    <h1 class="pagina_titulo"><?php the_title(); ?></h1>
                    <p class="pagina_texto"><?php the_excerpt(); ?></p>
                 </div> </div>
        	</div>
        </div>
        
        <div id="bloque_contenidoPrincipal">
            <div class="colCompleta col-md-12">
                <?php get_sidebar( 'grupoPpal_colCompleta' )?>
            </div>
        </div>
        
        <div id="bloque_contenidoSecundario">
            <div class="colCompleta col-md-12">
                <?php get_sidebar( 'grupoSec_colCompleta' )?>
            </div>
        </div>
     </div>
</main> 

<?php get_footer(); ?>