<?php

/*
    Plugin Name: OS Slider Widget
    Plugin URI: http://www.opensistemas.com/
    Description: Agrega un widget para mostrar contenido a través de un slider con menú
    Version: 1.0
    Author: Marta Oliver
    Author Email: moliver@opensistemas.com
    Plugin URI: http://www.opensistemas.com/
    Text Domain: os_slider_widget
    License: GPLv2 
*/

if (!class_exists('slider_widget')) :

    class slider_widget extends WP_Widget {
        
        function __construct() {
            $options = array(
                'classname' => "slider",
                'description' => __('Bluild Menu Slider with Introductions, Events, Testimonies and Pages posts','os_slider_widget')
            );
            $this->WP_Widget('slider', __('OS Slider Widget', 'os_slider_widget'), $options);
            add_action('admin_init', array(&$this, 'add_styles'));
        }

        function form($instance) {

            // Valores predeterminados para el widget
            $defaults = array(
              'title1' => '', 
              'title2' => '', 
              'title3' => '',
              
              'descr1' => '', 
              'descr2' => '', 
              'descr3' => '',
              
              'tlink1' => '',
              'tlink2' => '',
              'tlink3' => '',

              'ulink1' => '',
              'ulink2' => '',
              'ulink3' => ''
            );
                
            $instance = wp_parse_args((array)$instance, $defaults);
            
            // Valores que se han introducido para el widget
            $nombre_menu1 = $instance['nombre_menu1'];
            $nombre_menu2 = $instance['nombre_menu2'];
            $nombre_menu3 = $instance['nombre_menu3'];
            
            $title1 = $instance['title1'];
            $title2 = $instance['title2'];
            $title3 = $instance['title3'];
            
            $descr1 = $instance['descr1'];
            $descr2 = $instance['descr2'];
            $descr3 = $instance['descr3'];
            
            $tlink1 = $instance['tlink1'];
            $tlink2 = $instance['tlink2'];
            $tlink3 = $instance['tlink3'];

            $ulink1 = $instance['ulink1'];
            $ulink2 = $instance['ulink2'];
            $ulink2 = $instance['ulink3'];

            $externo1 = $instance['externo1'];
            $externo2 = $instance['externo2'];
            $externo3 = $instance['externo3'];
                
            // Inicio de html para el formulario del widget    
            ?>  
            <!--div class="tabs-slider"-->  
            <?php for ($i = 1; $i <= 1; $i++): ?>
                <div class="slider-tab<?php echo $i; ?>" <?php if ($i > 3) { echo 'style="display:none;"'; } ?> >
                    <div class="bloque-item"><span style=""><?php _e("Elemento"); echo ' ' . $i; ?></span></div>
                    <div class="campos_tipo4" id="<?php echo $i; ?>">
                        <div class="campo-slider"><span><?php _e("Título"); ?></span></div>
                        <div class="valor-campo-slider" >
                            <input class="widefat" type="text" name="<?php echo $this->get_field_name('title'.$i);?>" value="<?php echo esc_attr(${"title" . $i});?>"/>
                        </div>
                        <div class="campo-slider"> <span><?php _e("Descripción"); ?></span></div>
                        <div class="valor-campo-slider" >
                            <textarea rows="4" cols="20" class="widefat" name="<?php echo $this->get_field_name('descr'.$i);?>"><?php echo esc_attr(${"descr" . $i});?></textarea>
                        </div>
                        <div class="campo-slider"> <span><?php _e("Texto del enlace"); ?></span></div>
                        <div class="valor-campo-slider" >
                            <input class="widefat" type="text" name="<?php echo $this->get_field_name('tlink'.$i);?>" value="<?php echo esc_attr(${"tlink" . $i});?>"/>
                        </div>
                        <div class="campo-slider"> <span><?php _e("URL a enlazar"); ?></span></div>
                        <div class="valor-campo-slider paginas" > 
                            <div class="valor-campo-slider" >
                                <input class="widefat" type="url" name="<?php echo $this->get_field_name('ulink'.$i);?>" value="<?php echo esc_attr(${"ulink" . $i});?>"/>
                            </div>
                        </div>
                        <div class="valor-campo-slider paginas" > 
                            <div class="valor-campo-slider" >
                                <input class="widefat" type="checkbox" name="<?php echo $this->get_field_name('externo'.$i);?>" <?php checked(${"externo" . $i}, 'on'); ?>/>
                                <span><?php _e("Abrir enlace en una nueva ventana"); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
            <!--/div--> 
            <?php
            // Fin del html para el formulario del widget
        
        }

            
        function update($new_instance, $old_instance) {
            
            $instance = $old_instance;
            
            $instance['title1'] = strip_tags($new_instance['title1']);
            $instance['title2'] = strip_tags($new_instance['title2']);
            $instance['title3'] = strip_tags($new_instance['title3']);
            
            $instance['descr1'] = strip_tags($new_instance['descr1']);
            $instance['descr2'] = strip_tags($new_instance['descr2']);
            $instance['descr3'] = strip_tags($new_instance['descr3']);
            
            $instance['tlink1'] = strip_tags($new_instance['tlink1']);
            $instance['tlink2'] = strip_tags($new_instance['tlink2']);
            $instance['tlink3'] = strip_tags($new_instance['tlink3']);

            $instance['ulink1'] = strip_tags($new_instance['ulink1']);
            $instance['ulink2'] = strip_tags($new_instance['ulink2']);
            $instance['ulink3'] = strip_tags($new_instance['ulink3']);

            $instance['externo1'] = strip_tags($new_instance['externo1']);
            $instance['externo2'] = strip_tags($new_instance['externo2']);
            $instance['externo3'] = strip_tags($new_instance['externo3']);


            return $instance;
        }

            
        function widget($args, $instance) {
            ?>
            <div class="slider">
                <div id="home-slider" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <!--li data-target="#home-slider" data-slide-to="0" class="active"><span class="bbva-icon-commerce"></span></li>
                        <li data-target="#home-slider" data-slide-to="1" class=""><span class="bbva-icon-cash"></span></li>
                        <li data-target="#home-slider" data-slide-to="2" class=""><span class="bbva-icon-loan"></span></li-->
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <article class="item active">
                            <div class="spotlight spotlight-dark-blue">
                                <div class="film-one"></div>
                                <div class="film-two"></div>
                                <div class="film-three"></div>
                                <div class="film-four"></div>
                            </div>
                            <img src="<?php echo get_template_directory_uri(); ?>/resources/images/home/world.png" class="img-gb-right">
                            <div class="slider-caption">
                                <div class="container">
                                    <div class="caption-container">
                                        <h1><?php echo $instance['title1']; ?></h1>
                                        <p><?php echo $instance['descr1']; ?></p>
                                        <a <?php if ($instance['externo1'] == "on") echo 'target="_blank"';?> href="<?php echo $instance['ulink1']; ?>" class="btn btn-bbva-blue"><?php echo $instance['tlink1']; ?></a>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <!--article class="item">
                            <div class="spotlight spotlight-dark-blue">
                                <div class="film-one"></div>
                                <div class="film-two"></div>
                                <div class="film-three"></div>
                                <div class="film-four"></div>
                            </div>
                            <img src="--><?php/* echo get_template_directory_uri(); */?><!--/resources/images/home/world.png" class="img-gb-right">
                            <div class="slider-caption">
                                <div class="container">
                                    <div class="caption-container">
                                        <h1>--><?php //echo $instance['title2']; ?><!--/h1>
                                        <p--><?php ///echo $instance['descr2']; ?><!--/p>
                                        <a --><?php //if ($instance['externo2'] == "on") echo 'target="_blank"';?><!--- href="--><?php //echo $instance['ulink2']; ?><!--" class="btn btn-bbva-blue"--><?php //echo $instance['tlink2']; ?><!--/a>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <article class="item">
                            <div class="spotlight spotlight-dark-blue">
                                <div class="film-one"></div>
                                <div class="film-two"></div>
                                <div class="film-three"></div>
                                <div class="film-four"></div>
                            </div>
                            <img src="--><?php //echo get_template_directory_uri(); ?><!--/resources/images/home/world.png" class="img-gb-right">
                            <div class="slider-caption">
                                <div class="container">
                                    <div class="caption-container">
                                        <h1--><?php // echo $instance['title3']; ?><!--/h1>
                                        <p--><?php // echo $instance['descr3']; ?><!--/p>
                                        <a --><?php //if ($instance['externo3'] == "on") echo 'target="_blank"';?><!-- href="--><?php ///echo $instance['ulink3']; ?><!--" class="btn btn-bbva-blue"--><?php// echo $instance['tlink3']; ?><!--</a>
                                    </div>
                                </div>
                            </div>
                        </article-->
                    </div>
                    <!--a href="#home-slider" class="hidden-xs hidden-sm left carousel-control" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a href="#home-slider" class="hidden-xs hidden-sm right carousel-control" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a-->
                </div>
            </div>
            <?php
        }


        function truncate($text, $chars) {
            $texto = substr($text, 0, $chars);
            $texto .= "...";
            return $texto;
        }

            
        function add_styles() {
            wp_enqueue_style('style-slider-widget', plugins_url( 'css/slider_style.css' , __FILE__));
        }

            
    }

    add_action('widgets_init', create_function('', 'return register_widget("slider_widget");'));

endif;