<?php

/**
 *
 * Template para mostrar las publicaciones
 *
 */

get_header(); ?>


<?php

    $title = get_the_title();
    $date = get_the_date('l, j \d\e F \d\e Y');
    $abstract_destacado = get_post_meta(get_the_ID(), 'abstract_destacado', true);
    $imagenCabecera = get_post_meta(get_the_ID(), 'imagenCabecera', true);
    $abstract_contenido = get_post_meta(get_the_ID(), 'abstract_contenido', true);
    $pdf = get_post_meta(get_the_ID(), 'pdf', true);
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
    $source_url = get_post_meta(get_the_ID(), 'source_url', true);
    $organization_url = get_post_meta(get_the_ID(), 'organization_url', true);
    $organization_logo = get_post_meta(get_the_ID(), 'organization_logo', true);

    $tags = wp_get_post_terms(get_the_ID(), 'category', array("fields" => "all"));

    $ambitos_geograficos = wp_get_post_terms(get_the_ID(), 'ambito_geografico', array("fields" => "all"));
    if (!empty($ambitos_geograficos)) {
        $ambito_geografico = $ambitos_geograficos[0]->name;
    } else {
        $ambito_geografico = '';
    }

    $authors = get_coauthors();


    $tags_ids = array();
    foreach($tags as $individual_tag) $tags_ids[] = $individual_tag->term_id;

    $ambitos_geograficos_ids = array();
    foreach($ambitos_geograficos as $individual_ambito_geografico) $ambitos_geograficos_ids[] = $individual_ambito_geografico->term_id;

    $tax_query_tags = array(
        'taxonomy' => 'category',
        'field'    => 'term_id',
        'terms'    => $tags_ids,
    );

    $tax_query_ambitos_geograficos = array(
        'taxonomy' => 'category',
        'field'    => 'term_id',
        'terms'    => $ambitos_geograficos_ids,
    );


    $args = array(
        'post_type' => 'publicacion',
        'post__not_in' => array(get_the_ID()),
        'posts_per_page' => 6,
        'tax_query' => array(
            'relation' => 'OR',
            $tax_query_tags,
            $tax_query_ambitos_geograficos
        ),
    );
    $query = new WP_Query($args);
    

