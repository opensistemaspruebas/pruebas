<?php

/*
	Plugin Name: OS Practicas Widget
	Plugin URI: https://www.opensistemas.com/
	Description: Muestra un widget con tres imagenes, un titulo debajo de cada una y un pdf.
	Version: 1.0
	Author: Roberto Moreno
	Author URI: http://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_practicas_widget
*/


if (!class_exists('OSPracticasWidget')) :

	class OSPracticasWidget extends WP_Widget {

	    function __construct() {
	        parent::__construct(
	        	'OSPracticasWidget',
	        	__('OS Practicas Widget', 'os_practicas_widget'),
	        	array(
	            	'description' => __('Muestra un widget con tres imagenes, un titulo debajo de cada una y un pdf.', 'os_practicas_widget')
	        	)
	        );
            add_action('admin_enqueue_scripts', array(&$this, 'register_admin_scripts'));
            //add_action( 'wp_enqueue_scripts', array(&$this, 'register_wp_styles'));
        }


	    public function widget($args, $instance) {
	    	
	    	$imagen_url1 = '';
	    	$imagen_url2 = '';
	    	$imagen_url3 = '';
	    	
	    	if($instance['imagen1'] != '') {
	    		$imagen_url1 = wp_get_attachment_url($instance['imagen1']);
	    	}
	    	if($instance['imagen2'] != '') {
	    		$imagen_url2 = wp_get_attachment_url($instance['imagen2']);
	    	}
	    	if($instance['imagen3'] != '') {
	    		$imagen_url3 = wp_get_attachment_url($instance['imagen3']);
	    	}
    	?>

































    		<header class="initial-header-image wow fadeIn">
		      <span><?php echo $instance['titulo']; ?></span>
		      <img class="img-responsive" src="<?php echo $imagen_url; ?>" alt="">
		    </header>

	    	<?php

	    }


	    public function form($instance) {
	    	
	    	$titulo1 = ! empty($instance['titulo1']) ? $instance['titulo1'] : '';
	    	$titulo2 = ! empty($instance['titulo2']) ? $instance['titulo2'] : '';
	    	$titulo3 = ! empty($instance['titulo3']) ? $instance['titulo3'] : '';
	    	$imagen1 = ! empty($instance['imagen1']) ? $instance['imagen1'] : '';
	    	$imagen2 = ! empty($instance['imagen2']) ? $instance['imagen2'] : '';
	    	$imagen3 = ! empty($instance['imagen3']) ? $instance['imagen3'] : '';
	    	$pdf = ! empty($instance['pdf']) ? $instance['pdf'] : '';
	    	$pdfInterno = ! empty($instance['pdfInterno']) ? $instance['pdfInterno'] : '';

	    	if($imagen1 != '') {
	    		$imagen_url1 = wp_get_attachment_url($imagen1);
	    	}
	    	if($imagen2 != '') {
	    		$imagen_url2 = wp_get_attachment_url($imagen2);
	    	}
	    	if($imagen3 != '') {
	    		$imagen_url3 = wp_get_attachment_url($imagen3);
	    	}

	    	os_imprimir($instance, 0);

	    	
	    	?>

	    	<div style="border-width: 0px 0px 1px 0px;  border-color: #CAC6C6; border-style: solid;">
				<p>
					<label for="<?php echo $this->get_field_id('titulo1'); ?>"><?php _e('Título 1:', 'os_practicas_widget'); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id('titulo1'); ?>" name="<?php echo $this->get_field_name('titulo1'); ?>" type="text" value="<?php echo esc_attr($titulo1); ?>">
				</p>
				<p class="os_practica_widget-control1" data-title="Selecciona imagen 1" data-update-text="Selecciona imagen 1" data-target=".image-id1">
					<img src="<?php echo $imagen_url1; ?>">
					<input type="hidden" name="<?php echo $this->get_field_name('imagen1'); ?>" id="<?php echo $this->get_field_id('imagen1'); ?>" value="<?php echo $imagen1; ?>" class="image-id1 os_practica_widget-control1-target">
					<input id="upload_image1" class="button button-hero os_practica_widget-control1-choose" type="button" value="Selecciona imagen 1"/>
				</p>
			</div>
	    	<div style="border-width: 0px 0px 1px 0px; border-color: #CAC6C6; border-style: solid;">
				<p>
					<label for="<?php echo $this->get_field_id('titulo2'); ?>"><?php _e('Título 2:', 'os_practicas_widget'); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id('titulo2'); ?>" name="<?php echo $this->get_field_name('titulo2'); ?>" type="text" value="<?php echo esc_attr($titulo2); ?>">
				</p>
				<p class="os_practica_widget-control2" data-title="Selecciona imagen 2" data-update-text="Selecciona imagen 2" data-target=".image-id2">
					<img src="<?php echo $imagen_url2; ?>">
					<input type="hidden" name="<?php echo $this->get_field_name('imagen2'); ?>" id="<?php echo $this->get_field_id('imagen2'); ?>" value="<?php echo $imagen2; ?>" class="image-id2 os_practica_widget-control2-target">
					<input id="upload_image2" class="button button-hero os_practica_widget-control2-choose" type="button" value="Selecciona imagen 2"/>
				</p>
			</div>
	    	<div style="border-width: 0px 0px 1px 0px; border-color: #CAC6C6; border-style: solid;">
				<p>
					<label for="<?php echo $this->get_field_id('titulo3'); ?>"><?php _e('Título 3:', 'os_practicas_widget'); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id('titulo3'); ?>" name="<?php echo $this->get_field_name('titulo3'); ?>" type="text" value="<?php echo esc_attr($titulo3); ?>">
				</p>
				<p class="os_practica_widget-control3" data-title="Selecciona imagen 3" data-update-text="Selecciona imagen 3" data-target=".image-id3">
					<img src="<?php echo $imagen_url3; ?>">
					<input type="hidden" name="<?php echo $this->get_field_name('imagen3'); ?>" id="<?php echo $this->get_field_id('imagen3'); ?>" value="<?php echo $imagen3; ?>" class="image-id3 os_practica_widget-control3-target">
					<input id="upload_image3" class="button button-hero os_practica_widget-control3-choose" type="button" value="Selecciona imagen 3"/>
				</p>
			</div>
			 <p >
			    <label for="<?php echo $this->get_field_id('pdf'); ?>"><?php _e('URL externa del archivo PDF', 'os_practicas_widget'); ?></label>
			    <input type="url" class="widefat" id="<?php echo $this->get_field_id('pdf'); ?>" name="<?php echo $this->get_field_name('pdf'); ?>" value="<?php echo $pdf; ?>"/>
			 </p>
			 <p class="os_practica_widget-controlPdfInterno" data-title="Selecciona PdfInterno " data-update-text="Selecciona PdfInterno" data-target=".PdfInterno">
			    <label for="<?php echo $this->get_field_id('pdfInterno'); ?>"><?php _e('Cargador de archivo PDF', 'os_practicas_widget'); ?></label></br>
			    <input class="PdfInterno os_practica_widget-controlPdfInterno-target widefat" type="url" id="<?php echo $this->get_field_id('pdfInterno'); ?>" name="<?php echo $this->get_field_name('pdfInterno'); ?>" value="<?php echo $pdfInterno; ?>" readonly></br>
			 	<input id="upload_pdfInterno" class="button button-hero os_practica_widget-controlPdfInterno-choose" name="upload_pdfInterno" type="button" value="<?php _e('Explorar/Subir', 'os_publicacion_type'); ?>" />
			 </p>
					
						
			<?php
	    }


	    function update($new_instance, $old_instance) {

			$instance = $old_instance;

			$instance['titulo1'] = (!empty( $new_instance['titulo1'])) ? strip_tags($new_instance['titulo1']) : '';
			$instance['titulo2'] = (!empty( $new_instance['titulo2'])) ? strip_tags($new_instance['titulo2']) : '';
			$instance['titulo3'] = (!empty( $new_instance['titulo3'])) ? strip_tags($new_instance['titulo3']) : '';
			$instance['imagen1'] = (!empty( $new_instance['imagen1'])) ? strip_tags($new_instance['imagen1']) : '';
			$instance['imagen2'] = (!empty( $new_instance['imagen2'])) ? strip_tags($new_instance['imagen2']) : '';
			$instance['imagen3'] = (!empty( $new_instance['imagen3'])) ? strip_tags($new_instance['imagen3']) : '';
			$instance['pdf'] = (!empty($new_instance['pdf'])) ? strip_tags($new_instance['pdf']) : '';
			error_log($instance['pdf']);
			$instance['pdfInterno'] = (!empty( $new_instance['pdfInterno'])) ? strip_tags($new_instance['pdfInterno']) : '';

			return $instance;
	    }

	    function register_admin_scripts($hook) {
            wp_enqueue_script('os-practicas-widget-js', plugins_url( 'js/os_practicas_widget.js' , __FILE__ ), array('jquery'));
        }

	}

	function os_practicas_widget() {
	    register_widget('OSPracticasWidget');
	}

	// Initialize Plugin
	add_action('widgets_init', 'os_practicas_widget');


endif;