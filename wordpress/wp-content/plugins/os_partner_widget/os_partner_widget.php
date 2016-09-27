<?php

/*
	Plugin Name: OS Partner Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Muestra un widget con los miembros del consejo asesor (Partners)
	Version: 1.0
	Author: Marta Oliver
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_partner_widget
*/


if (!class_exists('OSPartnerWidget')) :

	class OSPartnerWidget extends WP_Widget {

	    function __construct() {
	        parent::__construct(
	        	'OSPartnerWidget',
	        	__('OS Partner', 'os_partner_widget'),
	        	array(
	            	'description' => __('Muestra un widget con los miembros del consejo asesor (Partners)', 'os_partner_widget')
	        	)
	        );
	        add_action( 'wp_enqueue_scripts', array(&$this, 'add_scripts'));
        }


	    public function widget($args, $instance) {

    		$args_partners = array(
				'posts_per_page'   => -1,
				'offset'           => 0,
				'orderby'          => 'date',
				'order'            => 'DESC',
				'post_type'        => 'partner',
				'post_status'      => 'publish',
				'suppress_filters' => true 
			);
			$partners = get_posts( $args_partners );

    	?>

    		<section class="council-members" id="<?php echo $args['widget_id']; ?>">
				<div class="container">
					
					<header class="title-description">
					    <h1><?php echo $instance['titulo']; ?></h1>
					    <div class="description-container">
					        <p><?php echo $instance['texto']; ?></p>
					    </div>
					</header>

					<div class="text-center">

						<?php foreach ($partners as $key => $partner) : ?>

		            		<?php

		            			$imagen_id = get_post_thumbnail_id( $partner->ID );
		            			$imagen = wp_get_attachment_image_src( $imagen_id, "full" )[0];
		            			$imagen_alt = get_post_meta( $imagen_id, '_wp_attachment_image_alt', true);

		            		?>

		            		<img style="display:none" id="<?php echo $args['widget_id'] . '_' . $key; ?>" class="ml-lg mr-lg mt-md mb-xl" data-toggle="modal" data-target="#modal-<?php echo $args['widget_id'] . '_' . $key; ?>" src="<?php echo $imagen; ?>" alt="<?php echo $imagen_alt; ?>">

		            	<?php endforeach; ?>
				   
				  	</div>
				</div>

				<?php foreach ($partners as $key => $partner) : ?>

					<?php 

						$nombre = $partner->post_title;
						$descripcion = $partner->post_content;
						$imagen_id = get_post_thumbnail_id( $partner->ID );
            			$imagen = wp_get_attachment_image_src( $imagen_id, "full" )[0];
            			$imagen_alt = get_post_meta( $imagen_id, '_wp_attachment_image_alt', true);
            			$enlace_partner = get_post_meta($partner->ID, 'enlace-partner', true);

					?>

					<section class="modal fade" id="modal-<?php echo $args['widget_id'] . '_' . $key; ?>" tabindex="-1" role="dialog">
					    <div class="modal-dialog" role="document">
					        <div class="modal-content">
					            <div class="container">
					                <a rol="button" class="bbva-icon-close pull-right icon-close mt-md mr-md" data-dismiss="modal" aria-label="Close"></a>
					                <div class="modal-header">
					                    <h1 class="modal-title"><?php echo $instance['titulo']; ?></h1>
					                </div>
					                <div class="modal-body mr-xxl ml-xxxl pl-lg">
					                    <div class="row">
					                        <div class="col-xs-6 col-xs-offset-4 col-sm-offset-0 col-sm-4 mt-md">
					                            <img src="<?php echo $imagen; ?>" alt="<?php echo $imagen_alt; ?>">
					                        </div>
					                        <div class="col-xs-12 col-sm-8 mt-md">
					                            <h2 class="text-left ml-md"><?php echo $nombre; ?></h2>
					                            <p class="ml-md"><?php echo $descripcion; ?></p>
					                        </div>
					                    </div>
					                </div>
					                <div class="modal-footer">
					                    <button type="button" class="btn btn-bbva-aqua" onclick="window.open('<?php echo $enlace_partner; ?>')"><?php _e('Más información','os_partner_widget'); ?></button>
					                </div>
					            </div>
					        </div>
					    </div>
					</section>

				<?php endforeach; ?>

			</section>


	    	<?php

	    }


	    public function form($instance) {
	    	$titulo = ! empty($instance['titulo']) ? $instance['titulo'] : '';
	    	$texto = ! empty($instance['texto']) ? $instance['texto'] : '';
	    	
	    	?>
	    	<p>
				<label for="<?php echo $this->get_field_id('titulo'); ?>"><?php _e('Título:', 'os_partner_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo esc_attr($titulo); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('texto'); ?>"><?php _e('Texto:', 'os_partner_widget'); ?></label>
				<textarea rows="5" class="widefat" id="<?php echo $this->get_field_id('texto'); ?>" name="<?php echo $this->get_field_name('texto'); ?>" type="text"><?php echo esc_attr($texto); ?></textarea>
			</p>
			<?php
	    }


	    function update($new_instance, $old_instance) {

			$instance = $old_instance;

			$instance['titulo'] = (!empty( $new_instance['titulo'])) ? strip_tags($new_instance['titulo']) : '';
			$instance['texto'] = (!empty( $new_instance['texto'])) ? strip_tags($new_instance['texto']) : '';

			return $instance;
	    }

	    function add_scripts($hook) 
        {
            if(is_active_widget( false, false, $this->id_base, true)) { // check if widget is used
                wp_register_script('os_partner_widget-js', plugins_url( 'js/os_partner_widget.js' , __FILE__ ), array('jquery'));
                wp_enqueue_script('os_partner_widget-js');
            }
        }

	}

	function os_partner_widget() {
	    register_widget('OSPartnerWidget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_partner_widget');


endif;