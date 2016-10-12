<?php
/**
 * Template para mostrar detalle de autores
 *
 */

get_header(); ?>

<?php 

    $nombre = $cargo = $imagen_perfil = $descripcion = $lugar_trabajo = $logo_trabajo = $area_expertise_1 = $area_expertise_2 = $area_expertise_3 = $linkedin = $twitter = $correo_electronico = $url_web = $imagen_cabecera = $frase_cabecera = '';
    $trabajos = array();

    $user_id = get_the_author_meta('ID');

    $user_info = get_userdata($user_id);
    $nombre = $user_info->first_name;
    $apellidos = $user_info->last_name;
    $cargo = get_user_meta($user_id, 'cargo', true);
    $imagen_perfil = get_user_meta($user_id, 'imagen_perfil', true);
    $descripcion = get_user_meta($user_id, 'descripcion', true);
    $lugar_trabajo = get_user_meta($user_id, 'lugar_trabajo', true);
    $logo_trabajo = get_user_meta($user_id, 'logo_trabajo', true);
    $area_expertise_1 = get_user_meta($user_id, 'area_expertise_1', true);
    $area_expertise_2 = get_user_meta($user_id, 'area_expertise_2', true);
    $area_expertise_3 = get_user_meta($user_id, 'area_expertise_3', true);
    $linkedin = get_user_meta($user_id, 'linkedin', true);
    $twitter = get_user_meta($user_id, 'twitter', true);
    $correo_electronico = $user_info->user_email;
    $url_web = $user_info->url_web;
    $imagen_cabecera = get_user_meta($user_id, 'imagen_cabecera', true);
    $frase_cabecera = get_user_meta($user_id, 'frase_cabecera', true);
    $trabajos = get_user_meta($user_id, 'trabajos', true);
    
    $numero_publicaciones = count_user_posts($user_id, 'publicacion');

