<?php
/*Template Name: Página de co-autor */
?>

<?php
    
    $author_name = get_query_var('coauthor', 'nada');
?>

<?php get_header(); ?>

<?php 

	$found_post = null;

	if ( $posts = get_posts( array( 
	    'name' => 'cap-' . $author_name, 
	    'post_type' => 'guest-author',
	    'post_status' => 'publish',
	    'posts_per_page' => 1,
        'suppress_filters' => false,
	) ) ) $found_post = $posts[0];

	$post_id = $found_post->ID;

    $tipo = get_post_meta($post_id, 'tipo', true);
    if (empty($tipo))
        $tipo = 'minimos';


    $nombre = $cargo = $imagen_perfil = $descripcion = $lugar_trabajo = $logo_trabajo = $area_expertise_1 = $area_expertise_2 = $area_expertise_3 = $linkedin = $twitter = $correo_electronico = $url_web = $imagen_cabecera = $frase_cabecera = '';
    $trabajos = array();

    $lang = ICL_LANGUAGE_CODE;
    $sufijo = '';
    if($lang == 'en')
        $sufijo = '-en';

    $nombre = get_post_meta($post_id, 'cap-display_name', true);
    $cargo = get_post_meta($post_id, 'cargo' . $sufijo, true);
    $imagen_perfil = get_post_meta($post_id, 'imagen_perfil', true);
    $descripcion = get_post_meta($post_id, 'descripcion' . $sufijo, true);
    $lugar_trabajo = get_post_meta($post_id, 'lugar_trabajo' . $sufijo, true);
    $logo_trabajo = get_post_meta($post_id, 'logo_trabajo', true);
    $area_expertise_1 = get_post_meta($post_id, 'area_expertise_1' . $sufijo, true);
    $area_expertise_2 = get_post_meta($post_id, 'area_expertise_2' . $sufijo, true);
    $area_expertise_3 = get_post_meta($post_id, 'area_expertise_3' . $sufijo, true);
    $linkedin = get_post_meta($post_id, 'linkedin', true);
    $twitter = get_post_meta($post_id, 'twitter', true);
    $correo_electronico = get_post_meta($post_id, 'correo_electronico', true);
    $url_web = get_post_meta($post_id, 'url_web', true);
    $imagen_cabecera = get_post_meta($post_id, 'imagen_cabecera', true);
    $frase_cabecera = get_post_meta($post_id, 'frase_cabecera' . $sufijo, true);
    $trabajos = get_post_meta($post_id, 'trabajos' . $sufijo, true);
    
    $numero_publicaciones = count(query_posts("post_status=publish&post_type=publicacion&author_name=" . $author_name));


?>

