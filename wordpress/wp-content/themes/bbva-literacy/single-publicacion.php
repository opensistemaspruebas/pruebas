<?php

/**
 *
 * Template para mostrar las publicaciones
 *
 */

get_header(); ?>


<?php

    $title2 = get_the_title();
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
    $name_url = get_post_meta(get_the_ID(), 'name_url', true);
    $source_url = get_post_meta(get_the_ID(), 'source_url', true);
    $organization_url = get_post_meta(get_the_ID(), 'organization_url', true);
    $organization_logo = get_post_meta(get_the_ID(), 'organization_logo', true);
    $videoIntro_url = get_post_meta(get_the_ID(),'videoIntro-url',true);
    $videoFinal_type = get_post_meta(get_the_ID(),'video-type',true);
    $publicacion_puntosClave = get_post_meta(get_the_ID(), 'publicacion_puntosClave', true);

    if($videoFinal_type == 'youtube'){

      $videoFinal_url = get_post_meta(get_the_ID(),'yt-video-url',true);
    }
    else if($videoFinal_type == 'wordpress'){

      $videoFinal_url = get_post_meta(get_the_ID(),'wp-video-url',true);
    }

    $post_title = the_title('','',false);
    $blog_title = get_bloginfo('name');
    $permalink = get_permalink();
    $summary = get_the_excerpt('','',false);
    $title_encoded = urlencode( html_entity_decode($blog_title . ' | ' . the_title('','',false)));
    $title = $blog_title . ' | ' . $post_title;

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
        'posts_per_page' => 3,
        'tax_query' => array(
            'relation' => 'OR',
            $tax_query_tags,
            $tax_query_ambitos_geograficos
        ),
    );
    $query = new WP_Query($args);
    