?>

    <div class="contents">
        <article class="consultant-cv">
            <header>
                <div class="hidden-xs back-wrapper">
                    <a href="#"><span class="icon bbva-icon-arrow"></span><span class="text">Volver</span></a>
                </div>
                <img class="img-responsive" src="<?php echo $imagen_cabecera; ?>" alt="" />
                <div class="hidden-xs title-wrapper">
                    <h1><?php echo $frase_cabecera; ?></h1>
                </div>
            </header>
            <section class="container">
                <div class="row info-wrapper">
                    <div class="col-xs-12 col-sm-8 main-data">
                        <!-- consultant-main-data -->
                        <section class="consultant-main-data-wrapper">
                            <img class="img-responsive consultant-pic" src="<?php echo $imagen_perfil; ?>" alt="" />
                            <h1><?php echo $nombre . ' ' . $apellidos; ?></h1>
                            <h4><?php echo $cargo; ?></h4>
                            <div class="current-work">
                                <img src="<?php echo $logo_trabajo; ?>" alt="" />
                                <span><?php echo $lugar_trabajo; ?></span>
                            </div>
                            <?php echo wpautop($descripcion); ?>
                        </section>
                        <!-- EO consultant-main-data -->
                    </div>
                    <div class="col-xs-12 col-sm-4 secondary-data">
                        <?php if (!empty($correo_electronico) || !empty($url_web) || !empty($twitter) || !empty($linkedin)) : ?>
                        <div class="contacts-wrapper">
                            <?php if (!empty($correo_electronico)) : ?>
                                <a target="_top" href="mailto:<?php echo $correo_electronico; ?>" data-rel="external"><span class="bbva-icon-mail"></span></a>
                            <?php endif; ?>
                            <?php if (!empty($url_web)) : ?>
                                <a target="_blank" href="<?php echo $url_web; ?>"><span class="bbva-icon-web"></span></a>
                            <?php endif; ?>
                            <?php if (!empty($twitter)) : ?>
                                <a target="_blank" href="<?php echo $twitter; ?>"><span class="bbva-icon-twitter"></span></a>
                            <?php endif; ?>
                            <?php if (!empty($linkedin)) : ?>
                                <a target="_blank" href="<?php echo $twitter; ?>"><span class="bbva-icon-linkedin"></span></a>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <!-- consultant-secondary-data -->
                        <section class="consultant-secondary-data-wrapper">
                            <?php if ($numero_publicaciones > 0) : ?>
                            <div class="reports-wrapper">
                                <h2><?php echo $numero_publicaciones; ?></h2>
                                <h4><?php _e('Informes escritos'); ?></h4>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($area_expertise_1) || !empty($area_expertise_2) || !empty($area_expertise_3)) : ?>
                                <div class="expertise-wrapper">
                                    <h2><?php _e('Áreas de expertise'); ?></h2>
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
                        <!-- EO consultant-secondary-data -->
                    </div>
                </div>
            </section>
        </article>

        <?php 

            wp_register_script('os_cards_widget_json_js', plugins_url('js/os_cards_widget_json.js' , __FILE__), array('jquery'));
            the_widget(
                'os_cards_widget_json', 
                array(
                    'titulo' => __('Publicaciones del autor'),
                    'texto' => '',
                    'numero_posts_mostrar' => '5',
                    'numero_posts_totales' => '5',
                    'tipo_post' => 'publicacion',
                    'plantilla' => 'plantilla_2',
                    'enlace_detalle' => '',
                    'orden_posts' => 'ASC',
                    'filtrar_por_autor' => ''
                )
            );

        ?>
        
        <?php if (!empty($trabajos)) : ?>
        <article class="container data-grid">
            <header>
                <h1>Otros trabajos del autor</h1>
            </header>
            <div class="content">
                <div class="grid-wrapper">
                    <section class="data-block">
                        <h2>Car Rental Loss and Damage Insurance</h2>
                        <p class="description">
                            When you use your Card to pay for the entire rental and you don't have other coverage, you’re covered in case of damage to your rental car, anywhere in the United States and Canada!
                        </p>
                        <p class="link">
                            <a href="#">Aprender más<span class="icon bbva-icon-link_external font-xs mr-xs"></span></a>
                        </p>
                    </section>
                    <section class="data-block">
                        <h2>Emergency Assistance</h2>
                        <p class="description">
                            Whether you are traveling at home or many places abroad, you Card helps you to get ready for your travels and is there for you in case of emergencies.
                        </p>
                        <p class="link">
                            <a href="#">Aprender más<span class="icon bbva-icon-link_external font-xs mr-xs"></span></a>
                        </p>
                    </section>
                    <section class="data-block">
                        <h2>Travel Accident Insurance</h2>
                        <p class="description">
                            When you use it to pay for the entire cost of your plane, trip, ship or bus tickets, your Card covers many potential injuries when you are traveling at home or abroad!
                        </p>
                        <p class="link">
                            <a href="#">Aprender más<span class="icon bbva-icon-link_external font-xs mr-xs"></span></a>
                        </p>
                    </section>
                    <section class="data-block">
                        <h2>ID Theft Protection</h2>
                        <p class="description">
                            With your Card, you are protected from most fraud and identify theft expenses.
                        </p>
                        <p class="link">
                            <a href="#">Aprender más<span class="icon bbva-icon-link_external font-xs mr-xs"></span></a>
                        </p>
                    </section>
                    <section class="data-block">
                        <h2>Retail Protection (Purchase Protection)</h2>
                        <p class="description">
                            When you use your Card and you don't have other coverage, you are covered for 90 days after your eligible purchase in case of theft or damage.
                        </p>
                        <p class="link">
                            <a href="#">Aprender más<span class="icon bbva-icon-link_external font-xs mr-xs"></span></a>
                        </p>
                    </section>
                    <section class="data-block">
                        <h2>Extended Warranty</h2>
                        <p class="description">
                            Extend the original U.S. manufacturer’s warranty for up to an additional year on eligible purchases when you make the entire purchase with your Card.
                        </p>
                        <p class="link">
                            <a href="#">Aprender más<span class="icon bbva-icon-link_external font-xs mr-xs"></span></a>
                        </p>
                    </section>
                </div>
            </div>
            <footer class="grid-footer">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="#" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span><?php _e('Más trabajos'); ?></a>
                    </div>
                </div>
            </footer>
        </article>
        <?php endif; ?>

    </div>

<?php get_footer(); ?>