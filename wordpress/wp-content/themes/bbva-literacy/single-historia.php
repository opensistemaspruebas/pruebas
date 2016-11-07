<?php
/*Template Name: Post-type Historia */
?>

<?php
    
    $post_id = $post->ID;

    $subtitulo = get_post_meta($post_id,'subtitulo',true);
    $texto_destacado = get_post_meta($post_id,'texto-destacado',true);
    $videoIntro_url = get_post_meta($post_id,'videoIntro-url',true);
    $videoFinal_type = get_post_meta($post_id,'video-type',true);
    $videoFinal_url = "";
    if ($videoFinal_type == 'youtube') {
        $videoFinal_url = get_post_meta($post_id,'yt-video-url',true);
    } else if ($videoFinal_type == 'wordpress') {
        $videoFinal_url = get_post_meta($post_id,'wp-video-url',true);
    }


    // Obtener historias relacionadas
    $tags = wp_get_post_terms(get_the_ID(), 'category', array("fields" => "all"));
    $ambitos_geograficos = wp_get_post_terms(get_the_ID(), 'ambito_geografico', array("fields" => "all"));
    if (!empty($ambitos_geograficos)) {
        $ambito_geografico = $ambitos_geograficos[0]->name;
    } else {
        $ambito_geografico = '';
    }
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
        'post_type' => 'historia',
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

<?php get_header(); ?>

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
                    <?php if ((false) || (false) || !empty($videoIntro_url)) : ?>
                    <div class="icon-section col-xs-6">
                          <?php if (false) : ?>
                          <div class="card-icon icon-publication ml-xs">
                              <span class="icon bbva-icon-quote2"></span>
                              <div class="triangle triangle-up-left"></div>
                              <div class="triangle triangle-down-right"></div>
                          </div>
                        <?php endif; ?>
                        <?php if (!empty($videoIntro_url)) : ?>
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
                    </div>
                    <?php endif; ?>          
                      <?php get_template_part('content','rrssmovil'); ?>
                  </div>
                  <div class="mb-xs hidden-xs icon-section-desktop">
                  <?php if ((false) || (false) || !empty($videoIntro_url)) : ?>
                    <div class="icon-section">
                        <?php if (false) : ?>
                          <div class="card-icon ml-xs">
                              <span class="icon bbva-icon-quote2"></span>
                              <div class="triangle triangle-up-left"></div>
                              <div class="triangle triangle-down-right"></div>
                          </div>
                        <?php endif; ?>
                        <?php if (!empty($videoIntro_url)) : ?>
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
                    </div>
                    <?php endif; ?> 
                    <?php get_template_part( 'content', 'rrss' ); ?>
                  </div>
              </div>
              <div class="header-fixed-top hidden">
                  <div class="container">
                      <header class="title-description">
                          <h1><?php the_title(); ?></h1>
                          <div class="description-container">
                              <p></p>
                          </div>
                      </header>
                      <div class="row">
                          <?php get_template_part('content','rrssmovil'); ?>
                      </div>
                  </div>
                  <progress value="2279" id="progressBar" max="2827">
                      <div class="progress-container">
                          <span class="progress-bar"></span>
                      </div>
                  </progress>
              </div>
          </div>
          <section class="content-section">
            <?php if (!empty($videoIntro_url)) : ?>
                <div class="video-container">
                    <video src="<?php echo $videoIntro_url; ?>" autoplay="" loop="loop" preload="auto"></video>
                    <?php if($videoFinal_url !== ''): ?>
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
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
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
              <div class="container content-wrap content-text">
                  <h1 class="mt-xs"><?php echo $subtitulo; ?></h1>
                  <h2><?php echo $texto_destacado; ?></h2>
                  <?php the_content(); ?>
              </div>
          </section>
          <?php if ($query->have_posts()) : ?>
          <!-- latests-posts -->
          <section class="latests-posts pt-xl pb-lg wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
              <div class="container">
                  <header class="title-description">
                      <h1><?php _e('Otras Historias'); ?></h1>
                      <div class="description-container">
                          <p></p>
                      </div>
                  </header>
                  <div class="card-container nopadding container-fluid mt-md mb-md">
                      <div class="row">
                          <?php while ($query->have_posts()) : ?>
                            <?php 
                              $query->the_post();
                              $date = get_the_date('j F Y');
                              $texto_destacado = get_post_meta($post->ID, 'texto-destacado', true);
                              $imagen = get_post_meta($post->ID, 'imagenCard', true);
                            ?>
                            <div class="main-card-container col-xs-12 col-sm-4 noppading">
                                <!-- main-card -->
                                <section class="container-fluid main-card">
                                    <header class="row header-container">
                                        <div class="image-container col-xs-12">
                                            <a href="#" class="link-header-layer visible-xs">
                                                <img src="<?php echo $imagen; ?>" alt="">
                                            </a>
                                            <img src="<?php echo $imagen; ?>" alt="" class="hidden-xs">
                                        </div>
                                        <div class="hidden-xs floating-text col-xs-9">
                                            <p class="date"><?php echo $date; ?></p>
                                            <h1><?php the_title(); ?></h1>
                                        </div>
                                    </header>
                                    <div class="row data-container">
                                        <a href="#" class="link-layer visible-xs">&nbsp;</a>
                                        <div class="nopadding date"><?php echo $date; ?></div>
                                        <div class="main-card-data-container-title-wrapper">
                                            <h1 class="title nopadding"><?php the_title(); ?></h1>
                                        </div>
                                        <p class="main-card-data-container-description-wrapper"><?php echo $texto_destacado; ?></p>
                                        <a href="<?php the_permalink(); ?>" class="hidden-xs mb-xs readmore"><?php _e('Leer más'); ?></a>
                                        <footer>
                                            <?php if ((false) || (false) || !empty($videoIntro_url)) : ?>
                                            <div class="icon-row">
                                                <?php if (false) : ?>
                                                <div class="card-icon">
                                                    <span class="icon bbva-icon-quote2"></span>
                                                    <div class="triangle triangle-up-left"></div>
                                                    <div class="triangle triangle-down-right"></div>
                                                </div>
                                                <?php endif; ?>
                                                <?php if (!empty($videoIntro_url)) : ?>
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
                                            </div>
                                            <?php endif; ?>
                                        </footer>
                                    </div>
                                </section>
                                <!-- EO main-card -->
                            </div>
                          <?php endwhile; ?>
                      </div>
                  </div>
                  <footer>
                      <div class="row">
                          <div class="col-md-12 text-center">
                              <a href="<?php _e('/impactos/'); ?>" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span> <?php _e('Ver más historias'); ?></a>
                          </div>
                      </div>
                  </footer>
              </div>
          </section>
          <!-- EO latests-posts -->
          <?php endif; ?>
          <?php
          
            if ($query->have_posts()) $color = "blanco"; else $color = "gris";

            the_widget('os_prefooter_bbva', array('color_fondo' => $color, 'menu_derecho' => 'enlaces-de-interes', 'menu_central' => 'en-el-mundo', 'menu_izquierdo' => 'sobre-educacion-financiera')); 

          ?>
      </article>
  </div>

<?php get_footer(); ?>