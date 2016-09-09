<?php
/**
 * Template for displaying all single posts
 *
 */

get_header(); ?>
    
        <!-- Metas para el buscador. -->
        <?php echo get_search_meta_for_post($post); ?>
        <!-- ******************************************* -->

    	<main id="mainContent" class="template_single" data-role="content">
            <div class="wrapperFix">
                <div id="bloque_introPagina"> 
                    <div class="colCompleta col-md-12">
                        <div class="moduloContenido_introPagina_azul"><div class="wrapperContent">
                        	<div class="col-md-10">
                                <h1 class="pagina_titulo"><?php the_title(); ?></h1>
                                <p class="pagina_texto"><?php the_excerpt(); ?></p>
                            </div>
                            <div class="col-md-2">
                            	<i class="pagina_icono"></i>
                            </div>
                        </div></div>
                    </div>
                </div>
                <div id="bloque_contenidoPrincipal">
                    <div class="colPpal col-md-8">
                        <?php
        					while (have_posts()) : the_post();
                                the_content();
        					endwhile;
                        ?>
                    </div>
                    <div class="colSec col-md-4">
                       
                    </div>
                </div>
            </div>
        </main> 

<?php get_footer(); ?>
