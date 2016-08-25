
<?php
/*Template Name: Single */
?>

<?php get_header(); ?>

    <main id="mainContent" class="template_pagFinal_col-12" data-role="content">
    <div class="wrapperFix">
        <div id="bloque_contenidoPrincipal">
            <article class="wrapperContent">
                <div class="colCompleta row">
                <div id="moduloContenido_introPagina" class="introBlanca">
                    <div class="wrapperContent">                                
                        <h1 class="pagina_titulo"><?php the_title(); ?></h1>    
                        <br>
                        <hr class="lineaCorta lineaGris">
                        <div class="pagina_texto">
                            <p></p>
                        </div>
                    </div>
                </div>
                <section id="moduloContenido_infoPagina">
                    <?php the_content(); ?>
                </section>
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