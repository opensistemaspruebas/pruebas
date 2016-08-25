<?php
/*Template Name: Pagina Final - Columna 8-4 */
?>

<?php get_header(); ?>

<main id="mainContent" class="pagFinalDetalle" data-role="content">
    <div class="wrapperFluid">        
        <div id="bloque_introPagina">
            <div class="colCompleta row">
               <?php get_sidebar('grupoPpal_colIntro')?>
            </div>
        </div>        
        <div id="bloque_contenidoPrincipal">
            <article class="wrapperContent">
                <h1 class="hidden"><?php the_title(); ?></h1>
                <p class="hidden"><?php the_excerpt(); ?></p>
                <div class="colPpal col-md-8">
                  <?php get_sidebar('grupoPpal_colPrincipal')?>
                </div>
                <div class="colDcha col-md-4">
                    <?php get_sidebar('grupoPpal_colDerecha')?>
                </div>
            </article>
        </div>
    </div>
</main>

<?php get_footer(); ?>