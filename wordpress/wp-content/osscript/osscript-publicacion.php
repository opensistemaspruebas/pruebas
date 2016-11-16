<?php
if (empty($wp)) {
  require_once ('../../wp-load.php');
}

	$query = new WP_Query(
		array(
			'post_type' => 'publicacion', 
		)
	);
	
	$i=0;
	
	$posts = get_posts(array(
		'numberposts' => -1,
		'post_type' => 'publicacion'
	));


	echo "Creando todos los JSON:";
	echo "<br>";

	foreach ($posts as $post){

		os_imprimir($post->ID);

		$post_id = $post->ID;
		$post_type = "publicacion";

		$json = array("_id" => $post_id, "type" => $post_type);


		$locale = 'es_ES';

		if (function_exists('wpml_get_language_information')) {
			$post_language_information = wpml_get_language_information($identificador);
			if (is_wp_error($post_language_information)) {
				return;
			}
			$locale = $post_language_information['locale'];
		}

		if (!is_dir("../jsons/" . $locale . "/publicacion/")) {
			mkdir("../jsons/" . $locale . "/publicacion/", 0777, true);
			chmod("../jsons/" . $locale . "/publicacion/", 0777);
		}

	
		// Campos del post a recoger en el json
		switch ($post_type) {
			case "publicacion":
				$json["titulo"] = get_the_title($post_id);
				$json["descripcion"] = get_post_meta($post_id, 'abstract_destacado', true);
				$json["urlImagen"] = get_post_meta($post_id, 'imagenCard', true);
				$json["urlPublicacion"] = get_permalink($post_id);
				$json["fecha"] = get_post_time('Y/m/d - g:i A', true, $post_id, true);
				$json["video"] = get_post_meta($post_id, "video", true) ? True: False;
				$json["pdf"] = get_post_meta($post_id, "pdf", true) ? True: False;
				$json["cita"] = get_post_meta($post_id, "cita", true) ? True: False;
				break;
			
			case "historia":
				$json["titulo"] = get_the_title($post_id);
				$json["descripcion"] = get_post_field('post_content', $post_id);
				$json["urlImagen"] = wp_get_attachment_image_src(get_post_thumbnail_id($post_id))[0];
				$json["urlPublicacion"] = get_permalink($post_id);
				$json["fecha"] = get_post_time('Y/m/d - g:i A', true, $post_id, true);
				$json["video"] = get_post_meta($post_id, "video", true) ? True: False;
				$json["pdf"] = get_post_meta($post_id, "pdf", true) ? True: False;
				$json["cita"] = get_post_meta($post_id, "cita", true) ? True: False;
				break;

				
			case "practica":
				$json["titulo"] = get_the_title($post_id);
				$json["descripcion"] = get_post_meta($post_id,'texto-descriptivo',true);
				$json["urlImagen"] = wp_get_attachment_image_src(get_post_thumbnail_id($post_id))[0];
				$json["urlPublicacion"] = get_permalink($post_id);
				$json["fecha"] = get_post_time('Y/m/d - g:i A', true, $post_id, true);
				$json["video"] = get_post_meta($post_id, "video", true) ? True: False;
				$json["pdf"] = get_post_meta($post_id, "pdf", true) ? True: False;
				$json["cita"] = get_post_meta($post_id, "cita", true) ? True: False;
				break;

			case "taller":
				$json["titulo"] = get_the_title($post_id);
				$json["descripcion"] = get_post_meta($post_id, 'descp', true);
				$json["link_taller"] = get_post_meta($post_id, 'link_taller', true);
				$json["pais"] = wp_get_post_terms($post_id, "ambito_geografico");
				break;

			case "partners":
				$json["nombre"] = get_post_meta($post_id, 'nombre', true);
				$json["descripcion"] = get_post_meta($post_id, 'descripcion', true);
				$json["link"] = get_post_meta($post_id, 'link', true);
				$json["urlLogoMP"] = get_post_meta($post_id, 'logoMP', true);
				$json["pais"] = wp_get_post_terms($post_id, "ambito_geografico");
				break;

			default:
				$json["error"] = "Tipo de contenido desconocido";
				break;
		}


		file_put_contents("../jsons/" . $locale . "/publicacion/".$post_id.".json", json_encode($json));
	}

	echo "Proceso terminado.";


?>