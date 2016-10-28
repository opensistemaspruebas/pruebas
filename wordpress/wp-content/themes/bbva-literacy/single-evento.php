<?php

/*
    Template Name: Detalle de evento
*/

?>

<?php get_header(); ?>

<?php

    $evento_id = get_the_ID();

    $titulo = get_the_title();

    $imagenCabecera = get_post_meta($evento_id, 'imagenCabecera', true);

    $evento_localizacion = get_post_meta($evento_id, 'evento_localizacion', true);

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

    $interval = $dateobj_inicio->diff($now);

    $evento_url_registro = get_post_meta($evento_id, 'evento_url_registro', true);

    $evento_descripcion_larga = get_post_meta($evento_id, 'evento_descripcion_larga', true);

    $evento_topics = get_post_meta($evento_id, 'evento_topics', true);

    $evento_te_interesas = get_post_meta($evento_id, 'evento_te_interesa', true);

    $evento_elemento_programa = get_post_meta($evento_id, 'evento_elemento_programa', true);
    if (!empty($evento_elemento_programa)) {
        $sortArray = array(); 
        foreach($evento_elemento_programa as $e){ 
            foreach($e as $key=>$value){ 
                if(!isset($sortArray[$key])){ 
                    $sortArray[$key] = array(); 
                } 
                $sortArray[$key][] = $value; 
            } 
        } 
        $orderby = "dia"; //change this to whatever key you want from the array 
        array_multisort($sortArray[$orderby],SORT_ASC,$evento_elemento_programa);
        $programa = array();
        foreach ($evento_elemento_programa as $e) {
            $dia = $e['dia'];
            $programa[$dia][] = $e;
        }
    }



    $evento_documento = get_post_meta($evento_id, 'evento_documento', true); 

    $evento_persona_de_contacto = get_post_meta($evento_id, 'evento_persona_de_contacto', true);

    $evento_localizacion = get_post_meta($evento_id, 'evento_localizacion', true);




?>

