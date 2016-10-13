<?php

/*
	Plugin Name: OS Grupo Autores Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Muestra un widget con autores
	Version: 1.0
	Author: Roberto Ojosnegros
	Author URI: http://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_grupo_autores_widget
*/


if (!class_exists('OSGrupoAutoresWidget')) :

	class OSGrupoAutoresWidget extends WP_Widget {

	    function __construct() {
	        parent::__construct(
	        	'OSGrupoAutoresWidget',
	        	__('OS Grupo Autores Widget', 'os_grupo_autores_widget'),
	        	array(
	            	'description' => __('Muestra un widget con autores', 'os_grupo_autores_widget'),
	            	'classname' => 'OSGrupoAutoresWidget', 
	        	)
	        );
	        //add_action( 'wp_enqueue_scripts', array(&$this, 'add_scripts'));
	        add_action( 'admin_enqueue_scripts', array(&$this, 'register_admin_styles'));
	        add_action('admin_enqueue_scripts', array(&$this, 'register_admin_scripts'));
	        add_action( 'wp_enqueue_scripts', array(&$this, 'register_wp_styles'));
	        add_action( 'wp_enqueue_scripts', array(&$this, 'register_wp_scripts'));
        }


	    public function widget($args, $instance) {

    	?>

    		<section class="people-grid-wrapper medium wow fadeIn" id="<?php echo $args['widget_id']; ?>" style="visibility: visible;">
		      <div class="container">
		        <article class="people-grid">
		        	<div id="num_cards" style="display:none;"><?php echo $instance['num_miembros']; ?></div>
				  <section>
				    <h1><?php echo $instance['titulo_grupo']; ?></h1>
				    <div class="row">
				    	<?php if($instance['tipo_grupo'] == 'manual' && $instance['miembro_destacado'] != ''): ?>
				    		<?php
				    			$destacado = $this->get_author_print_fields($instance['miembro_destacado']);
				    		?>

				    		<div class="card-container col-xs-12 col-sm-6">     
								<!-- person -->
								<section class="container-fluid person">
									<a href="#" class="link-layer visible-xs">&nbsp;</a>
									<div class="image-wrapper">
										<img src="<?php echo $destacado['imagen_perfil']; ?>" alt="">
									</div>
									<div class="data-wrapper">
										<span><?php echo $destacado['nombre']; ?></span>
										<p><?php echo $destacado['descripcion']; ?></p>
										
										<?php if(isset($destacado['enlace'])): ?>
									  	<a href="<?php echo $destacado['enlace']; ?>"><?php _e('Ficha del asesor','os_grupo_autores_widget'); ?></a>
									  	<?php endif; ?>
										
									</div>
								</section>
								<!-- EO person -->
					        </div>
				    	<?php endif; ?>
				      
				      	<?php foreach ($instance['miembros'] as $key => $id_miembro): ?>

				      		<?php 
				      			$miembro = $this->get_author_print_fields($id_miembro);
				      		?>
			
					        <div class="card-container col-xs-12 col-sm-6" id="<?php echo $args['widget_id'] . '_' . $key; ?>" style="display:none;">     
								<!-- person -->
								<section class="container-fluid person">
									<a href="#" class="link-layer visible-xs">&nbsp;</a>
									<div class="image-wrapper">
										<img src="<?php echo $miembro['imagen_perfil']; ?>" alt="">
									</div>
									<div class="data-wrapper">
										<span><?php echo $miembro['nombre']; ?></span>
										<p><?php echo $miembro['descripcion']; ?></p>
										
										<?php if(isset($miembro['enlace'])): ?>
									  	<a href="<?php echo $miembro['enlace']; ?>"><?php _e('Ficha del asesor','os_grupo_autores_widget'); ?></a>
									  	<?php endif; ?>
										
									</div>
								</section>
								<!-- EO person -->
					        </div>
				        <?php endforeach; ?>
				      
				    </div>
				    
					<footer class="grid-footer">
					  <div class="row">
					    <div class="col-md-12 text-center">
					      <a href="javascript:void(0)" id="<?php echo $args['widget_id']; ?>" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span><?php _e("Más miembros",'os_grupo_autores_widget'); ?></a>
					    </div>
					  </div>
					</footer>

				  </section>
				</article>       
		     

		        
		      </div>
		    </section>

	    	<?php

	    }


	    public function form($instance) {
	    	$titulo_grupo = !empty($instance['titulo_grupo']) ? $instance['titulo_grupo'] : '';
	    	$tipo_grupo = !empty($instance['tipo_grupo']) ? $instance['tipo_grupo'] : 'manual';
	    	$miembro_destacado = !empty($instance['miembro_destacado']) ? $instance['miembro_destacado'] : '';
	    	$miembros = !empty($instance['miembros']) ? $instance['miembros'] : array();
	    	$num_miembros = !empty($instance['num_miembros']) ? $instance['num_miembros'] : 6;

	    	$args_authors = array(
				'posts_per_page'   => -1,
				'offset'           => 0,
				'orderby'          => 'post_title',
				'order'            => 'DESC',
				'post_type'        => 'guest-author',
				'post_status'      => 'publish',
				'suppress_filters' => true 
			);
			$authors_aux = get_posts( $args_authors );
			// Llamo a una función auxiliar para obtener el nombre a mostrar y el perfil de cada usuario
			$authors = $this->get_authors_info($authors_aux);

	    	?>

	    	<p>
				<label for="<?php echo $this->get_field_id('titulo_grupo'); ?>"><?php _e('Título del grupo:', 'os_grupo_autores_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo_grupo'); ?>" name="<?php echo $this->get_field_name('titulo_grupo'); ?>" type="text" value="<?php echo esc_attr($titulo_grupo); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('num_miembros'); ?>"><?php _e('Nº de miembros a mostrar inicialmente:', 'os_grupo_autores_widget'); ?></label>
                <select id="<?php echo $this->get_field_id('num_miembros'); ?>" name="<?php echo $this->get_field_name('num_miembros'); ?>" >
	                <option value="6" <?php if($num_miembros == 6) { echo 'selected="selected"'; } ?>>6</option>
	                <option value="8" <?php if($num_miembros == 8) { echo 'selected="selected"'; } ?>>8</option>
	            </select>
			</p>

			<p>
				<input class="tipo_checkbox" id="<?php echo $this->get_field_id('tipo_grupo') . '-auto'; ?>" <?php if($tipo_grupo == 'auto') echo 'checked'; ?> name="<?php echo $this->get_field_name('tipo_grupo'); ?>" type="radio" value="auto"><label for="<?php echo $this->get_field_id('tipo_grupo') . '-auto'; ?>"><?php _e('Automático', 'os_grupo_autores_widget'); ?></label>
				<input class="tipo_checkbox" id="<?php echo $this->get_field_id('tipo_grupo') . '-manual'; ?>" <?php if($tipo_grupo == 'manual') echo 'checked'; ?> name="<?php echo $this->get_field_name('tipo_grupo'); ?>" type="radio" value="manual"><label for="<?php echo $this->get_field_id('tipo_grupo') . '-manual'; ?>"><?php _e('Manual', 'os_grupo_autores_widget'); ?></label>
			</p>

			<p class="miembro_destacado" <?php if($tipo_grupo == 'auto') { print('style="display:none;"'); } ?>>
				<label for="<?php echo $this->get_field_id('miembro_destacado'); ?>"><?php _e('Autor destacado:', 'os_grupo_autores_widget'); ?></label>
                <select id="<?php echo $this->get_field_id('miembro_destacado'); ?>" class="job-disp-sel" name="<?php echo $this->get_field_name('miembro_destacado'); ?>" >
                
                <?php foreach ($authors as $key2 => $author): ?>

                        <?php if($author['id'] == $miembro_destacado) { ?>
                                <option value="<?php echo $author['id']; ?>" selected="selected"><?php echo $author['nombre']; ?></option>
                        <?php } else { ?>
                                <option value="<?php echo $author['id']; ?>"><?php echo $author['nombre']; ?></option>
                        <?php } ?>

                <?php endforeach; ?>
                </select>
			</p>

			<div class="miembros">
				<label for="<?php echo $this->get_field_id('miembros'); ?>"><?php _e('Miembros del grupo:', 'os_grupo_autores_widget'); ?></label>
				<ul>
				<?php foreach ($authors as $key2 => $author): ?>
					<?php 
						$perfs = '';
						if(!empty($author['perfiles'])) {
							$perfs = ' (';
							foreach ($author['perfiles'] as $key3 => $value) {
								$perfs .= $value . ', '; 
							}
							$perfs = substr($perfs,0,-2) . ')';
						}
					?>
					<li>
                		<label class="selectit"><input value="<?php echo $author['id']; ?>" type="checkbox" name="<?php echo $this->get_field_name('miembros') . '[]'; ?>" id="<?php echo $this->get_field_id('miembros') . $author['id']; ?>" <?php if(array_search($author['id'],$instance['miembros']) !== false) { echo 'checked';} ?>><?php echo $author['nombre'] . $perfs; ?></label>
                	</li>
                <?php endforeach; ?>
                </ul>
			</div>

			<?php
	    }


	    function update($new_instance, $old_instance) {

			$instance = $old_instance;

			$instance['titulo_grupo'] = (!empty( $new_instance['titulo_grupo'])) ? strip_tags($new_instance['titulo_grupo']) : '';
			$instance['tipo_grupo'] = (!empty( $new_instance['tipo_grupo'])) ? strip_tags($new_instance['tipo_grupo']) : '';
			$instance['miembro_destacado'] = (!empty( $new_instance['miembro_destacado'])) ? strip_tags($new_instance['miembro_destacado']) : '';
			$instance['num_miembros'] = (!empty( $new_instance['num_miembros'])) ? strip_tags($new_instance['num_miembros']) : '';

			$instance['miembros'] = array();

			if ( isset ( $new_instance['miembros'] ) ) {
	            foreach ( $new_instance['miembros'] as $key => $id ) {
                    $instance['miembros'][$key] = $id;
	            }
        	}

			return $instance;
	    }

	    /*function add_scripts($hook) 
        {
            if(is_active_widget( false, false, $this->id_base, true)) { // check if widget is used
                wp_register_script('os_grupo_autores_widget-js', plugins_url( 'js/os_grupo_autores.js' , __FILE__ ), array('jquery'));
                wp_enqueue_script('os_grupo_autores_widget-js');
            }
        }*/

        function register_admin_styles($hook) {
            wp_enqueue_style( 'os-grupo_autores-widget-css', plugin_dir_url( __FILE__ ) . 'css/os_grupo_autores.css' );
        }

        function register_admin_scripts($hook) {
            wp_enqueue_script('os_grupo_autores_widget-js', plugins_url( 'js/os_grupo_autores.js' , __FILE__ ), array('jquery'));
        }

        function register_wp_styles() { 
        	//if(is_active_widget( false, false, $this->id_base, true)) { // check if widget is used
            	wp_enqueue_style( 'os-grupoautores-front-css', plugin_dir_url( __FILE__ ) . 'css/os_grupo_autores_front.css' ); 
        	//}
        }

        function register_wp_scripts() { 
        	//if(is_active_widget( false, false, $this->id_base, true)) { // check if widget is used
            	wp_enqueue_script( 'os-grupoautores-front-js', plugin_dir_url( __FILE__ ) . 'js/os_grupo_autores_front.js' ); 
        	//}
        }

        private function get_authors_info($authors_array) {
        	$returned_authors = array();

        	foreach ($authors_array as $key => $author) {
        		$returned_authors[$key]['id'] = $author->ID;
        		$returned_authors[$key]['nombre'] = get_post_meta($author->ID,'cap-display_name')[0];
        		$returned_authors[$key]['perfiles'] = array();

        		$perfiles = get_the_terms($author->ID,'perfil');
        		foreach ($perfiles as $key2 => $perfil) {
        			$returned_authors[$key]['perfiles'][$key2] = $perfil->name;
        		}
        	}

        	return $returned_authors;
        }

        private function get_author_print_fields($author_id) {
        	$author = array();
        	$author['nombre'] = get_post_meta($author_id,'cap-display_name')[0];
        	$author['imagen_perfil'] = get_post_meta($author_id,'imagen_perfil')[0];
        	$author['descripcion'] = get_post_meta($author_id,'cap-description')[0];

        	$perfiles_aux = get_the_terms($author_id,'perfil');
        	$perfiles = array();
        	foreach ($perfiles_aux as $key => $perfil) {
        		$perfiles[] = $perfil->name;
        	}
        	if(array_search('Asesor', $perfiles) !== false) {
        		$author['enlace'] = $this->get_url_perfil($author['nombre']);
        	}

        	return $author;
        }

        private function get_url_perfil($nombre) {
        	$url = get_site_url() . '/perfiles/' . sanitize_title($nombre) . '/';
        	return $url;
        }

	}

	function os_grupo_autores_widget() {
	    register_widget('OSGrupoAutoresWidget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_grupo_autores_widget');


endif;