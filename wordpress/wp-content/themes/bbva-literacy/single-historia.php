<?php
/*Template Name: Post-type Historia */
?>

<?php
    
    $post_id = $post->ID;

    $subtitulo = get_post_meta($post_id,'subtitulo',true);
    $texto_destacado = get_post_meta($post_id,'texto-destacado',true);
    $imagenCard = get_post_meta($post->ID, 'imagenCard', true);
    $imagen_card_thumbnail = wp_get_attachment_thumb_url(get_attachment_id_by_url($imagenCard));
    //$imagenCabecera = get_post_meta($post->ID, 'imagenCabecera', true);
    $videoIntro_url = get_post_meta($post_id,'videoIntro-url',true);
    $videoFinal_type = get_post_meta($post_id,'video-type',true);
    $videoFinal_url = "";
    if($videoFinal_type == 'youtube') {
        $videoFinal_url = get_post_meta($post_id,'yt-video-url',true);
    } else if($videoFinal_type == 'wordpress') {
        $videoFinal_url = get_post_meta($post_id,'wp-video-url',true);
    }
    
?>

<?php get_header(); ?>
    <link rel="canonical" href="<?php echo get_permalink(); ?>">
    <meta property="og:image" content="<?php echo $imagen_card_thumbnail; ?>">
    <meta property="og:image:width" content="300">
    <meta property="og:image:height" content="300">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?php echo get_permalink(); ?>">
    <meta property="og:title" content="<?php the_title(); ?>">
    <meta property="og:description" content="<?php the_excerpt(); ?>"> 

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
            <section class="latests-posts pt-xl pb-lg wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
              <div class="container">
                
            <header class="title-description">
                <h1>Otras Historias</h1>
                <div class="description-container">
                    <p></p>
                </div>
            </header>

                <div class="card-container nopadding container-fluid mt-md mb-md">
                  <div class="row">

                    
                      <div class="main-card-container col-xs-12 col-sm-4 noppading">
                        
            <!-- main-card -->
            <section class="container-fluid main-card">
                <header class="row header-container">
                    <div class="image-container col-xs-12">
                      <a href="#" class="link-header-layer visible-xs">
                        <img src="images/home/informe1.png" alt="">
                      </a>
                      <img src="images/home/informe1.png" alt="" class="hidden-xs">
                    </div>
                    <div class="hidden-xs floating-text col-xs-9">
                        <p class="date">27 Agosto 2016</p>
                        <h1>Situación regulación</h1>
                    </div>
                </header>
                <div class="row data-container">
                    <a href="#" class="link-layer visible-xs">&nbsp;</a>
                    <div class="nopadding date">27 Agosto 2016</div>
                    <div class="main-card-data-container-title-wrapper">
                        <h1 class="title nopadding">
                            Situación regulación
                        </h1>
                    </div>
                    <p class="main-card-data-container-description-wrapper">Este mes tratamos los siguientes temas: el papel de la deuda para la absorción de Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <a href="#" class="hidden-xs mb-xs readmore">Leer más</a>
                    <footer>
                        <div class="icon-row">
                        
                            <div class="card-icon">
                                <span class="icon bbva-icon-quote"></span>
                                <div class="triangle triangle-up-left"></div>
                                <div class="triangle triangle-down-right"></div>
                            </div>
                        
                            <div class="card-icon">
                                <span class="icon bbva-icon-audio"></span>
                                <div class="triangle triangle-up-left"></div>
                                <div class="triangle triangle-down-right"></div>
                            </div>
                        
                            <div class="card-icon">
                                <span class="icon bbva-icon-comments"></span>
                                <div class="triangle triangle-up-left"></div>
                                <div class="triangle triangle-down-right"></div>
                            </div>
                        
                        </div>
                    </footer>
                </div>
            </section>
            <!-- EO main-card -->

                      </div>
                    
                      <div class="main-card-container col-xs-12 col-sm-4 noppading">
                        
            <!-- main-card -->
            <section class="container-fluid main-card">
                <header class="row header-container">
                    <div class="image-container col-xs-12">
                      <a href="#" class="link-header-layer visible-xs">
                        <img src="images/home/informe2.png" alt="">
                      </a>
                      <img src="images/home/informe2.png" alt="" class="hidden-xs">
                    </div>
                    <div class="hidden-xs floating-text col-xs-9">
                        <p class="date">24 Agosto 2016</p>
                        <h1>Heterogeneidad y difusión de la economía digital: el caso español.</h1>
                    </div>
                </header>
                <div class="row data-container">
                    <a href="#" class="link-layer visible-xs">&nbsp;</a>
                    <div class="nopadding date">24 Agosto 2016</div>
                    <div class="main-card-data-container-title-wrapper">
                        <h1 class="title nopadding">
                            Heterogeneidad y difusión de la economía digital: el caso español.
                        </h1>
                    </div>
                    <p class="main-card-data-container-description-wrapper">El tradicional modelo de Bass (1969) sobre adopción y difusión de nuevos productos Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <a href="#" class="hidden-xs mb-xs readmore">Leer más</a>
                    <footer>
                        <div class="icon-row">
                        
                            <div class="card-icon">
                                <span class="icon bbva-icon-quote"></span>
                                <div class="triangle triangle-up-left"></div>
                                <div class="triangle triangle-down-right"></div>
                            </div>
                        
                            <div class="card-icon">
                                <span class="icon bbva-icon-audio"></span>
                                <div class="triangle triangle-up-left"></div>
                                <div class="triangle triangle-down-right"></div>
                            </div>
                        
                        </div>
                    </footer>
                </div>
            </section>
            <!-- EO main-card -->

                      </div>
                    
                      <div class="main-card-container col-xs-12 col-sm-4 noppading">
                        
            <!-- main-card -->
            <section class="container-fluid main-card">
                <header class="row header-container">
                    <div class="image-container col-xs-12">
                      <a href="#" class="link-header-layer visible-xs">
                        <img src="images/home/informe3.png" alt="">
                      </a>
                      <img src="images/home/informe3.png" alt="" class="hidden-xs">
                    </div>
                    <div class="hidden-xs floating-text col-xs-9">
                        <p class="date">23 Agosto 2016</p>
                        <h1>Midiendo la inclusión financiera</h1>
                    </div>
                </header>
                <div class="row data-container">
                    <a href="#" class="link-layer visible-xs">&nbsp;</a>
                    <div class="nopadding date">23 Agosto 2016</div>
                    <div class="main-card-data-container-title-wrapper">
                        <h1 class="title nopadding">
                            Midiendo la inclusión financiera
                        </h1>
                    </div>
                    <p class="main-card-data-container-description-wrapper">Existe un amplio consenso respecto al rol que juega la inclusión financiera para rem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <a href="#" class="hidden-xs mb-xs readmore">Leer más</a>
                    <footer>
                        <div class="icon-row">
                        
                            <div class="card-icon">
                                <span class="icon bbva-icon-quote"></span>
                                <div class="triangle triangle-up-left"></div>
                                <div class="triangle triangle-down-right"></div>
                            </div>
                        
                            <div class="card-icon">
                                <span class="icon bbva-icon-audio"></span>
                                <div class="triangle triangle-up-left"></div>
                                <div class="triangle triangle-down-right"></div>
                            </div>
                        
                        </div>
                    </footer>
                </div>
            </section>
            <!-- EO main-card -->

                      </div>
                    

                  </div>
                </div>
                <footer>
                  <div class="row">
                    <div class="col-md-12 text-center">
                      <a href="#" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span> Ver más historias</a>
                    </div>
                  </div>
              </footer>
              </div>
            </section>
            <!-- EO latests-posts -->
            </article>
    </div>

<?php get_footer(); ?>