<div class="contents">
    <div id="search-layer"></div>
    
    <?php if ($tipo == 'maximos') : ?>
        <article class="consultant-cv">
            <header>
                <div class="hidden-xs back-wrapper">
                    <a href="<?php _e('/sobre-nosotros/'); ?>"><span class="icon bbva-icon-arrow"></span><span class="text"><?php _e('Volver'); ?></span></a>
                </div>
                <div class="visible-xs img-overlay"> 
                    <div class="overlay"></div>
                    <?php if (!empty($imagen_cabecera)) : ?>
                        <img class="img-responsive" src="<?php echo $imagen_cabecera; ?>" alt="" />
                    <?php endif; ?>
                </div>
                	<?php if (!empty($imagen_cabecera)) : ?>
                		<img class="hidden-xs img-responsive" src="<?php echo $imagen_cabecera; ?>" alt="" />
                	<?php endif; ?>
                <div class="hidden-xs title-wrapper">
                    <div class="container">
                        <h1><?php echo $frase_cabecera; ?></h1>
                    </div>
                </div>
            </header>
            <section class="container">
                <div class="row info-wrapper">
                    <div class="col-xs-12 col-sm-8 main-data">
                        <section class="consultant-main-data-wrapper">
                            <?php if (!empty($imagen_perfil) && !empty($imagen_cabecera)) : ?>
                                <img class="img-responsive consultant-pic" src="<?php echo $imagen_perfil; ?>" alt="" />
                             <?php endif; ?>
                                <h1><?php echo $nombre; ?></h1>
                                <h4><?php echo $cargo; ?></h4>
                                <div class="current-work mt-md mb-md">
                                    <?php if (!empty($logo_trabajo)) : ?>
                                    <img src="<?php echo $logo_trabajo; ?>" alt="<?php echo $lugar_trabajo; ?>" />
                                    <?php endif; ?>
                                </div>
                                <?php echo wpautop($descripcion); ?>
                        </section>
                    </div>
                    <div class="col-xs-12 col-sm-4 secondary-data">
                        <?php if (!empty($correo_electronico) || !empty($url_web) || !empty($twitter) || !empty($linkedin)) : ?>
                            <div class="contacts-wrapper">
                            <?php if (!empty($linkedin)) : ?>
                                <a target="_blank" href="<?php echo $linkedin; ?>"><span class="bbva-icon-linkedin2"></span></a>
                            <?php endif; ?>
                            <?php if (!empty($correo_electronico)) : ?>
                                <a target="_top" href="mailto:<?php echo $correo_electronico; ?>" data-rel="external"><span class="bbva-icon-ico_email"></span></a>
                            <?php endif; ?>
                            <?php if (!empty($url_web)) : ?>
                                <a target="_blank" href="<?php echo $url_web; ?>"><span class="bbva-icon-web2"></span></a>
                            <?php endif; ?>
                            <?php if (!empty($twitter)) : ?>
                                <a target="_blank" href="<?php echo $twitter; ?>"><span class="bbva-icon-twitter2"></span></a>
                            <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <section class="consultant-secondary-data-wrapper">
                            <?php if ($numero_publicaciones > 0) : ?>
                                <div class="reports-wrapper">
                                    <h2><?php echo $numero_publicaciones; ?></h2>
                                    <h4><?php _e('Publicaciones'); ?></h4>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($area_expertise_1) || !empty($area_expertise_2) || !empty($area_expertise_3)) : ?>
                                <div class="expertise-wrapper">
                                    <h2><?php _e('Experto en'); ?></h2>
                                    <?php if (!empty($area_expertise_1)) : ?>
                                        <div>
                                            <img src="<?php echo get_template_directory_uri(); ?>/resources/images/consultant-card/lista.png" alt="" />
                                            <span><?php echo $area_expertise_1; ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($area_expertise_2)) : ?>
                                        <div>
                                            <img src="<?php echo get_template_directory_uri(); ?>/resources/images/consultant-card/lista.png" alt="" />
                                            <span><?php echo $area_expertise_2; ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($area_expertise_3)) : ?>
                                        <div>
                                            <img src="<?php echo get_template_directory_uri(); ?>/resources/images/consultant-card/lista.png" alt="" />
                                            <span><?php echo $area_expertise_3; ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </section>
                    </div>
                </div>
            </section>
        </article>
        
        <!-- Publicaciones del autor --> 
        <?php 
            wp_register_script('os_cards_widget_json_js', plugins_url('js/os_cards_widget_json.js' , __FILE__), array('jquery'));
            the_widget(
                'os_cards_widget_json', 
                array(
                    'titulo' => __('Publicaciones'),
                    'texto' => '',
                    'numero_posts_mostrar' => '7',
                    'numero_posts_totales' => '7',
                    'tipo_post' => 'publicacion',
                    'plantilla' => 'plantilla_2',
                    'enlace_detalle' => '',
                    'orden_posts' => 'DESC',
                    'filtrar_por_autor' => 'on'
                )
            );
        ?>
        
        <!-- Otros trabajos del autor --> 
        <?php if (!empty($trabajos)) : ?>
            <div class="consultant-data-grid">
                <article id="otros_trabajos" name="otros_trabajos" class="container data-grid">
                    <header>
                        <h1><?php _e('Otros trabajos'); ?></h1>
                    </header>
                    <div class="content">
                        <div class="grid-wrapper">
                            <?php $i = 0; ?>
                            <?php foreach ($trabajos as $trabajo) : ?>
                                <?php 
                                    $titulo = $trabajo['titulo'];
                                    $texto = $trabajo['texto'];
                                    $enlace = $trabajo['enlace']
                                ?>
                                <section id="trabajo_<?php echo $i; ?>" name="trabajo_<?php echo $i; ?>" class="data-block" <?php if ($i > 5) echo 'style="display:none;"'; ?>>
                                    <h2><?php echo $titulo; ?></h2>
                                    <p class="description"><?php echo $texto; ?></p>
                                    <p class="link">
                                        <a target="_blank" href="<?php echo $enlace; ?>"><?php _e('Leer más'); ?><span class="icon bbva-icon-link_external font-xs mr-xs"></span></a>
                                    </p>
                                </section>
                                <?php $i++; ?>
                            <?php endforeach; ?>

                        </div>
                    </div>
                    <footer class="grid-footer">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <a href="javascript:void(0)" id="readmore_trabajos" name="readmore_trabajos" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span><?php _e('Más trabajos'); ?></a>
                            </div>
                        </div>
                    </footer>
                </article>
            </div>
        <?php endif; ?>
     
        <!-- Prefooter --> 
        <?php 
            if (($numero_publicaciones == 0) && (empty($trabajos))){ $color = "gris"; }else if(($numero_publicaciones > 0) && (empty($trabajos))){ $color = "blanco"; }else if(($numero_publicaciones > 0) && (!empty($trabajos))){ $color = "gris";}
            the_widget('os_prefooter_bbva', array('color_fondo' => $color, 'menu_derecho' => 'enlaces-de-interes', 'menu_central' => 'en-el-mundo', 'menu_izquierdo' => 'sobre-educacion-financiera'));
        ?>
    <?php else : ?>
        <div class="mt-lg">
            <div class="consultant-cv">
                <div class="container">
                    <div class="row info-wrapper simple">
                        <div class="col-xs-12 col-sm-8 main-data">
                            <section class="consultant-main-data-wrapper">
                                <h1><?php echo $nombre; ?></h1>
                                <h4><?php echo $cargo; ?></h4>
                                <div class="visible-xs current-work mt-md mb-md">
                                    <?php if (!empty($logo_trabajo)) : ?>
                                        <img src="<?php echo $logo_trabajo; ?>" alt="<?php echo $lugar_trabajo; ?>" />
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($correo_electronico) || !empty($url_web) || !empty($twitter) || !empty($linkedin)) : ?>
                                    <div class="contacts-wrapper">
                                        <?php if (!empty($linkedin)) : ?>
                                            <a target="_blank" href="<?php echo $linkedin; ?>"><span class="bbva-icon-linkedin2"></span></a>
                                        <?php endif; ?>
                                        <?php if (!empty($correo_electronico)) : ?>
                                            <a target="_top" href="mailto:<?php echo $correo_electronico; ?>" data-rel="external"><span class="bbva-icon-ico_email"></span></a>
                                        <?php endif; ?>
                                        <?php if (!empty($url_web)) : ?>
                                            <a target="_blank" href="<?php echo $url_web; ?>"><span class="bbva-icon-web2"></span></a>
                                        <?php endif; ?>
                                        <?php if (!empty($twitter)) : ?>
                                            <a target="_blank" href="<?php echo $twitter; ?>"><span class="bbva-icon-twitter2"></span></a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="hidden-xs current-work mt-md mgb-30">
                                    <?php if (!empty($logo_trabajo)) : ?>
                                        <img src="<?php echo $logo_trabajo; ?>" alt="<?php echo $lugar_trabajo; ?>" />
                                    <?php endif; ?>
                                </div>
                                <?php echo wpautop($descripcion); ?>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Prefooter -->
        <?php 
            $color = "gris";
            the_widget('os_prefooter_bbva', array('color_fondo' => $color, 'menu_derecho' => 'enlaces-de-interes', 'menu_central' => 'en-el-mundo', 'menu_izquierdo' => 'sobre-educacion-financiera'));
        ?>
    <?php endif; ?>

</div>

<?php get_footer(); ?>