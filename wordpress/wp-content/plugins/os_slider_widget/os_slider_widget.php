<?php

/*
    Plugin Name: OS Slider Widget
    Plugin URI: http://www.opensistemas.com/
    Description: Agrega un widget para mostrar contenido a través de un slider con menú
    Version: 1.0
<<<<<<< HEAD
    Author: Roberto Moreno
    Author Email: rmoreno@opensistemas.com
=======
    Author: Marta Oliver
    Author Email: moliver@opensistemas.com
>>>>>>> ba1c36d225343b9143d44fc054853281dc27371b
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
<<<<<<< HEAD
            $this->WP_Widget('slider', __('Slider', 'os_slider_widget'), $options);
            add_action('admin_enqueue_scripts', array(&$this, 'add_script_back'));
            add_action('wp_enqueue_scripts', array(&$this, 'add_script_front'));
=======
            $this->WP_Widget('slider', __('OS Slider Widget', 'os_slider_widget'), $options);
>>>>>>> ba1c36d225343b9143d44fc054853281dc27371b
            add_action('admin_init', array(&$this, 'add_styles'));
        }

        function form($instance) {

            // Valores predeterminados para el widget
            $defaults = array(
<<<<<<< HEAD
              'imagen1' => '', 
              'imagen2' => '',
              'imagen3' => '',
            
              'id_postp1' => '0', 
              'id_postp2' => '0', 
              'id_postp3' => '0',
              
              'nombre_menu1' => 'item 1', 
              'nombre_menu2' => 'item 2', 
              'nombre_menu3' => 'item 3',
              
              'title1' => 'title 1', 
              'title2' => 'title 2', 
              'title3' => 'title 3',
=======
              'title1' => '', 
              'title2' => '', 
              'title3' => '',
>>>>>>> ba1c36d225343b9143d44fc054853281dc27371b
              
              'descr1' => '', 
              'descr2' => '', 
              'descr3' => '',
              
              'tlink1' => '',
              'tlink2' => '',
<<<<<<< HEAD
              'tlink3' => ''
=======
              'tlink3' => '',

              'ulink1' => '',
              'ulink2' => '',
              'ulink3' => ''
>>>>>>> ba1c36d225343b9143d44fc054853281dc27371b
            );
                
            $instance = wp_parse_args((array)$instance, $defaults);
            
            // Valores que se han introducido para el widget
<<<<<<< HEAD
            $imagen1 = $instance['imagen1'];
            $imagen2 = $instance['imagen2'];
            $imagen3 = $instance['imagen3'];
            
            $id_postp1 = $instance['id_postp1'];
            $id_postp2 = $instance['id_postp2'];
            $id_postp3 = $instance['id_postp3'];
            
=======
>>>>>>> ba1c36d225343b9143d44fc054853281dc27371b
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
<<<<<<< HEAD
            
            
            // Obtener páginas disponibles para links
            $pages = get_pages(); 
            foreach ($pages as $page) {
                $output_pages1 .= '<option value="' . $page->ID . '"';
                $output_pages2 .= '<option value="' . $page->ID . '"';
                $output_pages3 .= '<option value="' . $page->ID . '"';
                if ($page->ID == $id_postp1) {
                    $output_pages1 .= 'selected';
                }
                if ($page->ID == $id_postp2) {
                    $output_pages2 .= 'selected';
                }
                if ($page->ID == $id_postp3) {
                    $output_pages3 .= 'selected';
                }
                $output_pages1 .= '>' . $this->truncate($page->post_title, 30);
                $output_pages2 .= '>' . $this->truncate($page->post_title, 30);
                $output_pages3 .= '>' . $this->truncate($page->post_title, 30);
                $output_pages1 .= '</option>';
                $output_pages2 .= '</option>';
                $output_pages3 .= '</option>';
            }
=======

            $ulink1 = $instance['ulink1'];
            $ulink2 = $instance['ulink2'];
            $ulink2 = $instance['ulink3'];
>>>>>>> ba1c36d225343b9143d44fc054853281dc27371b
                
            // Inicio de html para el formulario del widget    
            ?>  
            <div class="tabs-slider">  
            <?php for ($i = 1; $i <= 3; $i++): ?>
                <div class="slider-tab<?php echo $i; ?>" <?php if ($i > 3) { echo 'style="display:none;"'; } ?> >
                    <div class="bloque-item"><span style=""><?php _e("Elemento"); echo ' ' . $i; ?></span></div>
<<<<<<< HEAD
                    <div class="campo-slider"><span><?php _e("Nombre del menú"); ?></span></div>
                    <div class="valor-campo-slider">
                        <input class="widefat" type="text" name="<?php echo $this->get_field_name('nombre_menu'.$i);?>" value="<?php echo esc_attr(${"nombre_menu" . $i});?>"/>
                    </div>
                    <div class="campo-slider"><span><?php _e("Imagen de fondo"); ?></span></div>
                    <div class="valor-campo-imagen-slider" >
                        <input class="url_imagen<?php echo $i; ?>" type="text" size="26" name="<?php echo $this->get_field_name('imagen'.$i);?>" value="<?php echo esc_attr(${"imagen" . $i});?>" readonly/> 
                        <input name="subir_imagen<?php echo $i; ?>" class="button" type="button" value="<?php _e("Seleccionar imagen"); ?>" style=''/> 
                        <img src="<?php echo esc_attr(${"imagen" . $i}); ?>" style='max-height:30px;margin-left:10px;' > 
                    </div>
=======
>>>>>>> ba1c36d225343b9143d44fc054853281dc27371b
                    <div class="campos_tipo4" id="<?php echo $i; ?>">
                        <div class="campo-slider"><span><?php _e("Título"); ?></span></div>
                        <div class="valor-campo-slider" >
                            <input class="widefat" type="text" name="<?php echo $this->get_field_name('title'.$i);?>" value="<?php echo esc_attr(${"title" . $i});?>"/>
                        </div>
                        <div class="campo-slider"> <span><?php _e("Descripción"); ?></span></div>
                        <div class="valor-campo-slider" >
<<<<<<< HEAD
                            <input class="widefat" type="text" name="<?php echo $this->get_field_name('descr'.$i);?>" value="<?php echo esc_attr(${"descr" . $i});?>"/>
=======
                            <textarea rows="4" cols="20" class="widefat" name="<?php echo $this->get_field_name('descr'.$i);?>"><?php echo esc_attr(${"descr" . $i});?></textarea>
>>>>>>> ba1c36d225343b9143d44fc054853281dc27371b
                        </div>
                        <div class="campo-slider"> <span><?php _e("Texto del enlace"); ?></span></div>
                        <div class="valor-campo-slider" >
                            <input class="widefat" type="text" name="<?php echo $this->get_field_name('tlink'.$i);?>" value="<?php echo esc_attr(${"tlink" . $i});?>"/>
                        </div>
<<<<<<< HEAD
                        <div class="campo-slider"> <span><?php _e("Página a enlazar"); ?></span></div>
                        <div class="valor-campo-slider paginas" > 
                            <select class="type_slider<?php echo $i; ?>" name="<?php echo $this->get_field_name('id_postp'.$i);?>" >
                                <?php echo ${"output_pages" . $i}; ?>
                            </select>
=======
                        <div class="campo-slider"> <span><?php _e("URL a enlazar"); ?></span></div>
                        <div class="valor-campo-slider paginas" > 
                            <div class="valor-campo-slider" >
                                <input class="widefat" type="url" name="<?php echo $this->get_field_name('ulink'.$i);?>" value="<?php echo esc_attr(${"ulink" . $i});?>"/>
                            </div>
>>>>>>> ba1c36d225343b9143d44fc054853281dc27371b
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
            </div> 
            <?php
            // Fin del html para el formulario del widget
        
        }

            
        function update($new_instance, $old_instance) {
            
            $instance = $old_instance;
<<<<<<< HEAD

            $instance['imagen1'] = strip_tags($new_instance['imagen1']);
            $instance['imagen2'] = strip_tags($new_instance['imagen2']);
            $instance['imagen3'] = strip_tags($new_instance['imagen3']);
            
            $instance['tipo1'] = strip_tags($new_instance['tipo1']);
            $instance['tipo2'] = strip_tags($new_instance['tipo2']);
            $instance['tipo3'] = strip_tags($new_instance['tipo3']);
            
            $instance['id_postp1'] = strip_tags($new_instance['id_postp1']);
            $instance['id_postp2'] = strip_tags($new_instance['id_postp2']);
            $instance['id_postp3'] = strip_tags($new_instance['id_postp3']);

            $instance['nombre_menu1'] = strip_tags($new_instance['nombre_menu1']);
            $instance['nombre_menu2'] = strip_tags($new_instance['nombre_menu2']);
            $instance['nombre_menu3'] = strip_tags($new_instance['nombre_menu3']);
=======
>>>>>>> ba1c36d225343b9143d44fc054853281dc27371b
            
            $instance['title1'] = strip_tags($new_instance['title1']);
            $instance['title2'] = strip_tags($new_instance['title2']);
            $instance['title3'] = strip_tags($new_instance['title3']);
            
            $instance['descr1'] = strip_tags($new_instance['descr1']);
            $instance['descr2'] = strip_tags($new_instance['descr2']);
            $instance['descr3'] = strip_tags($new_instance['descr3']);
            
            $instance['tlink1'] = strip_tags($new_instance['tlink1']);
            $instance['tlink2'] = strip_tags($new_instance['tlink2']);
            $instance['tlink3'] = strip_tags($new_instance['tlink3']);

<<<<<<< HEAD
=======
            $instance['ulink1'] = strip_tags($new_instance['ulink1']);
            $instance['ulink2'] = strip_tags($new_instance['ulink2']);
            $instance['ulink3'] = strip_tags($new_instance['ulink3']);

>>>>>>> ba1c36d225343b9143d44fc054853281dc27371b
            return $instance;
        }

            
        function widget($args, $instance) {
<<<<<<< HEAD
            global $wpdb;

            $url_site = site_url();
            
            extract($args);
            
            // Inicio del html del widget
            $output_slider = '<section class="moduloContenido_carruselPromocionalHeader">
                                  <div class="carruselPromocional">
                                      <ul class="tabs_contentHorizontal">';        
            for ($i = 1; $i <= 3; $i++) {
                $estilo = '';
                if ($i != 1) {
                    $estilo = 'style="display:none;"'; 
                }
                $id_promo = "promo_0" . $i;
                $output_slider .= '<li class="tab_box" id="'.$id_promo.'" '.$estilo.'>
                                       <figure class="moduloCarrusel_boxImagen"><img src="'. $instance["imagen" . $i] .'" alt="'.$instance["nombre_menu" . $i] . '" title="'. $instance["nombre_menu" . $i] . '"></figure>
                                       <div class="wrapperContent">
                                           <div class="moduloCarrusel_boxTexto promoTipo_botonVerde">
                                               <p class="fotoInfo_titulo">'.$instance["title" . $i ].'</p>
                                               <p>'. $instance["descr" . $i] . '</p> 
                                               <p class="fotoInfo_link"><a title="' . $instance["title" . $i] . '" href="' . get_permalink($instance["id_postp" . $i]) . '" class="botonVerde">' . $instance["tlink" . $i] . '</a></p>
                                           </div>
                                        </div>
                                   </li>';
                
                if ($i == 1) {
                    $output_items .= '<li class="tab_boton active" id="' . $id_promo . '"><span class="textoIconoOcultar">' . $instance["nombre_menu" . $i] .'</span></li>';
                } else {
                    $output_items .= '<li class="tab_boton" id="'.$id_promo.'"><span class="textoIconoOcultar">'. $instance["nombre_menu" . $i] .'</span></li>';
                }
            }    
            
            $output_menu .= '<div class="wrapperContent">
                                 <ul class="tabs_menuHorizontal"> '. $output_items .' </ul>
                             </div>';       

            $output_slider .= $output_menu . '</div></section>';  
            // Fin del html del widget      
            
            echo $output_slider;
=======
            ?>
            <div class="slider">
                <div id="home-slider" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#home-slider" data-slide-to="0" class=""><span class="bbva-icon-commerce"></span></li>
                        <li data-target="#home-slider" data-slide-to="1" class="active"><span class="bbva-icon-cash"></span></li>
                        <li data-target="#home-slider" data-slide-to="2" class=""><span class="bbva-icon-loan"></span></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <article class="item">
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
                                        <h1>Dónde estamos</h1>
                                        <p>Toda la información sobre educación financiera y talleres en los diferentes paises del mundo.</p>
                                        <a href="#" class="btn btn-bbva-blue">Empezar</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <article class="item active">
                            <div class="spotlight spotlight-blue">
                                <div class="film-one"></div>
                                <div class="film-two"></div>
                                <div class="film-three"></div>
                                <div class="film-four"></div>
                            </div>
                            <img src="<?php echo get_template_directory_uri(); ?>/resources/images/home/world.png" class="img-gb-right">
                            <div class="slider-caption">
                                <div class="container">
                                    <div class="caption-container">
                                        <h1>Lorem ipsum</h1>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum dignissim, eros faucibus euismod gravida, ipsum nibh dictum urna, imperdiet maximus nisi tortor nec leo.</p>
                                        <a href="#" class="btn btn-bbva-aqua">Lorem ipsum</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <article class="item">
                            <div class="spotlight spotlight-aqua">
                                <div class="film-one"></div>
                                <div class="film-two"></div>
                                <div class="film-three"></div>
                                <div class="film-four"></div>
                            </div>
                            <img src="<?php echo get_template_directory_uri(); ?>/resources/images/home/world.png" class="img-gb-right">
                            <div class="slider-caption">
                                <div class="container">
                                    <div class="caption-container">
                                        <h1>Lorem ipsum</h1>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum dignissim, eros faucibus euismod gravida, ipsum nibh dictum urna, imperdiet maximus nisi tortor nec leo.</p>
                                        <a href="#" class="btn btn-bbva-dark-blue">Lorem ipsum</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <a href="#home-slider" class="hidden-xs hidden-sm left carousel-control" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a href="#home-slider" class="hidden-xs hidden-sm right carousel-control" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <?php
>>>>>>> ba1c36d225343b9143d44fc054853281dc27371b
        }


        function truncate($text, $chars) {
            $texto = substr($text, 0, $chars);
            $texto .= "...";
            return $texto;
        }

            
        function add_styles() {
            wp_enqueue_style('style-slider-widget', plugins_url( 'css/slider_style.css' , __FILE__));
        }
<<<<<<< HEAD
            
            
        function add_script_back() {
            global $typenow;
            if ($typenow == $this->post_type) {
                //carga la librería para importar imágenes 
                wp_enqueue_media();
                wp_register_script('os_slider_widget_back-js', plugins_url( 'js/slider_widget_back.js' , __FILE__ ), array('jquery'));
                wp_enqueue_script('os_slider_widget_back-js');
            }
        } 
            
            
        function add_script_front() {
            if(is_active_widget( false, false, $this->id_base, true)) { // check if widget is used
                wp_register_script('os_slider_widget_front-js', plugins_url( 'js/slider_widget_front.js' , __FILE__ ), array('jquery'));
                wp_enqueue_script('os_slider_widget_front-js');
            }
        }
=======
>>>>>>> ba1c36d225343b9143d44fc054853281dc27371b

            
    }

    add_action('widgets_init', create_function('', 'return register_widget("slider_widget");'));

endif;