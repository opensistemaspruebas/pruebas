<?php

/**
 *
 * Template Name: Página buenas prácticas
 * Template para mostrar una práctica
 *
 */

get_header(); ?>

<?php

    $title = get_the_title();
    $texto_destacado = get_post_meta(get_the_ID(), 'texto-destacado', true);
    $texto = get_post_meta(get_the_ID(), 'texto', true);
    $imagenCabecera = get_post_meta(get_the_ID(), 'imagenCabecera', true);
    $urlPractica = get_post_meta(get_the_ID(), 'urlPractica', true);
    $externo10 = get_post_meta(get_the_ID(), 'externo10', true);

    if(get_locale() == 'es_ES'){

        $date = get_the_date('l, j \d\e F \d\e Y');
    }
    else{

        $date = get_the_date('l, F j, Y');
    }



    $args = array(
        'post_type' => 'practica',
        'post__not_in' => array(get_the_ID()),
        'posts_per_page' => 3,
    );

    $query = new WP_Query($args);






    $pdf = get_post_meta(get_the_ID(), 'pdf', true);
    $pdfInterno = get_post_meta(get_the_ID(), 'pdfInterno', true);
    $publication_date = get_post_meta(get_the_ID(), 'publication_date', true);
    $time = strtotime($publication_date);
    $publication_date = date('d/m/Y',$time);
    $type = get_post_meta(get_the_ID(), 'type', true);
    $target_audiences = get_post_meta(get_the_ID(), 'target_audiences', true);
    $number_of_pages = get_post_meta(get_the_ID(), 'number_of_pages', true);
    $jel_code = get_post_meta(get_the_ID(), 'jel_code', true);
    $edition = get_post_meta(get_the_ID(), 'edition', true);
    $editorial = get_post_meta(get_the_ID(), 'editorial', true);
    $organization_name = get_post_meta(get_the_ID(), 'organization_name', true);
    $name_url = get_post_meta(get_the_ID(), 'name_url', true);
    $source_url = get_post_meta(get_the_ID(), 'source_url', true);
    $organization_url = get_post_meta(get_the_ID(), 'organization_url', true);
    $organization_logo = get_post_meta(get_the_ID(), 'organization_logo', true);
    $videoIntro_url = get_post_meta(get_the_ID(),'videoIntro-url',true);
    $videoFinal_type = get_post_meta(get_the_ID(),'video-type',true);
    $publicacion_puntosClave = get_post_meta(get_the_ID(), 'publicacion_puntosClave', true);



?>