?>

    
<div class="contents">
    <article class="publication">
        <div class="header-section">
            <div class="container">
                <header class="title-description">
                    <h1><?php the_title(); ?></h1>
                    <div class="description-container">
                        <p></p>
                    </div>
                </header>
                <div class="row visible-xs">
                    <div class="icon-section col-xs-6">
                        <?php if (!empty($abstract_destacado) || !empty($abstract_contenido)) : ?>
                            <div class="card-icon ml-xs">
                                <span class="icon bbva-icon-quote"></span>
                                <div class="triangle triangle-up-left"></div>
                                <div class="triangle triangle-down-right"></div>
                            </div>
                        <?php endif; ?>
                        <?php if (false) : ?>
                            <div class="card-icon ml-xs">
                                <span class="icon bbva-icon-audio"></span>
                                <div class="triangle triangle-up-left"></div>
                                <div class="triangle triangle-down-right"></div>
                            </div>
                        <?php endif; ?>
                        <?php if ($pdf) : ?>
                            <div class="card-icon ml-xs">
                                <span class="icon bbva-icon-comments"></span>
                                <div class="triangle triangle-up-left"></div>
                                <div class="triangle triangle-down-right"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="share-rrss-section col-xs-offset-4 col-xs-2 rrss-xs">
                        <span class="icon bbva-icon-share" data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-content='<span class="bbva-icon-twitter_link twitter-icon mr-xs"></span>
                      <span class="bbva-icon-facebook_link facebook-icon mr-xs"></span>
                      <span class="bbva-icon-twitter_link googleplus-icon mr-xs"></span>
                      <span class="bbva-icon-facebook_link pinterest-icon mr-xs"></span>
                      <span class="bbva-icon-twitter_link linkedin-icon mr-xs"></span>'></span>
                    </div>
                </div>
                <div class="row mb-xs hidden-xs">
                    <div class="icon-section col-sm-offset-2 col-sm-2">
                        <?php if (!empty($abstract_destacado) || !empty($abstract_contenido)) : ?>
                            <div class="card-icon ml-xs">
                                <span class="icon bbva-icon-quote"></span>
                                <div class="triangle triangle-up-left"></div>
                                <div class="triangle triangle-down-right"></div>
                            </div>
                        <?php endif; ?>
                        <?php if (false) : ?>
                            <div class="card-icon ml-xs">
                                <span class="icon bbva-icon-audio"></span>
                                <div class="triangle triangle-up-left"></div>
                                <div class="triangle triangle-down-right"></div>
                            </div>
                        <?php endif; ?>
                        <?php if ($pdf) : ?>
                            <div class="card-icon ml-xs">
                                <span class="icon bbva-icon-comments"></span>
                                <div class="triangle triangle-up-left"></div>
                                <div class="triangle triangle-down-right"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="share-rrss-section col-sm-4 col-sm-offset-3">
                        <p class="mr-xs"><?php _e('Compartir en', 'os_publicacion_type'); ?></p>
                        <div class="card-icon">
                            <span class="icon icon-twitter bbva-icon-twitter_link mr-xs"></span>
                        </div>
                        <div class="card-icon">
                            <span class="icon icon-facebook bbva-icon-facebook_link mr-xs"></span>
                        </div>
                        <div class="card-icon">
                            <span class="icon icon-googleplus bbva-icon-twitter_link mr-xs"></span>
                        </div>
                        <div class="card-icon">
                            <span class="icon icon-pinterest bbva-icon-facebook_link mr-xs"></span>
                        </div>
                        <div class="card-icon">
                            <span class="icon icon-linkedin bbva-icon-twitter_link mr-xs"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($imagenCabecera)): ?>
            <div class="image-section">
                <img src="<?php echo $imagenCabecera; ?>" alt="image title" />
            </div>
        <?php endif; ?>
        <?php if (!empty($date) || !empty($abstract_destacado) || !empty($abstract_contenido) || !empty($source_url)) : ?>
            <section class="content-section">
                <div class="container content-wrap">
                    <?php if (!empty($date)) : ?>
                        <label class="mt-lg"><?php echo $date; ?></label>
                    <?php endif; ?>
                    <?php if (!empty($abstract_destacado) || !empty($abstract_contenido)) : ?>
                        <h1 class="mt-xs"><?php _e('Abstract', 'os_publicacion_type'); ?></h1>
                        <?php if (!empty($abstract_destacado)) : ?>
                            <h2><?php echo $abstract_destacado; ?></h2>
                        <?php endif; ?>
                        <?php if (!empty($abstract_contenido)) : ?>
                            <p><?php echo $abstract_contenido; ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (!empty($pdf)) : ?>
                    <section class="pdf-rectangle mt-lg">
                        <div class="row">
                            <div class="col-xs-12 col-sm-1">
                                <span class="icon bbva-icon-document"></span>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <h1 class="ml-md"><?php _e('Informe en PDF', 'os_publicacion_type'); ?></h1>
                                <p class="ml-md"><?php _e('Lee y/o descarga el informe desde tu navegador', 'os_publicacion_type'); ?></p>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-sm-offset-1">
                                <div class="container-button mb-md mt-md">
                                    <a href="<?php echo $pdf; ?>" class="btn btn-bbva-aqua"><?php _e('Leer informe', 'os_publicacion_type'); ?></a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>
        <?php if (!empty($authors)) : ?>
        <section class="authors-section">
            <div class="container content-wrap">
                <h1 class="mt-lg mb-md"><?php _e('Autores', 'os_publicacion_type'); ?></h1>
                <div class="row authors">
                    <?php foreach ($authors as $author): ?>
                    <div class="col-xs-12 col-sm-6">
                        <div class="row">
                            <div class="col-xs-1">
                                <div class="rectangle"></div>
                                <div class="pre-rectangle"></div>
                            </div>
                            <div class="col-xs-11">
                                <h2><?php echo mb_strtoupper($author->data->display_name, 'UTF-8'); ?></h2>
                                <p><?php echo get_the_author_meta('cargo', $author->data->ID); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php if (!empty($source_url)) : ?>
        <section class="sources-section">
            <div class="container content-wrap">
                <h1 class="mt-lg mb-md"><?php _e('Fuente', 'os_publicacion_type'); ?></h1>
                <div class="source">
                    <a target="_blank" href="<?php echo $source_url; ?>"><?php echo $source_url; ?></a>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php if (!empty($tags)) : ?>
        <section class="tags-section">
            <div class="container content-wrap">
                <h1 class="mt-lg mb-md"><?php _e('Tags', 'os_publicacion_type'); ?></h1>
                <div class="tags">
                    <?php foreach ($tags as $tag) : ?>
                        <span class="tag pt-xs pl-sm pr-sm pb-xs mr-xs mb-xs"><?php echo $tag->name; ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php if (!empty($publication_date) || !empty($edition) || !empty($editorial) || !empty($organization_name) || !empty($jel_code) || !empty($type) || !empty($ambito_geografico) || !empty($target_audiences) || !empty($number_of_pages)) : ?>
            <section class="additional-section">
                <div class="container content-wrap">
                    <h1 class="mt-lg mb-md"><?php _e('Información adicional', 'os_publicacion_type'); ?></h1>
                    <div class="row additional-info mb-md">
                        <?php if (!empty($publication_date)) : ?>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <div class="col-xs-1">
                                    <div class="rectangle"></div>
                                    <div class="pre-rectangle"></div>
                                </div>
                                <div class="col-xs-11">
                                    <h2><?php _e('Fecha de publicación', 'os_publicacion_type'); ?></h2>
                                    <p><?php echo $publication_date; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($jel_code)) : ?>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <div class="col-xs-1">
                                    <div class="rectangle"></div>
                                    <div class="pre-rectangle"></div>
                                </div>
                                <div class="col-xs-11">
                                    <h2><?php _e('Código JEL', 'os_publicacion_type'); ?></h2>
                                    <p><?php echo $jel_code; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($type)) : ?>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <div class="col-xs-1">
                                    <div class="rectangle"></div>
                                    <div class="pre-rectangle"></div>
                                </div>
                                <div class="col-xs-11">
                                    <h2><?php _e('Tipo', 'os_publicacion_type'); ?></h2>
                                    <p><?php echo $type; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($edition)) : ?>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <div class="col-xs-1">
                                    <div class="rectangle"></div>
                                    <div class="pre-rectangle"></div>
                                </div>
                                <div class="col-xs-11">
                                    <h2><?php _e('Edición', 'os_publicacion_type'); ?></h2>
                                    <p><?php echo $edition; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($ambito_geografico)) : ?>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <div class="col-xs-1">
                                    <div class="rectangle"></div>
                                    <div class="pre-rectangle"></div>
                                </div>
                                <div class="col-xs-11">
                                    <h2><?php _e('Ámbito geográfico', 'os_publicacion_type'); ?></h2>
                                    <p><?php echo $ambito_geografico; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($editorial)) : ?>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <div class="col-xs-1">
                                    <div class="rectangle"></div>
                                    <div class="pre-rectangle"></div>
                                </div>
                                <div class="col-xs-11">
                                    <h2><?php _e('Editorial', 'os_publicacion_type'); ?></h2>
                                    <p><?php echo $editorial; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($target_audiences)) : ?>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <div class="col-xs-1">
                                    <div class="rectangle"></div>
                                    <div class="pre-rectangle"></div>
                                </div>
                                <div class="col-xs-11">
                                    <h2><?php _e('Público objetivo', 'os_publicacion_type'); ?></h2>
                                    <p><?php echo $target_audiences; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($organization_name)) : ?>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <div class="col-xs-1">
                                    <div class="rectangle"></div>
                                    <div class="pre-rectangle"></div>
                                </div>
                                <div class="col-xs-11">
                                    <h2><?php _e('Fuente', 'os_publicacion_type'); ?></h2>
                                    <p><?php echo $organization_name; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($number_of_pages)) : ?>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <div class="col-xs-1">
                                    <div class="rectangle"></div>
                                    <div class="pre-rectangle"></div>
                                </div>
                                <div class="col-xs-11">
                                    <h2><?php _e('Número de páginas', 'os_publicacion_type'); ?></h2>
                                    <p><?php echo $number_of_pages; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </article>

    <!-- latests-posts -->
    <?php 

    if ($query->have_posts()) {
        ?>
        <section class="latests-posts pt-xl pb-lg wow fadeInUp">
            <div class="container">
                <header class="title-description">
                    <h1><?php _e('Publicaciones relacionadas', 'os_publicacion_type'); ?></h1>
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
                            $abstract_destacado = substr(get_post_meta($post->ID, 'abstract_destacado', true), 0, 140) . '...';
                            $abstract_contenido = get_post_meta(get_the_ID(), 'abstract_contenido', true);
                            $imagen_id = get_post_thumbnail_id($post->ID);
                            $imagen = wp_get_attachment_image_src($imagen_id, "full")[0];
                            $imagen_alt = get_post_meta($imagen_id, '_wp_attachment_image_alt', true);
                            $pdf = get_post_meta(get_the_ID(), 'pdf', true);
                            ?>
                            <div class="main-card-container col-xs-12 col-sm-4 noppading">
                                <!-- main-card -->
                                <section class="container-fluid main-card">
                                    <header class="row header-container">
                                        <div class="image-container nopadding col-xs-12">
                                            <img class="img-responsive" src="<?php echo $imagen; ?>" alt="<?php echo $imagen_alt; ?>">
                                        </div>
                                        <div class="hidden-xs floating-text col-xs-9">
                                            <p class="date"><?php echo $date; ?></p>
                                            <h1><?php the_title(); ?></h1>
                                        </div>
                                    </header>
                                    <div class="row data-container">
                                        <p class="nopadding col-xs-9 date"><?php echo $date; ?></p>
                                        <h1 class="title nopadding col-xs-9"><?php the_title(); ?></h1>
                                        <p><?php echo $abstract_destacado; ?></p>
                                        <a href="<?php the_permalink(); ?>" class="hidden-xs readmore"><?php _e("Leer más", "os_publicacion_type"); ?></a>
                                        <footer class="row">
                                            <?php if ($abstract_destacado) : ?>
                                                <div class="col-xs-2 col-lg-1">
                                                    <div class="card-icon">
                                                        <span class="icon bbva-icon-quote"></span>
                                                        <div class="triangle triangle-up-left"></div>
                                                        <div class="triangle triangle-down-right"></div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (false) :?>
                                                <div class="col-xs-2 col-lg-1">
                                                    <div class="card-icon">
                                                        <span class="icon bbva-icon-audio"></span>
                                                        <div class="triangle triangle-up-left"></div>
                                                        <div class="triangle triangle-down-right"></div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($pdf) : ?>
                                                <div class="col-xs-2 col-lg-1">
                                                    <div class="card-icon">
                                                        <span class="icon bbva-icon-comments"></span>
                                                        <div class="triangle triangle-up-left"></div>
                                                        <div class="triangle triangle-down-right"></div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </footer>
                                    </div>
                                </section>
                                <!-- EO main-card -->
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <footer>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="#" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span><?php _e('Todas las publicaciones', 'os_publicacion_type'); ?></a>
                        </div>
                    </div>
                </footer>
            </div>
        </section>
        <?php
    }

    ?>

<?php get_footer(); ?>
