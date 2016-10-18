<?php
/*Template Name: Post-type Historia */
?>

<?php
    
    $post_id = $post->ID;

    $subtitulo = get_post_meta($post_id,'subtitulo',true);
    $texto_destacado = get_post_meta($post_id,'texto-destacado',true);
    $imagenCabecera = get_post_meta($post->ID, 'imagenCabecera', true);
    $video_type = get_post_meta($post->ID,'video-type',true);
    $video_url = "";
    if($video_type == 'youtube') {
        $video_url = get_post_meta($post_id,'yt-video-url',true);
    } else if($video_type == 'wordpress') {
        $video_url = get_post_meta($post_id,'wp-video-url',true);
    }
    
?>

<?php get_header(); ?>
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

                        <?php if($video_url !== ''): ?>  
                        <div class="card-icon icon-publication ml-xs">
                            <span class="icon bbva-icon-play"></span>
                            <div class="triangle triangle-up-left"></div>
                            <div class="triangle triangle-down-right"></div>
                        </div>
                        <?php endif; ?>
                          
                      </div>
                      <div class="share-rrss-section rrss-xs">
                          <span id="share-button" class="icon bbva-icon-share" data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-content="<span data-wow-delay='0.4s' class='bbva-icon-twitter_link twitter-icon mr-xs wow rollIn'></span>
                          <span data-wow-delay='0.3s' class='bbva-icon-facebook_link facebook-icon mr-xs wow rollIn'></span>
                          <span data-wow-delay='0.2s' class='bbva-icon-twitter_link googleplus-icon mr-xs wow rollIn'></span>
                          <span data-wow-delay='0.1s' class='bbva-icon-facebook_link pinterest-icon mr-xs wow rollIn'></span>
                          <span data-wow-delay='0s' class='bbva-icon-twitter_link linkedin-icon mr-xs wow rollIn'></span>" data-original-title="" title=""></span>
                      </div>
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

                            <?php if($video_url !== ''): ?>  
                            <div class="card-icon icon-publication ml-xs">
                                <span class="icon bbva-icon-play"></span>
                                <div class="triangle triangle-up-left"></div>
                                <div class="triangle triangle-down-right"></div>
                            </div>
                            <?php endif; ?>
                              
                          </div>
                          <div class="share-rrss-section col-sm-4 col-sm-offset-3">
                              <p class="mr-xs"><?php _e('Compartir en','os_historia_type'); ?></p>
                              
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
                <div class="header-fixed-top hidden">
                    <div class="container">
                          
                        <header class="title-description">
                            <h1><?php the_title(); ?></h1>
                            <div class="description-container">
                                <p></p>
                            </div>
                        </header>

                        <div class="row">
                            <div class="share-rrss-section rrss-xs">
                                <span id="share-fixed-button" class="icon bbva-icon-share" data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-content="<span data-wow-delay='0.4s' class='bbva-icon-twitter_link twitter-icon mr-xs wow rollIn'></span>
                                <span data-wow-delay='0.3s' class='bbva-icon-facebook_link facebook-icon mr-xs wow rollIn'></span>
                                <span data-wow-delay='0.2s' class='bbva-icon-twitter_link googleplus-icon mr-xs wow rollIn'></span>
                                <span data-wow-delay='0.1s' class='bbva-icon-facebook_link pinterest-icon mr-xs wow rollIn'></span>
                                <span data-wow-delay='0s' class='bbva-icon-twitter_link linkedin-icon mr-xs wow rollIn'></span>" data-original-title="" title=""></span>
                            </div>
                        </div>
                    </div>
                    <progress value="0" id="progressBar" max="2845">
                      <div class="progress-container">
                        <span class="progress-bar"></span>
                      </div>
                    </progress>
                </div>
            </div>
            <?php if($video_url == '' && $imagenCabecera !== ''): ?>
            <div class="image-section">
                <img src="<?php echo $imagenCabecera; ?>" alt="image title">
            </div>
            <?php endif; ?>
            <section class="content-section">
                <?php if($video_url !== ''): ?>
                <div class="video-container">
                    <video src="<?php echo $video_url; ?>" autoplay="" loop="loop" preload="auto"></video>
                   <div class="video-text">
                     <button type="button" class="play-button" name="button" data-toggle="modal" data-target="#publicationVideo">
                       <span class="icon-play bbva-icon-play"></span>
                     </button>
                   </div>
                   <!-- Modal -->
                   <div class="modal fade" id="publicationVideo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
                     <div class="modal-dialog" role="document">
                       <div class="modal-content">
                         <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                         </div>
                         <div class="modal-body">
                           <div class="embed-responsive embed-responsive-16by9">
                              <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/ePbKGoIGAXY"></iframe>
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
        </article>
    </div>

<?php get_footer(); ?>