<div class="contents">
    <div id="search-layer"></div>
    <article class="practice-detail">
        <div class="header-section">
            <div class="container">
                <header class="title-description">
                    <h1><?php echo $title; ?></h1>
                    <div class="description-container">
                        <p></p>
                    </div>
                </header>
                <div class="row visible-xs">
                    <div class="icon-section col-xs-6">
                        <?php if (false) : ?>
                        <div class="card-icon icon-publication ml-xs">
                            <span class="icon bbva-icon-quote2"></span>
                            <div class="triangle triangle-up-left"></div>
                            <div class="triangle triangle-down-right"></div>
                        </div>
                        <?php endif; ?>
                        <?php if (false) : ?>
                        <div class="card-icon icon-publication ml-xs">
                            <span class="icon bbva-icon-audio2"></span>
                            <div class="triangle triangle-up-left"></div>
                            <div class="triangle triangle-down-right"></div>
                        </div>
                        <?php endif; ?>
                        <?php if (false) : ?>
                        <div class="card-icon icon-publication ml-xs">
                            <span class="icon bbva-icon-chat2"></span>
                            <div class="triangle triangle-up-left"></div>
                            <div class="triangle triangle-down-right"></div>
                        </div>
                        <?php endif; ?>
                        <?php if ((false) || (false)) : ?>
                        <div class="card-icon">
                            <span class="icon bbva-icon-arrow-download"></span>
                            <div class="triangle triangle-up-left"></div>
                            <div class="triangle triangle-down-right"></div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php get_template_part('content','rrssmovil'); ?>
                </div>
                <div class="mb-xs hidden-xs icon-section-desktop">
                    <div class="icon-section">
                        <?php if (false) : ?>
                        <div class="card-icon ml-xs">
                            <span class="icon bbva-icon-quote2"></span>
                            <div class="triangle triangle-up-left"></div>
                            <div class="triangle triangle-down-right"></div>
                        </div>
                        <?php endif; ?>
                         <?php if (false) : ?>
                        <div class="card-icon ml-xs">
                            <span class="icon bbva-icon-audio2"></span>
                            <div class="triangle triangle-up-left"></div>
                            <div class="triangle triangle-down-right"></div>
                        </div>
                        <?php endif; ?>
                        <?php if (false) : ?>
                        <div class="card-icon ml-xs">
                            <span class="icon bbva-icon-chat2"></span>
                            <div class="triangle triangle-up-left"></div>
                            <div class="triangle triangle-down-right"></div>
                        </div>
                        <?php endif; ?>
                        <?php if ((false) || (false)) : ?>
                        <div class="card-icon ml-xs">
                            <span class="icon bbva-icon-arrow-download"></span>
                            <div class="triangle triangle-up-left"></div>
                            <div class="triangle triangle-down-right"></div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php get_template_part( 'content', 'rrss' ); ?>
                </div>
            </div>
            <div class="header-fixed-top hidden">
                <div class="container">
                    <div class="content">
                        <header class="title-description">
                            <h1><?php echo $title; ?></h1>
                            <div class="description-container">
                                <p></p>
                            </div>
                        </header>
                        <?php get_template_part('content','rrssmovil'); ?>
                    </div>
                </div>
                <progress value="0" id="progressBar">
                    <div class="progress-container"><span class="progress-bar"></span></div>
                </progress>
            </div>
        </div>
        <div class="image-section"><img src="<?php echo $imagenCabecera; ?>" alt="practice detail cover" /></div>
        <section class="content-section">
            <div class="container content-wrap">
                 <?php if (!empty($date)) : ?>
                <label class="mt-lg"><?php echo $date; ?></label>
                <?php endif; ?>
                <h1 class="mt-xs"><?php _e('Resumen'); ?></h1>
                <h2><?php echo $texto_destacado; ?></h2>
                <p><?php echo $texto; ?></p>
            </div>
            <div class="container content-wrap">
                <section class="pdf-rectangle">
                    <div class="row">
                        <div class="col-xs-12 col-sm-1"><span class="icon bbva-icon-publication-clip"></span></div>
                        <div class="col-xs-12 col-sm-7">
                            <h1 class="mt-md pt-sm ml-xs publication-access-title"><?php _e('Acceso a la publicación original'); ?></h1></div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="container-button mb-md mt-md text-right"><a <?php if($externo10 == 'on'){ echo 'target=_blank';} ?> href="<?php echo $urlPractica; ?>" class="btn btn-bbva-aqua"><?php _e('Ir a la web'); ?></a></div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
        <!-- latests-posts -->
        <?php if ($query->have_posts()) { ?>
        <section class="latests-posts pt-xl pb-lg">
            <div class="container">
                <header class="title-description">
                    <h1><?php _e('Otras mejores prácticas', 'os_practica_type'); ?></h1>
                    <div class="description-container">
                        <p></p>
                    </div>
                </header>
                <div class="card-container nopadding container-fluid mt-md mb-md">
                    <div class="row">
                     <?php
                            while ($query->have_posts()) {

                                $query->the_post();
                                $date = get_the_date('j F Y');
                                $abstract_destacado = substr(get_post_meta($post->ID, 'texto-destacado', true), 0, 140) . '...';
                                $abstract_contenido = get_post_meta(get_the_ID(), 'texto', true);
                                $imagen = get_post_meta($post->ID, 'imagenCard', true);
                        ?>
                        <div class="main-card-container col-xs-12 col-sm-4 noppading">
                            <!-- main-card -->
                            <section class="container-fluid main-card">
                                <header class="row header-container">
                                    <div class="image-container col-xs-12">
                                        <a href="<?php the_permalink(); ?>" class="link-header-layer visible-xs">
                                            <img src="<?php echo $imagen; ?>" alt="" />
                                        </a>
                                        <img src="<?php echo $imagen; ?>" alt="" class="hidden-xs  wow fadeInUp " /></div>
                                    <div class="hidden-xs floating-text col-xs-11">
                                        <p class="date"><?php echo $date; ?></p>
                                        <h1><?php the_title(); ?></h1></div>
                                </header>
                                <div class="row data-container">
                                    <a href="<?php the_permalink(); ?>" class="link-layer visible-xs"></a>
                                    <div class="nopadding date"><?php echo $date; ?></div>
                                    <div class="main-card-data-container-title-wrapper">
                                        <h1 class="title nopadding"><?php the_title(); ?></h1></div>
                                    <p class="main-card-data-container-description-wrapper"><?php echo $abstract_destacado; ?></p>
                                    <a href="<?php the_permalink(); ?>" class="hidden-xs mb-xs readmore"><?php _e('Leer más', 'os_practica_type'); ?></a>
                                    <footer>
                                        <?php if ((false) || (false) || (false) || (false) || (false)) : ?>
                                        <div class="icon-row">
                                            <?php if (false) : ?>
                                            <div class="card-icon">
                                                <span class="icon bbva-icon-quote2"></span>
                                                <div class="triangle triangle-up-left"></div>
                                                <div class="triangle triangle-down-right"></div>
                                            </div>
                                            <?php endif; ?>
                                            <?php if (false) : ?>
                                            <div class="card-icon">
                                                <span class="icon bbva-icon-audio2"></span>
                                                <div class="triangle triangle-up-left"></div>
                                                <div class="triangle triangle-down-right"></div>
                                            </div>
                                            <?php endif; ?>
                                            <?php if (false) : ?>
                                            <div class="card-icon">
                                                <span class="icon bbva-icon-chat2"></span>
                                                <div class="triangle triangle-up-left"></div>
                                                <div class="triangle triangle-down-right"></div>
                                            </div>
                                            <?php endif; ?>
                                            <?php if ((false) || (false)) : ?>
                                            <div class="card-icon ml-xs">
                                                <span class="icon bbva-icon-arrow-download"></span>
                                                <div class="triangle triangle-up-left"></div>
                                                <div class="triangle triangle-down-right"></div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php endif; ?>
                                    </footer>
                                </div>
                            </section>
                            <!-- EO main-card -->
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <footer>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="<?php _e('/practicas', 'os_practica_type'); ?>" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span><?php _e('Ver más practicas', 'os_practica_type'); ?></a></div>
                    </div>
                </footer>
            </div>
        </section>
        <?php } ?>
        <!-- EO latests-posts -->
    </article>
    <?php the_widget('os_prefooter_bbva', array('color_fondo' => 'blanco', 'menu_derecho' => 'enlaces-de-interes', 'menu_central' => 'en-el-mundo', 'menu_izquierdo' => 'sobre-educacion-financiera')); ?>
</div>

<?php get_footer(); ?>