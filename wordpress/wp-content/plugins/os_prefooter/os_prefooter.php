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

	    	//os_imprimir($instance);

	    	
	    	if ($instance['color_fondo'] == "gris") {
	    		$background = 'background-gray';
	    	} else if ($instance['color_fondo'] == "blanco") {
	    		$background = 'background-white';
	    	}

	    	$elementos_menu_izquierdo = wp_get_nav_menu_items($instance['menu_izquierdo']);
	    	$elementos_menu_central = wp_get_nav_menu_items($instance['menu_central']);
	    	$elementos_menu_derecho = wp_get_nav_menu_items($instance['menu_derecho']);

	    	$menu_izquierdo = get_term_by('slug', $instance['menu_izquierdo'], 'nav_menu');
	    	$menu_central = get_term_by('slug', $instance['menu_central'], 'nav_menu');
	    	$menu_derecho = get_term_by('slug', $instance['menu_derecho'], 'nav_menu');

	    	?>
			<div class="prefooter-bbva <?php echo $background; ?>">
			    <div class="container">
			        <div class="row">
			            <div class="col-xs-12 col-sm-12 mt-lg mb-lg footer-menu-group">
			                <div class="row">
			                    <div class="col-xs-12 col-sm-4 footer-menu-item">
			                        <div>
			                            <p class="hidden-xs title mb-md"><a role="button"><?php echo $menu_izquierdo->name; ?></a></p>
			                            <p class="visible-xs title"><a role="button" class="collapsed" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseExample"> Sobre Educación Financiera<span class="icon-plus icon-collapsable"></span></a></p>
			                            <div class="collapse" id="collapseOne">
			                            	<?php if (!empty($elementos_menu_izquierdo)) : ?>
				                                <ul class="hidden-xs prefooter-menu">
				                                	<?php foreach ($elementos_menu_izquierdo as $e) : ?>
					                                    <li class="mb-md"><a target="<?php echo $e->target; ?>" href="<?php echo $e->url; ?>"><?php echo $e->post_title; ?></a></li>
				                                    <?php endforeach; ?>
				                                </ul>
			                            	<?php endif; ?>
			                                <?php if (!empty($elementos_menu_izquierdo)) : ?>
			                                	<div class="visible-xs row prefooter-menu-collapsed">
                                                	<img class="visible-xs prefooter-mobile-shadow" src="<?php echo get_template_directory_uri(); ?>/resources/images/prefooter/shadow.png"/>
			                                		<?php foreach ($elementos_menu_izquierdo as $e) : ?>
			                                			<?php $classes = implode($e->classes); ?>
			                                			<a target="<?php echo $e->target; ?>" href="<?php echo $e->url; ?>" class="<?php echo $classes; ?>"><?php echo $e->post_title; ?></a>
			                                		<?php endforeach; ?>
                                                    <img class="visible-xs prefooter-mobile-shadow reverse" src="<?php echo get_template_directory_uri(); ?>/resources/images/prefooter/shadow.png"/>
			                                	</div>
			                            	<?php endif; ?>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-xs-12 col-sm-4 footer-menu-item">
			                        <div>
			                            <p class="hidden-xs title mb-md"><a role="button"><?php echo $menu_central->name; ?></a></p>
			                            <p class="visible-xs title"><a role="button" class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseExample"> En el mundo<span class="icon-plus icon-collapsable"></span></a></p>
			                            <div class="collapse" id="collapseTwo">
			                                <div class="row mgl-0 prefooter-menu-collapsed">
                                            	<img class="visible-xs prefooter-mobile-shadow" src="<?php echo get_template_directory_uri(); ?>/resources/images/prefooter/shadow.png"/>
			                                    <?php if (!empty($elementos_menu_central)) : ?>
			                                    	<?php $partes = array_chunk($elementos_menu_central, 6); ?>
			                                    	<?php $parte1 = $partes[0]; $parte2 = $partes[1];  ?>
			                                    	<?php if (!empty($parte1)) : ?>
					                                    <ul class="col-xs-6 col-sm-6 prefooter-menu prefooter-menu-world double-column">
					                                    	<?php foreach ($parte1 as $e) : ?>
						                                        <li class="mb-md"><a target="<?php echo $e->target; ?>" href="<?php echo $e->url; ?>"><?php echo $e->post_title; ?></a></li>
						                                    <?php endforeach; ?>
					                                    </ul>
				                                	<?php endif; ?>
				                                	<?php if (!empty($parte2)) : ?>
					                                    <ul class="col-xs-6 col-sm-6 prefooter-menu prefooter-menu-world">
					                                    	<?php foreach ($parte2 as $e) : ?>
					                                        	 <li class="mb-md"><a target="<?php echo $e->target; ?>" href="<?php echo $e->url; ?>"><?php echo $e->post_title; ?></a></li>
					                                        <?php endforeach; ?>
					                                    </ul>
				                                    <?php endif; ?>
			                                	<?php endif; ?>
                                                <img class="visible-xs prefooter-mobile-shadow reverse" src="<?php echo get_template_directory_uri(); ?>/resources/images/prefooter/shadow.png"/>
			                                </div>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-xs-12 col-sm-4 footer-menu-item">
			                        <p class="hidden-xs title mb-md"><a role="button"><?php echo $menu_derecho->name; ?></a></p>
			                        <p class="visible-xs title"><a role="button" class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseExample"> Enlaces de interés<span class="icon-plus icon-collapsable"></span></a></p>
			                        <div class="collapse" id="collapseThree">
			                            <?php if (!empty($elementos_menu_derecho)) : ?>
				                            <ul class="hidden-xs prefooter-menu">
				                            	<?php foreach ($elementos_menu_derecho as $e) : ?>
				                                	<li class="mb-md"><a target="<?php echo $e->target; ?>" href="<?php echo $e->url; ?>"><?php echo $e->post_title; ?></a></li>
				                                <?php endforeach; ?>
				                            </ul>
			                            <?php endif; ?>
			                            <?php if (!empty($elementos_menu_derecho)) : ?>
				                            <div class="visible-xs row prefooter-menu-collapsed">
                                            	<img class="visible-xs prefooter-mobile-shadow" src="<?php echo get_template_directory_uri(); ?>/resources/images/prefooter/shadow.png"/>
				                            	<?php foreach ($elementos_menu_derecho as $e) : ?>
				                            		<?php $classes = implode($e->classes); ?>
				                                	<a target="<?php echo $e->target; ?>" href="<?php echo $e->url; ?>" class="<?php echo $classes; ?>"><?php echo $e->post_title; ?></a>
				                                <?php endforeach; ?>
                                                <img class="visible-xs prefooter-mobile-shadow reverse" src="<?php echo get_template_directory_uri(); ?>/resources/images/prefooter/shadow.png"/>
				                            </div>
			                        	<?php endif; ?>
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
  			$menu_izquierdo = (!empty($instance['menu_izquierdo'])) ? $instance['menu_izquierdo'] : 'menu_header';
  			$menu_central = (!empty($instance['menu_central'])) ? $instance['menu_central'] : 'menu_header';
  			$menu_derecho = (!empty($instance['menu_derecho'])) ? $instance['menu_derecho'] : 'menu_header';

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
				<label for="<?php echo $this->get_field_id('menu_izquierdo'); ?>"><?php _e('Menú izquierdo', 'os_prefooter'); ?>:</label>
				<select class="widefat" id="<?php echo $this->get_field_id('menu_izquierdo'); ?>" name="<?php echo $this->get_field_name('menu_izquierdo'); ?>">
					<?php foreach ($menus as $m) : ?>
					<?php if ($m->slug == 'menu-principal') continue; ?>
					<option value="<?php echo $m->slug; ?>" <?php if ($menu_izquierdo == $m->slug) echo 'selected="selected"'; ?>"><?php echo $m->name; ?></option>
					<?php endforeach; ?>			
				</select>
				<span class="description"><?php _e('Menú con el listado que aparecerán en la parte izquierda del prefooter.',' os_prefooter');?></span>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('menu_central'); ?>"><?php _e('Menú central', 'os_prefooter'); ?>:</label>
				<select class="widefat" id="<?php echo $this->get_field_id('menu_central'); ?>" name="<?php echo $this->get_field_name('menu_central'); ?>">
					<?php foreach ($menus as $m) : ?>
					<?php if ($m->slug == 'menu-principal') continue; ?>
					<option value="<?php echo $m->slug; ?>" <?php if ($menu_central == $m->slug) echo 'selected="selected"'; ?>"><?php echo $m->name; ?></option>
					<?php endforeach; ?>				
				</select>
				<span class="description"><?php _e('Menú con el listado de enlaces que aparecerán en la parte central del prefooter.',' os_prefooter');?></span>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('menu_derecho'); ?>"><?php _e('Menú derecho', 'os_prefooter'); ?>:</label>
				<select class="widefat" id="<?php echo $this->get_field_id('menu_derecho'); ?>" name="<?php echo $this->get_field_name('menu_derecho'); ?>">
					<?php foreach ($menus as $m) : ?>
					<?php if ($m->slug == 'menu-principal') continue; ?>
					<option value="<?php echo $m->slug; ?>" <?php if ($menu_derecho == $m->slug) echo 'selected="selected"'; ?>"><?php echo $m->name; ?></option>
					<?php endforeach; ?>
				</select>
				<span class="description"><?php _e('Menú con el listado de enlaces que aparecerán en la parte derecha del prefooter.',' os_prefooter');?></span>
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