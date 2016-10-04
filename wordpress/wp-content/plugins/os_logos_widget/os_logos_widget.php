<?php

/*
	Plugin Name: OS Logos Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Crea un widget que muestra los logos de las organizaciones y partners asociados.
	Version: 1.0
	Author: Roberto Moreno
	Author URI: rmoreno@opensistemas.com
	License: GPLv2 or later
	Text Domain: os_logos_widget
*/


if (!class_exists('OS_Logos_Widget')) :

	class OS_Logos_Widget extends WP_Widget {



	    function __construct() {
	        parent::__construct(
	        	'os_logos_widget',
	        	__('OS Logos Widget', 'os_logos_widget'),
	        	array(
	            	'description' => __('Widget que muestra los logos de las organizaciones y partners asociados.', 'os_logos_widget')
	        	)
	        );
        }


	    public function widget($args, $instance) {

	    	//print_r($instance);

	    	$titulo = $instance['titulo'];
	    	$texto = $instance['texto'];

	    	?>

<section class="council-members">
	<div class="container">
		
		<header class="title-description">
    		<h1><?php echo $titulo; ?></h1>
    		<div class="description-container">
       			<p><?php echo $texto ?></p>
    		</div>
		</header>
		<div class="text-center">   

		<?php 

			$query = new WP_Query(
				array(
			    	'post_type' => 'organizaciones',
			    	'posts_per_page'   => 5, 
			    	'orderby' => 'rand'
				)
			);
		
			$i = 0;

			if ($query->have_posts() ) {
			
				while ($query->have_posts()) : $query->the_post();
				
					$post_id = get_the_id();
					$logoMP = get_post_meta($post_id, 'logoMP', true);
      
    	?>
      
		    <img class="ml-lg mr-lg mt-md mb-xl" data-toggle="modal" data-target="#modal-<?php echo $post_id; ?>" src="<?php echo $logoMP; ?>" alt="image title" />
		    
		<?php
			
					$i++;
	    		endwhile;
				wp_reset_postdata();
			}
			else {
			
				_e("No hay organizaciones disponibles.", "os_logos_widget");
			}
		?>
		
		</div>
	</div>

		<?php 
		
			$i = 0;

			if ($query->have_posts() ) {
			
				while ($query->have_posts()) : $query->the_post();
					
					$post_id = get_the_id();
					$nombre = get_post_meta($post_id, 'nombre', true);
					$descripcion = get_post_meta($post_id, 'descripcion', true);
					$link = get_post_meta($post_id, 'link', true);
					$logoMP = get_post_meta($post_id, 'logoMP', true);
    	?>

	<section class="modal fade" id="modal-<?php echo $post_id; ?>" tabindex="-1" role="dialog">
    	<div class="modal-dialog" role="document">
        	<div class="modal-content">
            	<div class="container">
                	<a rol="button" class="bbva-icon-close pull-right icon-close mt-md mr-md" data-dismiss="modal" aria-label="Close"></a>
                	<div class="modal-header">
                    	<h1 class="modal-title"><?php echo $titulo; ?></h1>
                	</div>
                	<div class="modal-body mr-xxl ml-xxxl pl-lg">
                   		<div class="row">
                        	<div class="col-xs-6 col-xs-offset-4 col-sm-offset-0 col-sm-4 mt-md">
                            	<img src="<?php echo $logoMP; ?>" alt="image title" />
                        	</div>
                        	<div class="col-xs-12 col-sm-8 mt-md">
                            	<h2 class="text-left ml-md"><?php echo $nombre; ?></h2>
                            	<p class="ml-md"><?php echo $descripcion; ?></p>
                        	</div>
                    	</div>
                	</div>
                	<div class="modal-footer">
                   		<a href="<?php echo $link; ?>" class="btn btn-bbva-aqua"><?php _e("Más información", "os_logos_widget"); ?></a>
                	</div>
            	</div>
        	</div>
    	</div>
	</section>

		<?php
		    		$i++;
	    		endwhile;
				wp_reset_postdata();
			} 
		?>

</section>

	    	<?php

}


  		public function form($instance) {


  			$titulo = !empty($instance['titulo']) ? $instance['titulo'] : _('Organizaciones del consejo asesor', 'os_logos_widget');
  			$texto = !empty($instance['texto']) ? $instance['texto'] : _('Estas son varias de las organizaciones que apoyan a la educación financiera en los diferentes países en los que estamos presentes', 'os_logos_widget');

	        ?>
	        <p>
				<label for="<?php echo $this->get_field_id('titulo'); ?>"><?php _e('Título:', 'os_logos_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('titulo'); ?>" name="<?php echo $this->get_field_name('titulo'); ?>" type="text" value="<?php echo esc_attr($titulo); ?>">
			</p>
	       	<p>
	       		<label for="<?php echo $this->get_field_id('texto'); ?>"><?php _e('Descripción:', 'os_logos_widget'); ?></label>
				<textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('texto'); ?>" name="<?php echo $this->get_field_name('texto'); ?>"><?php echo $texto; ?></textarea>
			</p>
	        <?php
	    }


	    function update($new_instance, $old_instance) {

	    	$instance = array();
	    	$instance['titulo'] = (!empty( $new_instance['titulo'])) ? strip_tags($new_instance['titulo']) : _('Organizaciones del consejo asesor', 'os_logos_widget');
	    	$instance['texto'] = (!empty( $new_instance['texto'])) ? strip_tags($new_instance['texto']) : __("Estas son varias de las organizaciones que apoyan a la educación financiera en los diferentes países en los que estamos presentes", "os_logos_widget");

	    	return $new_instance;
	    }

	}

	function os_logos_widget() {
	    register_widget('os_logos_widget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_logos_widget');


endif;