?>

  <div class="contents">
    <div id="search-layer"></div>
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
                        <?php if ($pdf) : ?>
                        <div class="card-icon icon-publication ml-xs">
                            <span class="icon bbva-icon-chat2"></span>
                            <div class="triangle triangle-up-left"></div>
                            <div class="triangle triangle-down-right"></div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="share-rrss-section rrss-xs">
                        <span id="share-button" class="icon bbva-icon-share" data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-content="<a title='<?php echo $title; ?>' href='https://twitter.com/share?url=<?php echo $permalink; ?>&text=<?php echo $title_encoded; ?>'' target='popup' onclick='window.open('https://twitter.com/share?url=<?php echo $permalink; ?>&text=<?php echo $title_encoded; ?>','name','width=600,height=500')'><span data-wow-delay='0.4s' class='bbva-icon-twitter-circle twitter-icon mr-xs wow rollIn'></span></a>
                        <a href='https://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink; ?>' target='popup' onclick='window.open(this.href,'name','width=600,height=500')'><span data-wow-delay='0.3s' class='bbva-icon-facebook-circle facebook-icon mr-xs wow rollIn'></span></a>
                        <a title='<?php echo $title; ?>' href='https://plus.google.com/share?url=<?php echo $permalink; ?>' target='popup' onclick='window.open('https://plus.google.com/share?url=<?php echo $permalink; ?>','name','width=600,height=500')'><span data-wow-delay='0.2s' class='bbva-icon-google-plus-circle googleplus-icon mr-xs wow rollIn'></span></a>                      
                        <a title='<?php echo $title; ?>' href='http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink; ?>&title=<?php echo $title_encoded; ?>&summary=<?php echo $summary; ?>&source=<?php echo urlencode( html_entity_decode($blog_title)); ?>' target='popup' onclick='window.open(this.href,'name','width=520,height=570')'><span data-wow-delay='0s' class='bbva-icon-linkedin-circle linkedin-icon mr-xs wow rollIn'></span></a>"></span>
                    </div>
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
                        <?php if ($pdf) : ?>
                        <div class="card-icon ml-xs">
                            <span class="icon bbva-icon-chat2"></span>
                            <div class="triangle triangle-up-left"></div>
                            <div class="triangle triangle-down-right"></div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="share-rrss-section">
                        <p class="share-in"><?php _e('Compartir en','os_publicacion_type'); ?></p>
                       <div class="card-icon">
                          <a title="<?php echo $title; ?>" href="https://twitter.com/share?url=<?php echo $permalink; ?>&text=<?php echo $title_encoded; ?>" target="popup" onclick="window.open('https://twitter.com/share?url=<?php echo $permalink; ?>&text=<?php echo $title_encoded; ?>','name','width=600,height=500')">
                          <span class="icon icon-twitter bbva-icon-twitter-circle mr-xs"></span>
                          </a>
                      </div>
                      <div class="card-icon">
                          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink; ?>" target="popup" onclick="window.open(this.href,'name','width=600,height=500')">
                          <span class="icon icon-facebook bbva-icon-facebook-circle mr-xs"></span>
                          </a>
                      </div>
                      <div class="card-icon">
                          <a title="<?php echo $title; ?>" href="https://plus.google.com/share?url=<?php echo $permalink; ?>" target="popup" onclick="window.open('https://plus.google.com/share?url=<?php echo $permalink; ?>','name','width=600,height=500')">
                          <span class="icon icon-googleplus bbva-icon-google-plus-circle mr-xs"></span>
                          </a>
                      </div>
                      <div class="card-icon">
                          <a title="<?php echo $title; ?>" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink; ?>&title=<?php echo $title_encoded; ?>&summary=<?php echo $summary; ?>&source=<?php echo urlencode( html_entity_decode($blog_title)); ?>" target="popup" onclick="window.open(this.href,'name','width=520,height=570')">
                            <span class="icon icon-linkedin bbva-icon-linkedin-circle mr-xs"></span>
                          </a>
                      </div>
                    </div>
                </div>
            </div>
            <div class="header-fixed-top hidden">
                <div class="container">
                    <div class="content">
                        <header class="title-description">
                            <h1><?php the_title(); ?></h1>
                            <div class="description-container">
                                <p></p>
                            </div>
                        </header>
                        <div id="share-fixed-button" class="share-rrss-section rrss-xs icon bbva-icon-share" data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-content="<a title='<?php echo $title; ?>' href='https://twitter.com/share?url=<?php echo $permalink; ?>&text=<?php echo $title_encoded; ?>'' target='popup' onclick='window.open('https://twitter.com/share?url=<?php echo $permalink; ?>&text=<?php echo $title_encoded; ?>','name','width=600,height=500')'><span data-wow-delay='0.4s' class='bbva-icon-twitter-circle twitter-icon mr-xs wow rollIn'></span></a>
                        <a href='https://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink; ?>' target='popup' onclick='window.open(this.href,'name','width=600,height=500')'><span data-wow-delay='0.3s' class='bbva-icon-facebook-circle facebook-icon mr-xs wow rollIn'></span></a>
                        <a title='<?php echo $title; ?>' href='https://plus.google.com/share?url=<?php echo $permalink; ?>' target='popup' onclick='window.open('https://plus.google.com/share?url=<?php echo $permalink; ?>','name','width=600,height=500')'><span data-wow-delay='0.2s' class='bbva-icon-google-plus-circle googleplus-icon mr-xs wow rollIn'></span></a>
                        <a title='<?php echo $title; ?>' href='http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink; ?>&title=<?php echo $title_encoded; ?>&summary=<?php echo $summary; ?>&source=<?php echo urlencode( html_entity_decode($blog_title)); ?>' target='popup' onclick='window.open(this.href,'name','width=520,height=570')'><span data-wow-delay='0s' class='bbva-icon-linkedin-circle linkedin-icon mr-xs wow rollIn'></span></a>">
                        </div>
                    </div>
                </div>
                <progress value="0" id="progressBar">
                    <div class="progress-container">
                        <span class="progress-bar"></span>
                    </div>
                </progress>
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
                <?php if (!empty($publicacion_puntosClave)) : ?>
                <section class="key-points mb-lg">
                    <h1 class="mt-lg mb-md"><?php _e('Puntos clave', 'os_publicacion_type'); ?></h1>
                    <div class="row keyPoint">
                        <?php $numPtoClave = count($publicacion_puntosClave);  $i = 0; while($numPtoClave != 0) : ?>
                        <div class="col-xs-12 col-sm-12">
                            <div class="row">
                                <div class="col-xs-1">
                                    <div class="rectangle"></div>
                                    <div class="pre-rectangle"></div>
                                </div>
                                <div class="text col-xs-11">
                                    <p><?php echo $publicacion_puntosClave[$i] ?></p>
                                </div>
                            </div>
                        </div>
                        <?php  $numPtoClave--; $i++;?>
                        <?php endwhile; ?>
                    </div>
                </section>
                <?php endif; ?>
            </div>
            <?php if (!empty($videoIntro_url)) : ?>
            <div class="video-container">
                <video src="<?php echo $videoIntro_url; ?>" autoplay loop="loop" preload="auto"></video>
                <?php if($videoFinal_url != ''): ?>
                <div class="video-text">
                    <button type="button" class="play-button" name="button" data-toggle="modal" data-target="#publicationVideo">
                        <span class="icon-play bbva-icon-play"></span>
                    </button>
                </div>
                <?php endif; ?>
                <!-- Modal -->
                <div class="modal fade" id="publicationVideo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="<?php echo $videoFinal_url; ?>"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="container content-wrap">
            <?php if (!empty($pdf)) : ?>
                <section class="pdf-rectangle mt-xl">
                    <div class="row">
                        <div class="col-xs-12 col-sm-1">
                            <span class="icon bbva-icon-pdf-01"></span>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <h1 class="mt-md pt-sm ml-xs publication-access-title">
                            <?php _e('Acceso a la publicación', 'os_publicacion_type'); ?>
                            </h1>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-sm-offset-2">
                            <div class="container-button mb-md mt-md">
                                <a href="<?php echo $pdf; ?>" target="_blank" class="btn btn-bbva-aqua"><?php _e('Acceder', 'os_publicacion_type'); ?></a>
                            </div>
                        </div>
                    </div>
                </section>
                <?php endif; ?>
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
                            <div class="text col-xs-11">
                             <?php
                                  $name = '';
                                  $cargo = '';
                                  if (is_a($author, 'WP_User')) {
                                      $name = $author->data->display_name;
                                      $cargo = get_the_author_meta('cargo',$author->data->ID);
                                  } 
                                  else {
                                      $name = $author->display_name;
                                      $cargo = get_post_meta($author->ID, 'cargo', true);
                                  }
                              ?>
                                <h2><?php echo $name; ?></h2>
                                <p><?php echo $cargo; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
          </section>
          <?php endif; ?>
          <?php if (!empty($source_url) && !empty($name_url)) : ?>
          <section class="sources-section">
              <div class="container content-wrap">
                  <h1 class="mt-lg mb-md"><?php _e('Fuente', 'os_publicacion_type'); ?></h1>
                  <div class="source">
                      <a target="_blank" class="readmore" href="<?php echo $source_url; ?>"><?php echo $name_url; ?></a>
                  </div>
              </div>
          </section>
          <?php endif; ?>     
          <?php if (!empty($publication_date) || !empty($edition) || !empty($editorial) || !empty($organization_name) || !empty($jel_code) || !empty($type) || !empty($ambito_geografico) || !empty($target_audiences) || !empty($number_of_pages)) : ?>
           <section class="additional-section">
            <div class="container content-wrap">
                <h1 class="mt-lg mb-md"><?php _e('Información adicional', 'os_publicacion_type'); ?></h1>
                <div class="row additional-info">
                    <div class="col-xs-12 col-sm-6 mb-sm">
                        <?php if (!empty($publication_date)) : ?>
                        <div class="row mgb-5">
                            <div class="col-xs-1">
                                <div class="rectangle"></div>
                                <div class="pre-rectangle"></div>
                            </div>
                            <div class="text col-xs-11">
                                <h2><?php _e('Fecha de publicación', 'os_publicacion_type'); ?></h2>
                                <p><?php echo $publication_date; ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($type)) : ?>
                        <div class="row mgb-5">
                            <div class="col-xs-1">
                                <div class="rectangle"></div>
                                <div class="pre-rectangle"></div>
                            </div>
                            <div class="text col-xs-11">
                                 <h2><?php _e('Tipo', 'os_publicacion_type'); ?></h2>
                                  <p><?php echo $type; ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($ambito_geografico)) : ?>
                        <div class="row mgb-5">
                            <div class="col-xs-1">
                                <div class="rectangle"></div>
                                <div class="pre-rectangle"></div>
                            </div>
                            <div class="text col-xs-11">
                                <h2><?php _e('Ámbito geográfico', 'os_publicacion_type'); ?></h2>
                                <p><?php echo $ambito_geografico; ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($target_audiences)) : ?>
                        <div class="row mgb-5">
                            <div class="col-xs-1">
                                <div class="rectangle"></div>
                                <div class="pre-rectangle"></div>
                            </div>
                            <div class="text col-xs-11">
                                <h2><?php _e('Público objetivo', 'os_publicacion_type'); ?></h2>
                                <p><?php echo $target_audiences; ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($number_of_pages)) : ?>
                        <div class="row mgb-5">
                            <div class="col-xs-1">
                                  <div class="rectangle"></div>
                                  <div class="pre-rectangle"></div>
                            </div>
                            <div class="text col-xs-11">
                                <h2><?php _e('Número de páginas', 'os_publicacion_type'); ?></h2>
                                <p><?php echo $number_of_pages; ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div> 
                    <div class="col-xs-12 col-sm-6 mb-sm">
                        <?php if (!empty($jel_code)) : ?>
                        <div class="row mgb-5">
                            <div class="col-xs-1">
                                <div class="rectangle"></div>
                                <div class="pre-rectangle"></div>
                            </div>
                            <div class="text col-xs-11">
                                <h2><?php _e('Código JEL', 'os_publicacion_type'); ?></h2>
                                <p><?php echo $jel_code; ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($edition)) : ?>
                        <div class="row mgb-5">
                            <div class="col-xs-1">
                                <div class="rectangle"></div>
                                <div class="pre-rectangle"></div>
                            </div>
                            <div class="text col-xs-11">
                                <h2><?php _e('Edición', 'os_publicacion_type'); ?></h2>
                                <p><?php echo $edition; ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($editorial)) : ?>
                        <div class="row mgb-5">
                            <div class="col-xs-1">
                                <div class="rectangle"></div>
                                <div class="pre-rectangle"></div>
                            </div>
                            <div class="text col-xs-11">
                                <h2><?php _e('Editorial', 'os_publicacion_type'); ?></h2>
                                <p><?php echo $editorial; ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($organization_logo) || !empty($organization_name)|| !empty($organization_url)) : ?>
                        <div class="row mgb-5">
                            <div class="col-xs-1">
                                <div class="rectangle"></div>
                                <div class="pre-rectangle"></div>
                            </div>
                            <div class="text col-xs-11">
                                <h2><?php _e('Fuente', 'os_publicacion_type'); ?></h2>
                                <a target="_blank" class="readmore" href="<?php echo $organization_url; ?>"><?php echo $organization_name; ?></a>
                                <div class="block-img">
                                    <img src="<?php echo $organization_logo ?>" alt="" />
                                    <!--<span>The World Bank</span>-->
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php if ($query->have_posts()) { ?>
        <!-- latests-posts -->
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
                                $imagen = get_post_meta($post->ID, 'imagenCard', true);
                                
                                $pdf = get_post_meta(get_the_ID(), 'pdf', true);
                        ?>
                        <div class="main-card-container col-xs-12 col-sm-4 noppading">
                            <!-- main-card -->
                            <section class="container-fluid main-card">
                                <header class="row header-container">
                                    <div class="image-container col-xs-12">
                                        <a href="<?php the_permalink(); ?>" class="link-header-layer visible-xs">
                                            <img src="<?php echo $imagen; ?>" alt="" />
                                        </a>
                                        <img src="<?php echo $imagen; ?>" alt="" class="hidden-xs" />
                                    </div>
                                    <div class="hidden-xs floating-text col-xs-9">
                                        <p class="date"><?php echo $date; ?></p> <!--Cambiar por la fecha del pdf-->
                                        <h1><?php the_title(); ?></h1>
                                    </div>
                                </header>
                                <div class="row data-container">
                                    <a href="<?php the_permalink(); ?>" class="link-layer visible-xs">&nbsp;</a>
                                    <div class="nopadding date"><?php echo $date; ?></div>
                                    <div class="main-card-data-container-title-wrapper">
                                        <h1 class="title nopadding"><?php the_title(); ?></h1>
                                    </div>
                                    <p class="main-card-data-container-description-wrapper"><?php echo $abstract_destacado; ?></p>
                                    <a href="<?php the_permalink(); ?>" class="hidden-xs mb-xs readmore">Leer más</a>
                                    <footer>
                                        <?php if ((false) || (false) || ($pdf)) : ?>
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
                                            <?php if ($pdf) : ?>
                                            <div class="card-icon">
                                                <span class="icon bbva-icon-chat2"></span>
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
                            <a href="#" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span> Todas las publicaciones</a>
                        </div>
                    </div>
                </footer>
            </div>
        </section>
        <!-- EO latests-posts -->
        <?php } ?>
    </article>


<?php get_footer(); ?>
