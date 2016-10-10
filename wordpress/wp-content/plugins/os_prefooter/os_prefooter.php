<?php

/*
	Plugin Name: OS Prefooter BBVA
	Plugin URI: https://www.opensistemas.com/
	Description: Muestra el prefooter de BBVA.
	Version: 1.0
	Author: Marta Oliver
	Author URI: rmoreno@opensistemas.com
	License: GPLv2 or later
	Text Domain: os_prefooter
*/


if (!class_exists('OS_Prefooter_BBVA')) :

	class OS_Prefooter_BBVA extends WP_Widget {

	    function __construct() {
	        parent::__construct(
	        	'os_prefooter',
	        	__('Prefooter BBVA', 'os_prefooter'),
	        	array(
	            	'description' => __('Widget que muestra el prefooter de BBVA.', 'os_prefooter')
	        	)
	        );
        }


	    public function widget($args, $instance) {
	    	?>
			<div class="prefooter-bbva background-gray">
			    <div class="container">
			        <div class="row">
			            <div class="col-xs-12 col-sm-12 mt-lg mb-lg footer-menu-group">
			                <div class="row">
			                    <div class="col-xs-12 col-sm-4 footer-menu-item">
			                        <div>
			                            <p class="hidden-xs title mb-md"><a role="button">Sobre Educación Financiera</a></p>
			                            <p class="visible-xs title"><a role="button" class="collapsed" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseExample"> Sobre Educación Financiera<span class="icon-plus icon-collapsable"></span></a></p>
			                            <div class="collapse" id="collapseOne">
			                                <ul class="hidden-xs prefooter-menu">
			                                    <li class="mb-md"><a href="#">Publicaciones</a></li>
			                                    <li class="mb-md"><a href="#">En el mundo</a></li>
			                                    <li class="mb-md"><a href="#">Impacto</a></li>
			                                    <li class="mb-md"><a href="#">Eventos</a></li>
			                                    <li class="mb-md"><a href="#">Sobre Nosotros</a></li>
			                                </ul>
			                                <div class="visible-xs row prefooter-menu-collapsed"><a href="#" class="col-xs-6">Publicaciones</a><a href="#" class="col-xs-6">En el mundo</a><a href="#" class="col-xs-6">Impacto</a><a href="#" class="col-xs-6">Eventos</a><a href="#" class="col-xs-6">Sobre Nosotros</a></div>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-xs-12 col-sm-4 footer-menu-item">
			                        <div>
			                            <p class="hidden-xs title mb-md"><a role="button">En el mundo</a></p>
			                            <p class="visible-xs title"><a role="button" class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseExample"> En el mundo<span class="icon-plus icon-collapsable"></span></a></p>
			                            <div class="collapse" id="collapseTwo">
			                                <div class="row mgl-0 prefooter-menu-collapsed">
			                                    <ul class="col-xs-6 col-sm-6 prefooter-menu prefooter-menu-world double-column">
			                                        <li class="mb-md"><a href="#">España</a></li>
			                                        <li class="mb-md"><a href="#">USA</a></li>
			                                        <li class="mb-md"><a href="#">Turquía</a></li>
			                                        <li class="mb-md"><a href="#">Portugal</a></li>
			                                        <li class="mb-md"><a href="#">Chile</a></li>
			                                        <li class="mb-md"><a href="#">Colombia</a></li>
			                                    </ul>
			                                    <ul class="col-xs-6 col-sm-6 prefooter-menu prefooter-menu-world">
			                                        <li class="mb-md"><a href="#">Venezuela</a></li>
			                                        <li class="mb-md"><a href="#">Uruguay</a></li>
			                                        <li class="mb-md"><a href="#">Paraguay</a></li>
			                                        <li class="mb-md"><a href="#">Argentina</a></li>
			                                        <li class="mb-md"><a href="#">México</a></li>
			                                        <li class="mb-md"><a href="#">Perú</a></li>
			                                    </ul>
			                                </div>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-xs-12 col-sm-4 footer-menu-item">
			                        <p class="hidden-xs title mb-md"><a role="button">Enlaces de interés</a></p>
			                        <p class="visible-xs title"><a role="button" class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseExample"> Enlaces de interés<span class="icon-plus icon-collapsable"></span></a></p>
			                        <div class="collapse" id="collapseThree">
			                            <ul class="hidden-xs prefooter-menu">
			                                <li class="mb-md"><a href="#">Web corporativa BBVA.com</a></li>
			                                <li class="mb-md"><a href="#">Empleo BBVA</a></li>
			                                <li class="mb-md"><a href="http://mfbbva.org/">Fundación MicroFinanzas BBVA</a></li>
			                            </ul>
			                            <div class="visible-xs row prefooter-menu-collapsed">
			                                <a href="#" class="col-xs-8">Web corporativa BBVA.com</a>
			                                <a href="#" class="col-xs-4">Empleo BBVA</a>
			                                <a href="http://mfbbva.org/">Fundación MicroFinanzas BBVA</a>
			                            </div>
			                        </div>
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
	    	<?php
		}


  		public function form($instance) {

  			?>
  			<p><?php _e('Seleccione los menús cuyos enlaces aparecerán en el prefooter. Los menús se administran desde Wordpress en <b>Aparencia > Menús</b>.', 'os_prefooter'); ?></p>
  			<?php

  			$menus = get_all_wordpress_menus();
  	
  			$color_fondo = (!empty($instance['color_fondo'])) ? $instance['color_fondo'] : 'gris';
  			$menu_derecho = (!empty($instance['menu_derecho'])) ? $instance['menu_derecho'] : 'menu_header';
  			$menu_central = (!empty($instance['menu_central'])) ? $instance['menu_central'] : 'menu_header';
  			$menu_izquierdo = (!empty($instance['menu_izquierdo'])) ? $instance['menu_izquierdo'] : 'menu_header';

	        ?>
	       	<p>
				<label for="<?php echo $this->get_field_id('color_fondo'); ?>"><?php _e('Color de fondo:', 'os_logos_widget'); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id('color_fondo'); ?>" name="<?php echo $this->get_field_name('color_fondo'); ?>">
					<option value="blanco" <?php if ($color_fondo == "blanco") echo 'selected="selected"'; ?>"><?php _e("Blanco", "os_prefooter"); ?></option>
					<option value="gris" <?php if ($color_fondo == "gris") echo 'selected="selected"'; ?>"><?php _e("Gris", "os_prefooter"); ?></option>
				</select>
				<span class="description"><?php _e('Color de fondo para el prefooter.',' os_prefooter');?></span>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('menu_derecho'); ?>"><?php _e('Menú derecho', 'os_prefooter'); ?>:</label>
				<select class="widefat" id="<?php echo $this->get_field_id('menu_derecho'); ?>" name="<?php echo $this->get_field_name('menu_derecho'); ?>">
					<?php foreach ($menus as $m) : ?>
					<option value="<?php echo $m->slug; ?>" <?php if ($menu_derecho == $m->slug) echo 'selected="selected"'; ?>"><?php echo $m->name; ?></option>
					<?php endforeach; ?>
				</select>
				<span class="description"><?php _e('Menú con el listado de enlaces que aparecerán en la parte derecha del prefooter.',' os_prefooter');?></span>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('menu_central'); ?>"><?php _e('Menú central', 'os_prefooter'); ?>:</label>
				<select class="widefat" id="<?php echo $this->get_field_id('menu_central'); ?>" name="<?php echo $this->get_field_name('menu_central'); ?>">
					<?php foreach ($menus as $m) : ?>
					<option value="<?php echo $m->slug; ?>" <?php if ($menu_central == $m->slug) echo 'selected="selected"'; ?>"><?php echo $m->name; ?></option>
					<?php endforeach; ?>				
				</select>
				<span class="description"><?php _e('Menú con el listado de enlaces que aparecerán en la parte central del prefooter.',' os_prefooter');?></span>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('menu_izquierdo'); ?>"><?php _e('Menú izquierdo', 'os_prefooter'); ?>:</label>
				<select class="widefat" id="<?php echo $this->get_field_id('menu_izquierdo'); ?>" name="<?php echo $this->get_field_name('menu_izquierdo'); ?>">
					<?php foreach ($menus as $m) : ?>
					<option value="<?php echo $m->slug; ?>" <?php if ($menu_izquierdo == $m->slug) echo 'selected="selected"'; ?>"><?php echo $m->name; ?></option>
					<?php endforeach; ?>			
				</select>
				<span class="description"><?php _e('Menú con el listado que aparecerán en la parte izquierda del prefooter.',' os_prefooter');?></span>
			</p>
	        <?php
	    }


	    function update($new_instance, $old_instance) {
	    	
	    	$instance = array();
	    	
	    	$instance['color_fondo'] = (!empty( $new_instance['color_fondo'])) ? strip_tags($new_instance['color_fondo']) : 'gris';
	    	$instance['menu_derecho'] = (!empty( $new_instance['menu_derecho'])) ? strip_tags($new_instance['menu_derecho']) : 'menu_header';
	    	$instance['menu_central'] = (!empty( $new_instance['menu_central'])) ? strip_tags($new_instance['menu_central']) : 'menu_header';
	    	$instance['menu_izquierdo'] = (!empty( $new_instance['menu_izquierdo'])) ? strip_tags($new_instance['menu_izquierdo']) : 'menu_header';
	    
	    	return $instance;

	    }

	}

	function os_prefooter_bbva() {
	    register_widget('os_prefooter_bbva');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_prefooter_bbva');


endif;


function get_all_wordpress_menus(){
    return get_terms('nav_menu', array( 'hide_empty' => false ) ); 
}