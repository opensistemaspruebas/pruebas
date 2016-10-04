<?php
if (empty($wp)) {
  require_once ('../../wp-load.php');
}

/*function post_to_json($post_id, $post_type){
	$json = array("_id" => $post_id, "type" => $post_type);

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
			$json["descripcion"] = get_post_meta($post_id, "editor", true);
			$json["urlImagen"] = wp_get_attachment_image_src(get_post_thumbnail_id($post_id))[0];
			$json["urlPublicacion"] = get_permalink($post_id);
			$json["fecha"] = get_post_time('Y/m/d - g:i A', true, $post_id, true);
			$json["video"] = get_post_meta($post_id, "video", true) ? True: False;
			$json["pdf"] = get_post_meta($post_id, "pdf", true) ? True: False;
			$json["cita"] = get_post_meta($post_id, "cita", true) ? True: False;
			break;

		default:
			$json["error"] = "Tipo de contenido desconocido";
			break;
	}

	save_json_to_file($json, $post_type, $post_id, "json");
}*/

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
			
			foreach ($posts as $post){
				print_r($post->ID);

				post_to_json($post->ID, "publicacion");
				
			}
		

echo "ejecudtado";

?>