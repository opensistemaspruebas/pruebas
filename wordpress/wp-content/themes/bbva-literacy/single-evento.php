<?php

/*
    Template Name: Detalle de evento
*/

?>

<?php get_header(); ?>

<?php

    $evento_pasado = false;

    $evento_id = get_the_ID();
    $titulo = get_the_title();
    $imagenCabecera = get_post_meta($evento_id, 'imagenCabecera', true);
    $evento_localizacion = get_post_meta($evento_id, 'evento_localizacion', true);
    $evento_documento = get_post_meta($evento_id, 'evento_documento', true); 
    $evento_persona_de_contacto = get_post_meta($evento_id, 'evento_persona_de_contacto', true);
    $evento_localizacion = get_post_meta($evento_id, 'evento_localizacion', true);
    $evento_highlights = get_post_meta($evento_id, 'evento_highlights', true);
    $videoIntro_url = get_post_meta($evento_id, 'videoIntro-url', true);
    $video_type = get_post_meta($evento_id,'video-type',true); 
    $video_modal = '';  
    if ($video_type == 'wordpress') {
        $video_modal = get_post_meta($evento_id,'wp-video-url',true);
    } else if ($video_type == 'youtube') {
        $video_modal = get_post_meta($evento_id,'yt-video-url',true);          
    }


    $format = "Y-m-d";
    $evento_fecha_de_inicio = get_post_meta($evento_id, 'evento_fecha_de_inicio', true);
    $evento_fecha_de_final = get_post_meta($evento_id, 'evento_fecha_de_final', true);
    $dateobj_inicio = DateTime::createFromFormat($format, $evento_fecha_de_inicio);
    $dateobj_final = DateTime::createFromFormat($format, $evento_fecha_de_final);
    $fecha_evento = '';
    $meses = array(
        __("enero", "os_evento_futuro_widget"), 
        __("febrero", "os_evento_futuro_widget"), 
        __("marzo", "os_evento_futuro_widget"), 
        __("abril", "os_evento_futuro_widget"), 
        __("mayo", "os_evento_futuro_widget"), 
        __("junio", "os_evento_futuro_widget"), 
        __("julio", "os_evento_futuro_widget"), 
        __("agosto", "os_evento_futuro_widget"), 
        __("septiembre", "os_evento_futuro_widget"), 
        __("octubre", "os_evento_futuro_widget"), 
        __("noviembre", "os_evento_futuro_widget"), 
        __("diciembre", "os_evento_futuro_widget")
    );
    if ($dateobj_inicio->format('m') == $dateobj_final->format('m') && $dateobj_inicio->format('Y') == $dateobj_final->format('Y')) {
        $fecha_evento = $dateobj_inicio->format('d') . '-' . $dateobj_final->format('d') . ' ' . __('de', 'os_evento_futuro_widget') . ' ' . $meses[$dateobj_inicio->format('m') - 1] . ', ' . $dateobj_inicio->format('Y');
    } else if ($dateobj_inicio->format('Y') == $dateobj_final->format('Y')) {
        $fecha_evento = $dateobj_inicio->format('d') . ' ' . __('de', 'os_evento_futuro_widget') . ' ' . $meses[$dateobj_inicio->format('m') - 1] . '-' . $dateobj_final->format('d') . ' ' . __('de', 'os_evento_futuro_widget') . ' ' . $meses[$dateobj_final->format('m') - 1] . ', ' . $dateobj_inicio->format('Y');
    } else {
        $fecha_evento = $dateobj_inicio->format('d') . ' ' . __('de', 'os_evento_futuro_widget') . ' ' . $meses[$dateobj_inicio->format('m') - 1] . ', ' . $dateobj_inicio->format('Y') . '-' . $dateobj_final->format('d') . ' ' . __('de', 'os_evento_futuro_widget') . ' ' . $meses[$dateobj_final->format('m') - 1] . ', ' . $dateobj_final->format('Y');
    }
    $now = new DateTime();
    $dateobj_inicio->setTime(0,0,0);
    if ($now > $dateobj_inicio) {
        $evento_pasado = true;
    }
    $interval = $dateobj_inicio->diff($now);
    $evento_url_registro = get_post_meta($evento_id, 'evento_url_registro', true);
    $evento_descripcion_larga = get_post_meta($evento_id, 'evento_descripcion_larga', true);
    $evento_topics = get_post_meta($evento_id, 'evento_topics', true);
    $evento_te_interesas = get_post_meta($evento_id, 'evento_te_interesa', true);
    $evento_elemento_programa = get_post_meta($evento_id, 'evento_elemento_programa', true);
    if (!empty($evento_elemento_programa)) {
        $programa = array();
        foreach ($evento_elemento_programa as $e) {
            $dia = $e['dia'];
            $programa[$dia][] = $e;
        }
    }

