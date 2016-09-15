<?php
/*Template Name: Post-type Partner */
?>

<?php get_header(); ?>
	<main id="mainContent" class="post_partner" data-role="content">
    <div class="wrapperFix">
        <div id="bloque_introPagina"> 
            <div class="colCompleta col-md-12">
                <div class="moduloContenido_introPagina_azul"><div class="wrapperContent">
                	<div class="col-md-10">
                        <p class="pagina_migas"><?php the_breadcrumb(); ?></p>
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
					// Start the Loop.
					while ( have_posts() ) : the_post();
	
						// Include the page content template.
						get_template_part( 'content', 'page' );
	
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
					endwhile;
				?>
            </div>
            <div class="colPpal col-md-4">
                <?php  get_sidebar()?>
            </div>
        </div>
     </div>
</main> 

<?php get_footer(); ?>