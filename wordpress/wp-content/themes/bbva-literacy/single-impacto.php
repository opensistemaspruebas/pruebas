<?php

	$post_id = $post->ID;

	$visualizacion = (get_post_meta($post_id, 'visualizacion', true)) ? get_post_meta($post_id, 'visualizacion', true) : "circulo";
	$color = get_post_meta($post_id, 'color', true);
	$etiqueta = get_post_meta($post_id, 'etiqueta', true);
	$objetivo = get_post_meta($post_id, 'objetivo', true);
	$completado = get_post_meta($post_id, 'completado', true);
	$titulo = get_post_meta($post_id, 'titulo', true);
	$subtitulo = get_post_meta($post_id, 'subtitulo', true);
	$animacion = get_post_meta($post_id, 'animacion', true);

	switch ($visualizacion) {
		case 'circulo':
			pintaCirculo($etiqueta, $color, $objetivo, $completado);
			break;
		case 'barra':
			pintaBarra($etiqueta, $color, $objetivo, $completado);
			break;
		case 'icono':
			pintaIcono();
			break;
	}

	function pintaCirculo($etiqueta, $color, $objetivo, $completado) {

		$porcentaje = $completado / $objetivo;

		?>
		<div class="circle-container blue hidden-xs hidden-sm">
		    <div class="circle-progress">
		        <div class="circle-text">
		            <p class="circle-value"><?php echo thousandsCurrencyFormatCustom($completado); ?></p>
		            <p class="circle-label"><?php echo strtoupper($etiqueta); ?></p>
		        </div>
		        <div class="procircle" data-value="<?php echo $porcentaje; ?>" data-size="260"></div>
		    </div>
		    <p class="circle-footer"><?php _e("Objetivo", "os_impacto_type"); ?> <?php echo thousandsCurrencyFormat($objetivo); ?></p>
		</div>
		<div class="circle-container blue hidden-md hidden-lg">
		    <div class="circle-progress">
		        <div class="circle-text">
		            <p class="circle-value"><?php echo thousandsCurrencyFormatCustom($completado); ?></p>
		            <p class="circle-label"><?php echo strtoupper($etiqueta); ?></p>
		        </div>
		        <div class="procircle blue" data-value="<?php echo $porcentaje; ?>" data-size="190"></div>
		    </div>
		    <p class="circle-footer"><?php _e("Objetivo", "os_impacto_type"); ?> <?php echo thousandsCurrencyFormat($objetivo); ?></p>
		</div>
		<?php
	}

	function pintaBarra() {

	}

	function pintaIcono() {

	}

?>