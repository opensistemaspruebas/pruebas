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
				    	<?php 
					    	if($instance['tipo_grupo'] == 'consejo_asesor') {
					    		$destacados = $instance['asesores_destacados'];
					    		$perfil = 'asesor';
					    		$miembros = $instance['miembros_asesores'];
					    	} else {
					    		$destacados[] = $instance['coordinador_destacado'];
					    		$perfil = 'coordinador';
					    		$miembros = $instance['miembros'];
					    	}
					    	$num_miembros = count($destacados) + count($miembros);
				    	?>

				    	<?php foreach ($destacados as $key => $destacado_id): ?>
				    		<?php			    			
				    			$destacado = $this->get_author_print_fields($destacado_id,$perfil);
				    		?>
				    		<div class="card-container card-container-destacado col-xs-12 col-sm-6">     
								<!-- person -->
								<section class="container-fluid person">
									<a href="#" class="link-layer visible-xs">&nbsp;</a>
									<?php if($perfil == 'coordinador') {?>
										<div class="leader-gray-mark"></div>
									<?php } ?>
									<div class="image-wrapper">
										<img src="<?php echo $destacado['imagen_perfil']; ?>" alt="">
									</div>
									<div class="data-wrapper">
										<span><?php echo $destacado['nombre']; ?></span>
										<p><?php echo $destacado['cargo']; ?></p>
										
										<?php if(isset($destacado['enlace'])): ?>
									  	<a href="<?php echo $destacado['enlace']; ?>"><?php _e('Ficha del ','os_grupo_autores_widget'); ?><?php echo $destacado['perfil']; ?></a>
									  	<?php endif; ?>
										
									</div>
								</section>
								<!-- EO person -->
					        </div>
				    	<?php endforeach; ?>
				      

				      	<?php foreach ($miembros as $key => $id_miembro): ?>

				      		<?php 
				      			$miembro = $this->get_author_print_fields($id_miembro,'');
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
										<p><?php echo $miembro['cargo']; ?></p>
										
										<?php if(isset($miembro['enlace'])): ?>
									  	<a href="<?php echo $miembro['enlace']; ?>"><?php _e('Ficha del ','os_grupo_autores_widget'); ?><?php echo $miembro['perfil']; ?></a>
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
					    <?php if($num_miembros > $instance['num_miembros']): ?>
					      <a href="javascript:void(0)" id="<?php echo $args['widget_id']; ?>" class="readmore"><span class="bbva-icon-more font-xs mr-xs"></span><?php _e("Más miembros",'os_grupo_autores_widget'); ?></a>
					     <?php endif; ?>
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
	    	$tipo_grupo = !empty($instance['tipo_grupo']) ? $instance['tipo_grupo'] : 'consejo_asesor';

	    	$asesores_destacados = !empty($instance['asesores_destacados']) ? $instance['asesores_destacados'] : array();
	    	if(empty($asesores_destacados)) {
	    		$asesores_destacados[0] = '';
	    		$asesores_destacados[1] = '';
	    	}
	    	$miembros_asesores = !empty($instance['miembros_asesores']) ? $instance['miembros_asesores'] : array();

	    	$coordinador_destacado = !empty($instance['coordinador_destacado']) ? $instance['coordinador_destacado'] : '';
	    	$miembros = !empty($instance['miembros']) ? $instance['miembros'] : array();


	    	$args_asesores = array(
				'posts_per_page'   => -1,
				'offset'           => 0,
				'orderby'          => 'post_title',
				'order'            => 'ASC',
				'post_type'        => 'guest-author',
				'post_status'      => 'publish',
				'suppress_filters' => true,
				'tax_query' => array(
			        array(
			            'taxonomy' => 'perfil',
			            'field'    => 'slug',
			            'terms'    => 'asesor'
			        )
			    )
			);
			$asesores_aux = get_posts( $args_asesores );
			// Llamo a una función auxiliar para obtener el nombre a mostrar y el perfil de cada usuario
			$asesores = $this->get_authors_info($asesores_aux,'asesor');

			$args_coordinadores = array(
				'posts_per_page'   => -1,
				'offset'           => 0,
				'orderby'          => 'post_title',
				'order'            => 'ASC',
				'post_type'        => 'guest-author',
				'post_status'      => 'publish',
				'suppress_filters' => true,
				'tax_query' => array(
			        array(
			            'taxonomy' => 'perfil',
			            'field'    => 'slug',
			            'terms'    => 'coordinador'
			        )
			    )
			);
			$coordinadores_aux = get_posts( $args_coordinadores );
			// Llamo a una función auxiliar para obtener el nombre a mostrar y el perfil de cada usuario
			$coordinadores = $this->get_authors_info($coordinadores_aux,'coordinador');

			$args_miembros = array(
				'posts_per_page'   => -1,
				'offset'           => 0,
				'orderby'          => 'post_title',
				'order'            => 'ASC',
				'post_type'        => 'guest-author',
				'post_status'      => 'publish',
				'suppress_filters' => true,
				'tax_query' => array(
			        array(
			            'taxonomy' => 'perfil',
			            'field'    => 'slug',
			            'terms'    => 'miembro'
			        )
			    )
			);
			$miembros_aux = get_posts( $args_miembros );
			// Llamo a una función auxiliar para obtener el nombre a mostrar y el perfil de cada usuario
			$miembros_posibles = $this->get_authors_info($miembros_aux,null);

	    	?>

	    	<p>
				<label for="<?php echo $this->get_field_id('titulo_grupo'); ?>"><?php _e('Título del grupo:', 'os_grupo_autores_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo_grupo'); ?>" name="<?php echo $this->get_field_name('titulo_grupo'); ?>" type="text" value="<?php echo esc_attr($titulo_grupo); ?>">
			</p>

			<p>
				<input class="tipo_checkbox" id="<?php echo $this->get_field_id('tipo_grupo') . '-consejo_asesor'; ?>" <?php if($tipo_grupo == 'consejo_asesor') echo 'checked'; ?> name="<?php echo $this->get_field_name('tipo_grupo'); ?>" type="radio" value="consejo_asesor"><label for="<?php echo $this->get_field_id('tipo_grupo') . '-consejo_asesor'; ?>"><?php _e('Consejo asesor', 'os_grupo_autores_widget'); ?></label>
				<input class="tipo_checkbox" id="<?php echo $this->get_field_id('tipo_grupo') . '-grupo_trabajo'; ?>" <?php if($tipo_grupo == 'grupo_trabajo') echo 'checked'; ?> name="<?php echo $this->get_field_name('tipo_grupo'); ?>" type="radio" value="grupo_trabajo"><label for="<?php echo $this->get_field_id('tipo_grupo') . '-grupo_trabajo'; ?>"><?php _e('Grupo de trabajo', 'os_grupo_autores_widget'); ?></label>
			</p>

			<div class="asesores_destacados" <?php if($tipo_grupo == 'grupo_trabajo') { print('style="display:none;"'); } ?>>
				<?php foreach($asesores_destacados as $key => $asesor_destacado): ?>
				<div class="destacado_asesor-<?php echo $key+1; ?>">
					<label for="<?php echo $this->get_field_id('asesores_destacados') . '[' . $key . ']'; ?>"><?php _e('Asesor destacado ', 'os_grupo_autores_widget'); ?><?php echo $key+1; ?></label>
	                <select id="<?php echo $this->get_field_id('asesores_destacados'); ?>" class="job-disp-sel" name="<?php echo $this->get_field_name('asesores_destacados') . '[' . $key . ']'; ?>" >
	                				<?php if($asesor_destacado == "") {?>
	                					<option value="" selected><?php _e('Seleccione un asesor','os_grupo_autores_widget'); ?></option>
	                				<?php } else { ?>
	                					<option value=""><?php _e('Seleccione un asesor','os_grupo_autores_widget'); ?></option>
	                				<?php } ?>
	                	<?php foreach ($asesores as $key2 => $asesor): ?>

	                        <?php if($asesor['id'] == $asesor_destacado) { ?>
	                                <option value="<?php echo $asesor['id']; ?>" selected><?php echo $asesor['nombre']; ?></option>
	                        <?php } else { ?>
	                                <option value="<?php echo $asesor['id']; ?>"><?php echo $asesor['nombre']; ?></option>
	                        <?php } ?>

	                	<?php endforeach; ?>
	                </select>
	           	</div>
	            <?php endforeach; ?>

			</div>

			<div class="coordinador_destacado" <?php if($tipo_grupo == 'consejo_asesor') { print('style="display:none;"'); } ?>>
				<label for="<?php echo $this->get_field_id('coordinador_destacado'); ?>"><?php _e('Coordinador destacado ', 'os_grupo_autores_widget'); ?></label>
                <select id="<?php echo $this->get_field_id('coordinador_destacado'); ?>" class="job-disp-sel" name="<?php echo $this->get_field_name('coordinador_destacado'); ?>" >
                				<option value="" selected><?php _e('Seleccione un coordinador','os_grupo_autores_widget'); ?></option>
                	<?php foreach ($coordinadores as $key2 => $coordinador): ?>

                        <?php if($coordinador['id'] == $coordinador_destacado) { ?>
                                <option value="<?php echo $coordinador['id']; ?>" selected><?php echo $coordinador['nombre']; ?></option>
                        <?php } else { ?>
                                <option value="<?php echo $coordinador['id']; ?>"><?php echo $coordinador['nombre']; ?></option>
                        <?php } ?>

                	<?php endforeach; ?>
                </select>
			</div>

			<div class="miembros_asesores" <?php if($tipo_grupo == 'grupo_trabajo') { print('style="display:none;"'); } ?>>
				<label for="<?php echo $this->get_field_id('miembros_asesores'); ?>"><?php _e('Asesores del grupo:', 'os_grupo_autores_widget'); ?></label>
				<ul>
				<?php foreach ($asesores as $key2 => $miembro): ?>
					<li>
						<?php if(empty($instance['miembros_asesores'])) { ?>

							<label class="selectit"><input value="<?php echo $miembro['id']; ?>" type="checkbox" name="<?php echo $this->get_field_name('miembros_asesores') . '[]'; ?>" id="<?php echo $this->get_field_id('miembros_asesores') . $miembro['id']; ?>"><?php echo $miembro['nombre']; ?></label>

						<?php } else {?>

                			<label class="selectit"><input value="<?php echo $miembro['id']; ?>" type="checkbox" name="<?php echo $this->get_field_name('miembros_asesores') . '[]'; ?>" id="<?php echo $this->get_field_id('miembros_asesores') . $miembro['id']; ?>" <?php if(array_search($miembro['id'],$instance['miembros_asesores']) !== FALSE) { echo 'checked';} ?> <?php if(array_search($miembro['id'],$asesores_destacados) !== FALSE) { echo 'disabled';} ?>><?php echo $miembro['nombre']; ?></label>

                		<?php } ?>
                	</li>
                <?php endforeach; ?>
                </ul>
			</div>

			<div class="miembros_posibles" <?php if($tipo_grupo == 'consejo_asesor') { print('style="display:none;"'); } ?>>
				<label for="<?php echo $this->get_field_id('miembros'); ?>"><?php _e('Miembros del grupo:', 'os_grupo_autores_widget'); ?></label>
				<ul>
				<?php foreach ($miembros_posibles as $key2 => $miembro): ?>
					<li>
					<?php if(empty($instance['miembros'])) { ?>

						<label class="selectit"><input value="<?php echo $miembro['id']; ?>" type="checkbox" name="<?php echo $this->get_field_name('miembros') . '[]'; ?>" id="<?php echo $this->get_field_id('miembros') . $miembro['id']; ?>"><?php echo $miembro['nombre']; ?></label>

					<?php } else { ?>}

                		<label class="selectit"><input value="<?php echo $miembro['id']; ?>" type="checkbox" name="<?php echo $this->get_field_name('miembros') . '[]'; ?>" id="<?php echo $this->get_field_id('miembros') . $miembro['id']; ?>" <?php if(array_search($miembro['id'],$instance['miembros']) !== FALSE) { echo 'checked';} ?>><?php echo $miembro['nombre']; ?></label>

                	<?php } ?>
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

			$instance['miembros'] = array();
			$instance['miembros_asesores'] = array();
			$instance['asesores_destacados'] = array();


			// Guardo coordinador y lista de miembros
			if($instance['tipo_grupo'] == 'grupo_trabajo') {
				$instance['coordinador_destacado'] = (!empty( $new_instance['coordinador_destacado'])) ? strip_tags($new_instance['coordinador_destacado']) : '';
				
				if ( isset ( $new_instance['miembros'] ) ) {
		            foreach ( $new_instance['miembros'] as $key => $id ) {
	                    $instance['miembros'][$key] = $id;
		            }
	        	}
			}

			// Guardo asesores destacados y lista de asesores
			if($instance['tipo_grupo'] == 'consejo_asesor') {
				if ( isset ( $new_instance['asesores_destacados'] ) ) {
		            foreach ( $new_instance['asesores_destacados'] as $key => $id ) {
	                    $instance['asesores_destacados'][$key] = $id;
		            }
	        	}
				
				if ( isset ( $new_instance['miembros_asesores'] ) ) {
		            foreach ( $new_instance['miembros_asesores'] as $key => $id ) {
	                    $instance['miembros_asesores'][$key] = $id;
		            }
	        	}
			}			
				
			// El número de elementos a mostrar se automatiza dependiendo del tipo de grupo elegido 
			if($instance['tipo_grupo'] == 'consejo_asesor') {
				$instance['num_miembros'] = 8;
			} else {
				$instance['num_miembros'] = 6;
			}
			
			return $instance;
	    }

        function register_admin_styles($hook) {
            wp_enqueue_style( 'os-grupo_autores-widget-css', plugin_dir_url( __FILE__ ) . 'css/os_grupo_autores.css' );
        }

        function register_admin_scripts($hook) {
            wp_enqueue_script('os_grupo_autores_widget-js', plugins_url( 'js/os_grupo_autores.js' , __FILE__ ), array('jquery'));
        }

        function register_wp_styles() { 
        	if(is_active_widget( false, false, $this->id_base, true) || $this->checkActiveWidgetPageBuilder()) { // check if widget is used
            	wp_enqueue_style( 'os-grupoautores-front-css', plugin_dir_url( __FILE__ ) . 'css/os_grupo_autores_front.css' ); 
        	}
        }

        function register_wp_scripts() { 
        	if(is_active_widget( false, false, $this->id_base, true) || $this->checkActiveWidgetPageBuilder()) { // check if widget is used
            	wp_enqueue_script( 'os-grupoautores-front-js', plugin_dir_url( __FILE__ ) . 'js/os_grupo_autores_front.js' ); 
        	}
        }

        private function get_authors_info($authors_array) {
        	$returned_authors = array();

        	foreach ($authors_array as $key => $author) {
        		$returned_authors[$key]['id'] = $author->ID;
        		$returned_authors[$key]['nombre'] = get_post_meta($author->ID,'cap-display_name')[0];
        	}

        	return $returned_authors;
        }

        private function get_author_print_fields($author_id,$perfil) {
        	$author = array();
        	$author['nombre'] = get_post_meta($author_id,'cap-display_name')[0];
        	$author['imagen_perfil'] = get_post_meta($author_id,'imagen_perfil')[0];
        	$author['cargo'] = get_post_meta($author_id,'cargo')[0];

        	$perfiles_aux = get_the_terms($author_id,'perfil');
        	$perfiles = array();

        	if(!empty($perfiles_aux)) {
	        	foreach ($perfiles_aux as $key => $perfil_aux) {
	        		$perfiles[] = $perfil_aux->name;
	        	}
	        	if(array_search('Asesor', $perfiles) !== false) {
	        		if($perfil == '') {
	        			$author['perfil'] = 'asesor';
	        		} else {
	        			$author['perfil'] = $perfil;
	        		}
	        		$author['enlace'] = $this->get_url_perfil($author['nombre']);
	        	} else if(array_search('Coordinador', $perfiles) !== false) {
	        		if($perfil == '') {
	        			$author['perfil'] = 'coordinador';
	        		} else {
	        			$author['perfil'] = $perfil;
	        		}
	        		$author['enlace'] = $this->get_url_perfil($author['nombre']);
	        	}
	        }

        	return $author;
        }

        private function get_url_perfil($nombre) {
        	$url = get_site_url() . '/perfiles/' . sanitize_title($nombre) . '/';
        	return $url;
        }

        private function checkActiveWidgetPageBuilder() {
        	$panels_data = get_post_meta( get_the_ID(), 'panels_data', true );
			if(empty($panels_data['widgets'])) return false;

			foreach( $panels_data['widgets'] as $widget ) {
				if($widget['panels_info']['class'] == $this->widget_options['classname']) {
					return true;
				}
			}
			return false;
        }

	}

	function os_grupo_autores_widget() {
	    register_widget('OSGrupoAutoresWidget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_grupo_autores_widget');


endif;