<div class="contents">
    <div id="search-layer"></div>
    <div class="futureEvents">
        
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
        <div class="container content-wrap mb-xl">
            <?php get_template_part('content','rrsseventos'); ?>
            <?php if (!empty($evento_descripcion_larga)) : ?>
                <section class="description-section">
                    <h1 class="mb-md"><?php _e('Descripción'); ?></h1>
                    <?php echo wpautop($evento_descripcion_larga); ?>
                </section>
            <?php endif; ?>
            <?php if (!empty($evento_topics)) : ?>
                <section class="topics-section mt-lg">
                    <h1 class="mb-md"><?php _e('Topics'); ?></h1>
                    <div class="row">
                        <?php foreach ($evento_topics as $evento_topic) : ?>
                            <div class="col-xs-12">
                                <div class="rectangle"></div>
                                <div class="pre-rectangle"></div>
                                <p><?php echo $evento_topic; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
            <?php if (!empty($evento_te_interesas)) : ?>
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
            <?php if (!empty($programa)) : ?>
                <section class="program-section mt-lg">
                    <h1 class="mb-md"><?php _e('Programa'); ?></h1>
                    <div class="visible-xs">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="dropdown mb-md"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Día 22 de octubre 2017<span class="icon bbva-icon-arrow_bottom"></span></a>
                                <ul class="dropdown-menu">
                                    <li role="presentation"><a href="#day1" aria-controls="day1" role="tab" data-toggle="tab">Día 22 de octubre 2017</a></li>
                                    <li role="presentation"><a href="#day2" aria-controls="day2" role="tab" data-toggle="tab">Día 25 de mayo 2018</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane  active " id="day1">
                                <div>
                                    <div class="program visible-xs">
                                        <div class="program-day">
                                            <div class="program-content">
                                                <div class="individual-info  animate fadeIn  ">
                                                    <div class="col-xs-1 nopadding">
                                                        <div class="redbullet"></div>
                                                    </div>
                                                    <div class="col-xs-11">
                                                        <div class="time"><span class="hour">12:00 <span class="duration">(45min)</span></span>
                                                        </div>
                                                        <div class="information-xs talk-bubble tri-right">
                                                            <div class="talktext">
                                                                <h3 class="ml-md pr-md pt-md">Lorem ipsum dolor sit amet</h3>
                                                                <p class="ml-md pr-md">This piece on Europe will focus on must-see places in the United Kingdom, France, Spain, Portugal, and Italy.</p>
                                                                <p class="ml-md pr-md pb-md">Ponente:<strong class="ml-xs">Carlos Pérez</strong></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="individual-info  animate fadeIn  break">
                                                    <div class="col-xs-1 nopadding"><span class="break-icon bbva-icon-coffe"></span></div>
                                                    <div class="col-xs-11">
                                                        <div class="time"><span class="hour">13:00 Coffe break <span class="duration">(15min)</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="individual-info last-child animate fadeIn  ">
                                                    <div class="col-xs-1 nopadding">
                                                        <div class="redbullet"></div>
                                                    </div>
                                                    <div class="col-xs-11">
                                                        <div class="time"><span class="hour">14:00 <span class="duration">(45min)</span></span>
                                                        </div>
                                                        <div class="information-xs talk-bubble tri-right">
                                                            <div class="talktext">
                                                                <h3 class="ml-md pr-md pt-md">Lorem ipsum dolor sit amet</h3>
                                                                <p class="ml-md pr-md">This piece on Europe will focus on must-see places in the United Kingdom, France, Spain, Portugal, and Italy.</p>
                                                                <p class="ml-md pr-md pb-md">Ponente:<strong class="ml-xs">Carlos Pérez</strong></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="program hidden-xs">
                                        <div class="program-day"></div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane " id="day2">
                                <div>
                                    <div class="program visible-xs">
                                        <div class="program-day">
                                            <div class="program-content">
                                                <div class="individual-info  animate fadeIn  ">
                                                    <div class="col-xs-1 nopadding">
                                                        <div class="redbullet"></div>
                                                    </div>
                                                    <div class="col-xs-11">
                                                        <div class="time"><span class="hour">22:00 <span class="duration">(45min)</span></span>
                                                        </div>
                                                        <div class="information-xs talk-bubble tri-right">
                                                            <div class="talktext">
                                                                <h3 class="ml-md pr-md pt-md">Lorem ipsum dolor sit amet</h3>
                                                                <p class="ml-md pr-md">This piece on Europe will focus on must-see places in the United Kingdom, France, Spain, Portugal, and Italy.</p>
                                                                <p class="ml-md pr-md pb-md">Ponente:<strong class="ml-xs">Carlos Pérez</strong></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="individual-info  animate fadeIn  break">
                                                    <div class="col-xs-1 nopadding"><span class="break-icon bbva-icon-coffe"></span></div>
                                                    <div class="col-xs-11">
                                                        <div class="time"><span class="hour">23:00 Coffe break <span class="duration">(15min)</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="individual-info  animate fadeIn  ">
                                                    <div class="col-xs-1 nopadding">
                                                        <div class="redbullet"></div>
                                                    </div>
                                                    <div class="col-xs-11">
                                                        <div class="time"><span class="hour">24:00 <span class="duration">(45min)</span></span>
                                                        </div>
                                                        <div class="information-xs talk-bubble tri-right">
                                                            <div class="talktext">
                                                                <h3 class="ml-md pr-md pt-md">Lorem ipsum dolor sit amet</h3>
                                                                <p class="ml-md pr-md">This piece on Europe will focus on must-see places in the United Kingdom, France, Spain, Portugal, and Italy.</p>
                                                                <p class="ml-md pr-md pb-md">Ponente:<strong class="ml-xs">Carlos Pérez</strong></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="individual-info last-child animate fadeIn  ">
                                                    <div class="col-xs-1 nopadding">
                                                        <div class="redbullet"></div>
                                                    </div>
                                                    <div class="col-xs-11">
                                                        <div class="time"><span class="hour">01:00 <span class="duration">(45min)</span></span>
                                                        </div>
                                                        <div class="information-xs talk-bubble tri-right">
                                                            <div class="talktext">
                                                                <h3 class="ml-md pr-md pt-md">Lorem ipsum dolor sit amet</h3>
                                                                <p class="ml-md pr-md">This piece on Europe will focus on must-see places in the United Kingdom, France, Spain, Portugal, and Italy.</p>
                                                                <p class="ml-md pr-md pb-md">Ponente:<strong class="ml-xs">Carlos Pérez</strong></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="program hidden-xs">
                                        <div class="program-day"></div>
                                    </div>
                                </div>
                            </div>
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
                                    <h2 class="mt-xl">Día 22 de octubre 2017 <?php echo $p[0]['dia']; ?></h2>
                                    <div class="program-content">
                                        <div class="individual-info  wow fadeIn ">
                                            <div class="redbullet"></div>
                                            <div class="time"><span class="hour">12:00</span><span class="duration">(45min)</span></div>
                                            <div class="information ml-sm talk-bubble tri-right left-top">
                                                <div class="talktext">
                                                    <h3 class="ml-md">Lorem ipsum dolor sit amet</h3>
                                                    <p class="ml-md">This piece on Europe will focus on must-see places in the United Kingdom, France, Spain, Portugal, and Italy.</p>
                                                    <p class="ml-md mb-md">Ponente:<strong class="ml-xs">Carlos Pérez</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="individual-info  wow fadeIn break">
                                            <div class="redbullet"></div>
                                            <div class="time"><span class="hour">13:00</span><span class="duration">(15min)</span></div>
                                            <div class="coffee-break"><span class="bbva-icon-coffe"></span><span class="text">Coffee Break</span></div>
                                        </div>
                                        <div class="individual-info last-child wow fadeIn ">
                                            <div class="redbullet"></div>
                                            <div class="time"><span class="hour">14:00</span><span class="duration">(45min)</span></div>
                                            <div class="information ml-sm talk-bubble tri-right left-top">
                                                <div class="talktext">
                                                    <h3 class="ml-md">Lorem ipsum dolor sit amet</h3>
                                                    <p class="ml-md">This piece on Europe will focus on must-see places in the United Kingdom, France, Spain, Portugal, and Italy.</p>
                                                    <p class="ml-md mb-md">Ponente:<strong class="ml-xs">Carlos Pérez</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            <?php if (!empty($evento_documento)) : ?>
                <section class="hidden-xs file-section mt-lg">
                    <h1 class="mb-md">Ficha del evento</h1>
                    <div class="pdf-rectangle">
                        <div class="row">
                            <div class="col-xs-12 col-sm-1"><span class="icon bbva-icon-pdf-01"></span></div>
                            <div class="col-xs-12 col-sm-6">
                                <h2 class="ml-md"><?php _e('Descarga el programa'); ?></h2>
                                <p class="ml-md"><?php _e('Consulta y/o descarga el PDF del evento'); ?></p>
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
        </div>
        <?php if (!empty($evento_persona_de_contacto)) : ?>
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
                    </section>
                    <!-- EO person -->
                </div>
            </section>
        <?php endif; ?>
        <?php if ($evento_url_registro) : ?>
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
        <?php if (!empty($evento_localizacion)) : ?>
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
    <?php the_widget('os_prefooter', array('color_fondo' => 'blanco', 'menu_derecho' => 'enlaces-de-interes', 'menu_central' => 'en-el-mundo', 'menu_izquierdo' => 'sobre-educacion-financiera')); ?>
</div>

<?php get_footer(); ?>