?>

<div class="contents">
    <div id="search-layer"></div>
    <div class="<?php if ($evento_pasado) echo 'pastEvents'; else echo 'futureEvents'; ?>">
        <?php if ($evento_pasado == false && !empty($imagenCabecera)) : ?>
        <section class="block-image wow fadeInUp">
            <div class="visible-xs">
                <h1 class="screen-title mt-xs mb-sm"><?php echo $titulo; ?></h1><img class="img-responsive" src="<?php echo $imagenCabecera; ?>" alt="image title" />
                <div class="container">
                    <div class="content-center">
                        <div class="text-center mgt-25">
                            <span><span class="icon bbva-icon-calendar-01 mr-xs"></span><?php echo $fecha_evento; ?></span>
                            <span class="mgl-13"><span class="icon bbva-icon-pin mr-xs"></span><?php echo $evento_localizacion[2]; ?></span>
                        </div>
                        <?php if ($evento_url_registro) : ?>
                            <div class="container-button mb-lg mt-lg"><a href="" class="text-center btn btn-bbva-aqua"><?php _e('Registrarme'); ?></a></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="hidden-xs"><img class="img-responsive" src="<?php echo $imagenCabecera; ?>" alt="image title" />
                <div class="container">
                    <div class="block-content-center">
                        <div class="row">
                            <div class="text-center mt-md"><span class="icon bbva-icon-calendar-01 mr-xs"></span><?php echo $fecha_evento; ?> <span class="icon bbva-icon-pin mr-xs mgl-20"></span><?php echo $evento_localizacion[2]; ?> </div>
                        </div>
                        <h1 class="screen-title mt-xs mb-sm"><?php echo $titulo; ?></h1>
                        <div id="timezone" class="time">
                            <div class="days ml-md mr-md"><?php echo $interval->format('d'); ?><label><?php _e('DIAS'); ?></label></div>
                            <div class="hours mr-md"><?php echo $interval->format('h'); ?><label><?php _e('HORAS'); ?></label></div>
                            <div class="minutes mr-md"><?php echo $interval->format('i'); ?><label><?php _e('MINUTOS'); ?></label></div>
                        </div>
                        <?php if ($evento_url_registro) : ?>
                            <div class="container-button mt-lg"><a target="_blank" href="<?php echo $evento_url_registro; ?>" class="text-center btn btn-bbva-aqua"><?php _e('Registrarme'); ?></a></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        <?php if ($evento_pasado && !(empty($videoIntro_url))) : ?>
            <div class="video-container">
                <video src="<?php echo $videoIntro_url; ?>" autoplay loop="loop" preload="auto" controls="false"></video>
                <div class="video-text">
                    <div class="hidden-xs info mt-xxl">
                        <span class="mr-md">
                            <span class="icon bbva-icon-calendar-01"></span>
                            <span><?php echo $fecha_evento; ?></span>
                        </span>
                        <span class="">
                            <span class="icon bbva-icon-pin"></span>
                            <span><?php echo $evento_localizacion[2]; ?></span>
                        </span>
                    </div>
                    <h1><?php echo $titulo; ?></h1>
                    <?php if (!empty($video_modal)) : ?>
                    <button type="button" class="play-button" name="button" data-toggle="modal" data-target="#pastEventsModal"><span class="icon-play bbva-icon-play"></span></button>
                    <?php endif; ?>
                </div>
                <?php if (!empty($video_modal)) : ?>
                <!-- Modal -->
                <div class="modal fade" id="pastEventsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="bbva-icon-close" aria-hidden="true"></span></button>
                            </div>
                            <div class="modal-body">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="<?php echo $video_modal; ?>"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="container content-wrap mb-xl">
            <?php get_template_part('content','rrsseventos'); ?>
            <?php if ($evento_pasado && !empty($evento_highlights)) : ?>
                <section class="highlights-section mt-xl">
                    <h1 class="mb-md mt-md"><?php _e('Highlights'); ?></h1>
                        <?php $m = 0; ?>
                        <?php foreach ($evento_highlights as $h) : ?>
                            <?php if (empty($h)) continue; else $m++; ?>
                            <div class="row mb-md">
                                <div class="col-xs-1 card-icon icon-publication ml-xs"><span><?php echo $m; ?></span>
                                    <div class="triangle triangle-up-left"></div>
                                    <div class="triangle triangle-down-right"></div>
                                </div>
                                <span class="highlight-text"><?php echo $h; ?></span>
                            </div>
                        <?php endforeach; ?>
                </section>
            <?php endif; ?>
            <?php if (!empty($evento_descripcion_larga)) : ?>
                <section class="description-section mt-lg">
                    <h1 class="mb-md"><?php _e('Descripción'); ?></h1>
                    <?php echo wpautop($evento_descripcion_larga); ?>
                </section>
            <?php endif; ?>
            <?php if (!empty($evento_topics)) : ?>
                <section class="topics-section mt-lg">
                    <h1 class="mb-md"><?php _e('Temas'); ?></h1>
                    <div class="row">
                        <?php foreach ($evento_topics as $evento_topic) : ?>
                            <div class="col-xs-12">
                                <div class="rectangle"></div>
                                <div class="pre-rectangle"></div>
                                <p class="topics-section-topic-text"><?php echo $evento_topic; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
            <?php if ($evento_pasado == false && !empty($evento_te_interesas)) : ?>
                <section class="interest-section mt-lg">
                    <h1 class="mb-md"><?php _e('Te interesa si...'); ?></h1>
                    <div class="row">
                        <?php foreach ($evento_te_interesas as $evento_te_interesa) : ?>
                            <div class="col-xs-12">
                                <div class="rectangle"></div>
                                <div class="pre-rectangle"></div>
                                <p><?php echo $evento_te_interesa; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
            <?php if (!empty($evento_documento)) : ?>
                <section class="file-section mt-lg">
                      <h1 class="mb-md"><?php _e('Ficha del evento'); ?></h1>
                      <div class="pdf-rectangle">
                          <div class="row">
                              <div class="col-xs-12 col-sm-1">
                                  <span class="icon bbva-icon-pdf-01"></span>
                              </div>
                              <div class="col-xs-12 col-sm-6">
                                  <h2 class="ml-md mt-md"><?php _e('Descarga el programa'); ?></h2>
                                  <p class="hidden-xs ml-md"><?php _e('Consulta y/o descarga el PDF del evento'); ?></p>
                              </div>
                              <div class="col-xs-12 col-sm-3 col-sm-offset-1">
                                  <div class="container-button mb-md mt-md">
                                      <a href="<?php echo $evento_documento; ?>" target="_blank" class="btn btn-bbva-aqua"><?php _e('Ver PDF'); ?></a>
                                  </div>
                              </div>
                          </div>
                      </div>
                </section>
            <?php endif; ?>
            <?php if ($evento_pasado == false && !empty($programa)) : ?>
                <section class="program-section mt-lg">
                    <h1 class="mb-md"><?php _e('Programa'); ?></h1>
                    <div class="visible-xs">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="dropdown mb-md">
                                <?php 

                                    foreach ($programa as $p) {
                                        $dia = $p[0]['dia'];
                                        if (!empty($dia)) {
                                            $dateobj_dia = DateTime::createFromFormat($format, $dia);
                                            $dia_formateado =  __('Día', 'os_evento_futuro_widget') . ' ' . $dateobj_dia->format('d') . ' ' . __('de', 'os_evento_futuro_widget') . ' ' . $meses[$dateobj_dia->format('m') - 1] . ' ' . $dateobj_dia->format('Y');   
                                        }
                                        break;
                                    }

                                ?>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $dia_formateado; ?><span class="icon bbva-icon-arrow_bottom"></span></a>
                                <ul class="dropdown-menu">
                                    <?php $l = 1; ?>
                                    <?php foreach ($programa as $p) : ?>
                                        <?php
                                            
                                            $dia = $p[0]['dia'];
                                            if (!empty($dia)) {
                                                $dateobj_dia = DateTime::createFromFormat($format, $dia);
                                                $dia_formateado =  __('Día', 'os_evento_futuro_widget') . ' ' . $dateobj_dia->format('d') . ' ' . __('de', 'os_evento_futuro_widget') . ' ' . $meses[$dateobj_dia->format('m') - 1] . ' ' . $dateobj_dia->format('Y');   
                                            }
                                        ?>
                                        <li role="presentation"><a href="#day<?php echo $l; ?>" aria-controls="day<?php echo $l; ?>" role="tab" data-toggle="tab"><?php echo $dia_formateado; ?></a></li>
                                        <?php $l++; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <?php $j = 1; ?>
                            <?php foreach ($programa as $p) : ?>
                                <?php 

                                    $active = '';
                                    if ($j == 1) $active = 'active';

                                ?>
                                <div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="day<?php echo $j; ?>">
                                    <div>
                                        <div class="program visible-xs">
                                            <div class="program-day">
                                                <div class="program-content">
                                                    <?php 

                                                        $numItems = count($p);
                                                        $k = 0;

                                                    ?>
                                                    <?php foreach ($p as $e) : ?>
                                                        <?php

                                                            $inicio = $e['inicio'];
                                                            $duracion = $e['duracion'];
                                                            $titulo = $e['titulo'];
                                                            $descripcion = $e['descripcion'];
                                                            $ponentes = $e['ponentes'];
                                                            $moderador = $e['moderador'];
                                                            $tipo = $e['tipo'];

                                                            $class = '';
                                                            if ($tipo == "descanso") {
                                                                $class = "break";
                                                                if (++$i === $numItems) {
                                                                    $class .= ' last-child';
                                                                }
                                                            }

                                                        ?>
                                                        <div class="individual-info animate fadeIn <?php echo $class; ?>">
                                                            <div class="col-xs-1 nopadding">
                                                                <?php if ($tipo !== "descanso") : ?>
                                                                    <div class="redbullet"></div>
                                                                <?php else : ?>
                                                                    <span class="break-icon bbva-icon-coffe"></span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="col-xs-11">
                                                                <div class="time">
                                                                    <span class="hour">
                                                                        <?php echo $inicio; if ($tipo == "descanso") echo ' ' . $titulo; ?>
                                                                        <span class="duration">(<?php echo $duracion; ?>)</span>
                                                                    </span>
                                                                </div>
                                                                <?php if ($tipo !== "descanso") : ?>
                                                                    <div class="information-xs talk-bubble tri-right">
                                                                        <div class="talktext">
                                                                            <h3 class="ml-md pr-md pt-md"><?php echo $titulo; ?></h3>
                                                                            <p class="ml-md pr-md"><?php echo $descripcion; ?></p>
                                                                            <?php if (!empty($moderador)) : ?>
                                                                                <p class="ml-md pr-md pb-md">
                                                                                    <?php _e('Moderador', 'os_evento_futuro_widget'); ?>:
                                                                                    <strong class="ml-xs"><?php echo $moderador; ?></strong>
                                                                                </p>
                                                                            <?php endif; ?>
                                                                            <?php if (!empty($ponentes)) : ?>
                                                                                <p class="ml-md pr-md pb-md">
                                                                                    <?php _e('Ponentes', 'os_evento_futuro_widget'); ?>:
                                                                                    <?php foreach ($ponentes as $p) : ?>
                                                                                        <?php if (has_term('asesor', 'perfil', $p)) : ?>
                                                                                            <?php
                                                                                                $idioma = '';
                                                                                                if (ICL_LANGUAGE_CODE !== 'es') {
                                                                                                    $idioma = '/en';
                                                                                                }
                                                                                                $post_slug = $idioma . '/perfiles/' . str_replace('cap-' , '', get_post_field( 'post_name', get_post($p) ));
                                                                                            ?>
                                                                                            <strong class="ml-xs"><a href="<?php echo $post_slug; ?>"><?php echo get_the_title($p); ?></a></strong>
                                                                                        <?php else : ?>
                                                                                            <strong class="ml-xs"><?php echo get_the_title($p); ?></strong>
                                                                                        <?php endif; ?>
                                                                                    <?php endforeach; ?>
                                                                                </p>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="program hidden-xs">
                                            <div class="program-day"></div>
                                        </div>
                                    </div>
                                </div>
                                <?php $j++; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="hidden-xs">
                        <div class="program visible-xs">
                            <div class="program-day">
                                <div class="program-content"></div>
                            </div>
                        </div>
                        <div class="program hidden-xs">
                            <div class="program-day">
                                <?php foreach ($programa as $p) : ?>
                                    <?php 

                                    if (!empty($dia)) {
                                        $dia = $p[0]['dia'];
                                        $dateobj_dia = DateTime::createFromFormat($format, $dia);
                                        $dia_formateado =  __('Día', 'os_evento_futuro_widget') . ' ' . $dateobj_dia->format('d') . ' ' . __('de', 'os_evento_futuro_widget') . ' ' . $meses[$dateobj_dia->format('m') - 1] . ' ' . $dateobj_dia->format('Y');
                                    }
                                    
                                    ?>
                                    <h2 class="mt-xl"><?php echo $dia_formateado; ?></h2>
                                    <div class="program-content">
                                        <?php

                                            $numItems = count($p);
                                            $i = 0;

                                        ?>
                                        <?php foreach ($p as $e) : ?>
                                            <?php 
                                            
                                                $inicio = $e['inicio'];
                                                $duracion = $e['duracion'];
                                                $titulo = $e['titulo'];
                                                $descripcion = $e['descripcion'];
                                                $ponentes = $e['ponentes'];
                                                $moderador = $e['moderador'];
                                                $tipo = $e['tipo'];

                                                $class = '';
                                                if ($tipo == "descanso") {
                                                    $class = "break";
                                                    if (++$i === $numItems) {
                                                        $class .= ' last-child';
                                                    }
                                                }


                                            ?>
                                            <div class="individual-info wow <?php echo $class; ?>">
                                                <div class="redbullet"></div>
                                                <div class="time">
                                                    <span class="hour"><?php echo $inicio; ?></span>
                                                    <span class="duration">(<?php echo $duracion; ?>)</span>
                                                </div>
                                                <?php if ($tipo !== "descanso") : ?>
                                                    <div class="information ml-sm talk-bubble tri-right left-top">
                                                        <div class="talktext">
                                                            <h3 class="ml-md"><?php echo $titulo; ?></h3>
                                                            <p class="ml-md"><?php echo $descripcion; ?></p>
                                                            <?php if (!empty($moderador)) : ?>
                                                                <p class="ml-md">
                                                                    <?php _e('Moderador', 'os_evento_futuro_widget'); ?>:
                                                                    <strong class="ml-xs"><?php echo $moderador; ?></strong>
                                                                </p>
                                                            <?php endif; ?>
                                                            <?php if (!empty($ponentes)) : ?>
                                                            <p class="ml-md mb-md">
                                                                <?php _e('Ponentes', 'os_evento_futuro_widget'); ?>:
                                                                <?php foreach ($ponentes as $p) : ?>
                                                                    <?php if (has_term('asesor', 'perfil', $p)) : ?>
                                                                        <?php
                                                                            $idioma = '';
                                                                            if (ICL_LANGUAGE_CODE !== 'es') {
                                                                                $idioma = '/en';
                                                                            }
                                                                            $post_slug = $idioma . '/perfiles/' . str_replace('cap-' , '', get_post_field( 'post_name', get_post($p) ));
                                                                        ?>
                                                                        <strong class="ml-xs"><a href="<?php echo $post_slug; ?>"><?php echo get_the_title($p); ?></a></strong>
                                                                    <?php else : ?>
                                                                        <strong class="ml-xs"><?php echo get_the_title($p); ?></strong>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="coffee-break">
                                                        <span class="bbva-icon-coffe"></span>
                                                        <span class="text"><?php echo $titulo; ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        </div>
        <?php if ($evento_pasado == false && !empty($evento_persona_de_contacto)) : ?>
            <section class="contact-person">
                <div class="container content-wrap">
                    <h1 class="mt-xl"><?php _e('Persona de contacto'); ?></h1>
                    <h2 class="mb-md"><?php _e('Si tienes alguna duda sobre el evento, puedes ponerte en contacto con:'); ?></h2>
                    <!-- person -->
                    <section class="container-fluid person">
                        <a href="#" class="link-layer visible-xs">&nbsp;</a>
                        <div class="image-wrapper"><img src="<?php echo $evento_persona_de_contacto[2]; ?>" alt="" /></div>
                        <div class="data-wrapper"><span><?php echo $evento_persona_de_contacto[0]; ?></span>
                            <p><?php echo $evento_persona_de_contacto[1]; ?></p>
                            <a href="mailto:<?php echo $evento_persona_de_contacto[3]; ?>"><?php echo $evento_persona_de_contacto[3]; ?></a>
                    </section>
                    <!-- EO person -->
                </div>
            </section>
        <?php endif; ?>
        <?php if ($evento_pasado == false &&  $evento_url_registro) : ?>
            <section class="attend">
                <div class="container content-wrap">
                    <div class="row mb-lg">
                        <h1 class="col-xs-12 col-sm-7"><?php _e('Quiero asistir'); ?></h1>
                        <div class="col-xs-12 col-sm-offset-1 col-sm-4 text-right container-button">
                            <a target="_blank" href="<?php echo $evento_url_registro; ?>" class="btn btn-bbva-aqua"><?php _e('Registrarme'); ?></a>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <?php if ($evento_pasado == false && !empty($evento_localizacion)) : ?>
            <?php

                $dataEvents = array();
                $dataEvents['id'] = $evento_id;
                $dataEvents['title'] = $evento_localizacion[0];
                $dataEvents['content'] = $evento_localizacion[1];
                $dataEvents['distance'] = $evento_localizacion[5];
                $dataEvents['latitude'] = $evento_localizacion[3];
                $dataEvents['longitude'] = $evento_localizacion[4];

                echo "<script>var dataEvents = [" . json_encode($dataEvents) . "];</script>";

            ?>
            <section id="mapSection" class="map-section id-<?php echo $evento_id; ?>"></section>
        <?php endif; ?>
    </div>
    <?php
        $color = "blanco";
        if ($evento_pasado) {
            $color = 'gris';
        } 
        the_widget('os_prefooter_bbva', array('color_fondo' => $color, 'menu_derecho' => 'enlaces-de-interes', 'menu_central' => 'en-el-mundo', 'menu_izquierdo' => 'sobre-educacion-financiera')); 
    ?>
</div>

<?php get_footer(); ?>