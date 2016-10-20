<?php
/*Template Name: Post-type Historia */
?>

<?php
    
    $post_id = $post->ID;

    $subtitulo = get_post_meta($post_id,'subtitulo',true);
    $texto_destacado = get_post_meta($post_id,'texto-destacado',true);
    //$imagenCabecera = get_post_meta($post->ID, 'imagenCabecera', true);
    $videoIntro_url = get_post_meta($post_id,'videoIntro-url',true);
    $videoFinal_type = get_post_meta($post_id,'video-type',true);
    $videoFinal_url = "";
    if($videoFinal_type == 'youtube') {
        $videoFinal_url = get_post_meta($post_id,'yt-video-url',true);
    } else if($videoFinal_type == 'wordpress') {
        $videoFinal_url = get_post_meta($post_id,'wp-video-url',true);
    }

    $url_impactos = get_site_url() . '/impactos/';
    
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
                              <div class="icon-section col-xs-6">
                                  <?php if(false): ?>
                                  <div class="card-icon icon-publication ml-xs">
                                      <span class="icon bbva-icon-quote"></span>
                                      <div class="triangle triangle-up-left"></div>
                                      <div class="triangle triangle-down-right"></div>
                                  </div>
                                  <?php endif; ?>
                                  <?php if(false): ?>
                                  <div class="card-icon icon-publication ml-xs">
                                      <span class="icon bbva-icon-audio"></span>
                                      <div class="triangle triangle-up-left"></div>
                                      <div class="triangle triangle-down-right"></div>
                                  </div>
                                  <?php endif; ?>
                                  <?php if(false): ?>
                                  <div class="card-icon icon-publication ml-xs">
                                      <span class="icon bbva-icon-comments"></span>
                                      <div class="triangle triangle-up-left"></div>
                                      <div class="triangle triangle-down-right"></div>
                                  </div>
                                  <?php endif; ?>
                                  <?php if($videoFinal_url !== ''): ?>  
                                  <div class="card-icon icon-publication ml-xs">
                                      <span class="icon bbva-icon-play"></span>
                                      <div class="triangle triangle-up-left"></div>
                                      <div class="triangle triangle-down-right"></div>
                                  </div>
                                  <?php endif; ?>
                                  
                              </div>
                              <?php get_template_part('content','rrssmovil'); ?>
                          </div>
                          <div class="row mb-xs hidden-xs">
                              <div class="icon-section col-sm-offset-2 col-sm-2">
                                  <?php if(false): ?>
                                  <div class="card-icon ml-xs">
                                      <span class="icon bbva-icon-quote"></span>
                                      <div class="triangle triangle-up-left"></div>
                                      <div class="triangle triangle-down-right"></div>
                                  </div>
                                  <?php endif; ?>
                                  <?php if(false): ?>
                                  <div class="card-icon ml-xs">
                                      <span class="icon bbva-icon-audio"></span>
                                      <div class="triangle triangle-up-left"></div>
                                      <div class="triangle triangle-down-right"></div>
                                  </div>
                                  <?php endif; ?>
                                  <?php if(false): ?>
                                  <div class="card-icon ml-xs">
                                      <span class="icon bbva-icon-comments"></span>
                                      <div class="triangle triangle-up-left"></div>
                                      <div class="triangle triangle-down-right"></div>
                                  </div>
                                  <?php endif; ?>
                                  <?php if($videoFinal_url != ''): ?>
                                  <div class="card-icon ml-xs">
                                      <span class="icon bbva-icon-video"></span>
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

                   <div class="container content-wrap content-text">
                     <h1 class="mt-xs"><?php echo $subtitulo; ?></h1>
                           <h2><?php echo $texto_destacado; ?></h2>
                           <?php the_content(); ?>
                  </div>
                  </section>
                


            <!-- latests-posts -->

            <!-- EO latests-posts -->
            
            </article>
    </div>

<?php get_footer(); ?>