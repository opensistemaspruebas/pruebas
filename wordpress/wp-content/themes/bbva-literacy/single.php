<?php
/**
 * Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>
    
        <!-- Metas para el buscador. -->
        <?php echo get_search_meta_for_post($post); ?>
        <!-- ******************************************* -->

<<<<<<< HEAD
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
            <div class="colSec col-md-4">
               
            </div>
        </div>
     </div>
</main> 
=======
        <div id="primary" class="container">
            <div id="content" role="main">
>>>>>>> 340ab7d18f1ff739c88eab5e3ad99a9380507bc0

                <?php while ( have_posts() ) : the_post(); ?>

                    <nav id="nav-single">
                        <h3 class="assistive-text"><?php _e( 'Post navigation', 'twentyeleven' ); ?></h3>
                        <span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'twentyeleven' ) ); ?></span>
                        <span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></span>
                    </nav><!-- #nav-single -->

                    <?php get_template_part( 'content-single', get_post_format() ); ?>

                <?php endwhile; // end of the loop. ?>

            </div><!-- #content -->
        </div><!-- #primary -->
<?php get_footer(); ?>
