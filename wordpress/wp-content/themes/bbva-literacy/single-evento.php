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
                        <div class="container-button mb-lg mt-lg"><a href="" class="text-center btn btn-bbva-aqua"><?php _e('Registrarme'); ?></a></div>
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
            <section class="description-section">
                <h1 class="mb-md">Descripción</h1>
                <p> This piece on Europe will focus on must-see places in the United Kingdom, France, Spain, Portugal, and Italy. Power up your printers, make copies of this list, and start jotting down notes that can help you create the summer of your dreams. The food in Europe is some of the best you'll find in the world, which can make it tempting to splurge. Fight this temptation and go to local markets and have picnics in parks instead. If you must go out to eat, limit those excursions to a few times per week and only go to the places that are packed with locals. France's capital, the City of Light, is a wanderer's dream, with an exciting mix of wide boulevards and tiny brick alleyways hiding delicious restaurants and boutique shops. When in Paris, it's best to take in the city by walking until you can't walk anymore. Picnic in front of the Eiffel Tower, take a nighttime boat ride down the Seine, and relax in the Luxembourg Gardens. Florence is a magical city filled with historical attractions, art galleries, and tempting gelato shops. Among the many must-dos is climbing a hill on the south side of the Arno River to Piazzale Michelangelo. This is a lookout point with tiered seating that offers some of the city's best views, especially at sunset. If you're lucky, street performers will serenade you as the sun goes down. </p>
            </section>
            <section class="topics-section mt-lg">
                <h1 class="mb-md">Topics</h1>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="rectangle"></div>
                        <div class="pre-rectangle"></div>
                        <p>Introductory purchase & balance transfer APRs</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="rectangle"></div>
                        <div class="pre-rectangle"></div>
                        <p>CompassPoints rewards program</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="rectangle"></div>
                        <div class="pre-rectangle"></div>
                        <p>No annual fee</p>
                    </div>
                </div>
            </section>
            <section class="interest-section mt-lg">
                <h1 class="mb-md">Te interesa si...</h1>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="rectangle"></div>
                        <div class="pre-rectangle"></div>
                        <p>Introductory purchase & balance transfer APRs</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="rectangle"></div>
                        <div class="pre-rectangle"></div>
                        <p>CompassPoints rewards program</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="rectangle"></div>
                        <div class="pre-rectangle"></div>
                        <p>No annual fee</p>
                    </div>
                </div>
            </section>
            <section class="program-section mt-lg">
                <h1 class="mb-md">Programa</h1>
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
                            <h2 class="mt-xl">Día 22 de octubre 2017</h2>
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
                            <h2 class="mt-xl">Día 25 de mayo 2018</h2>
                            <div class="program-content">
                                <div class="individual-info  wow fadeIn ">
                                    <div class="redbullet"></div>
                                    <div class="time"><span class="hour">22:00</span><span class="duration">(45min)</span></div>
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
                                    <div class="time"><span class="hour">23:00</span><span class="duration">(15min)</span></div>
                                    <div class="coffee-break"><span class="bbva-icon-coffe"></span><span class="text">Coffee Break</span></div>
                                </div>
                                <div class="individual-info  wow fadeIn ">
                                    <div class="redbullet"></div>
                                    <div class="time"><span class="hour">24:00</span><span class="duration">(45min)</span></div>
                                    <div class="information ml-sm talk-bubble tri-right left-top">
                                        <div class="talktext">
                                            <h3 class="ml-md">Lorem ipsum dolor sit amet</h3>
                                            <p class="ml-md">This piece on Europe will focus on must-see places in the United Kingdom, France, Spain, Portugal, and Italy.</p>
                                            <p class="ml-md mb-md">Ponente:<strong class="ml-xs">Carlos Pérez</strong></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="individual-info last-child wow fadeIn ">
                                    <div class="redbullet"></div>
                                    <div class="time"><span class="hour">01:00</span><span class="duration">(45min)</span></div>
                                    <div class="information ml-sm talk-bubble tri-right left-top">
                                        <div class="talktext">
                                            <h3 class="ml-md">Lorem ipsum dolor sit amet</h3>
                                            <p class="ml-md">This piece on Europe will focus on must-see places in the United Kingdom, France, Spain, Portugal, and Italy.</p>
                                            <p class="ml-md mb-md">Ponente:<strong class="ml-xs">Carlos Pérez</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="hidden-xs file-section mt-lg">
                <h1 class="mb-md">Ficha del evento</h1>
                <div class="pdf-rectangle">
                    <div class="row">
                        <div class="col-xs-12 col-sm-1"><span class="icon bbva-icon-pdf-01"></span></div>
                        <div class="col-xs-12 col-sm-6">
                            <h2 class="ml-md">Descarga el programa</h2>
                            <p class="ml-md">Consulta y/o descarga el PDF del evento</p>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-sm-offset-1">
                            <div class="container-button mb-md mt-md"><a href="" class="btn btn-bbva-aqua">Ver PDF</a></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <section class="contact-person">
            <div class="container content-wrap">
                <h1 class="mt-xl">Persona de contacto</h1>
                <h2 class="mb-md">Si tienes alguna duda sobre el evento, puedes ponerte en contacto con:</h2>
                <!-- person -->
                <section class="container-fluid person"><a href="#" class="link-layer visible-xs">&nbsp;</a>
                    <div class="image-wrapper"><img src="images/about-us/avatar1.png" alt="" /></div>
                    <div class="data-wrapper"><span>Diana Repiso</span>
                        <p>Doctora honoris causa de estadística por la Universidad Complutense.</p><a href="#">Ficha de la asesora</a></div>
                </section>
                <!-- EO person -->
            </div>
        </section>
        <section class="attend">
            <div class="container content-wrap">
                <div class="row mb-lg">
                    <h1 class="col-xs-12 col-sm-7">Quiero asistir</h1>
                    <div class="col-xs-12 col-sm-offset-1 col-sm-4 text-right container-button"><a href="" class="btn btn-bbva-aqua">Registrarme</a></div>
                </div>
            </div>
        </section>
        <section id="mapSection" class="map-section id-2015"></section>
    </div>
    <?php the_widget('os_prefooter', array('color_fondo' => 'blanco', 'menu_derecho' => 'enlaces-de-interes', 'menu_central' => 'en-el-mundo', 'menu_izquierdo' => 'sobre-educacion-financiera')); ?>
</div>

<?php get_footer(); ?>