<?php

/*
	Plugin Name: OS SAVE POST TO JSON AND INDEX
	Plugin URI: https://www.opensistemas.com/
	Description: Convierte el post a json y actualiza el indice
	Version: 1.0
	Author: Adrian Martinez
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_save_post_and_update
*/

function save_json_to_file($json, $post_type, $identificador, $json_type){
	$path = get_home_path() . "wp-content/jsons/" . $post_type;

	// Comprueba si el directorio existe, si no lo crea y le da permisos
	if (!is_dir($path)) {
		mkdir($path, 0777, true);
		chmod($path, 0777);
	}

	// Dependiendo de lo que sea se guarda de una forma u otra
	switch ($json_type) {
		case "json":
			file_put_contents($path . "/" . $identificador . ".json", json_encode($json));
			break;
		case "indice":
			file_put_contents($path . "/" . $identificador . ".json", json_encode($json));
			break;
		case "autores":
			file_put_contents($path . "/AUTOR_" . $identificador . ".json", json_encode($json));
			break;
		case "destacados":
			file_put_contents($path . "/" . "DESTACADOS" . ".json", json_encode($json));
			break;
		default:
			break;
	}
}

function post_to_json($post_id, $post_type){
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
			$json["descripcion"] = get_post_field('post_content', $post_id);
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


	save_json_to_file($json, $post_type, $post_id, "json");
}


function update_post_index($post_type){
	fetch($post_type, "ASC");
	fetch($post_type, "DESC");
	fetch_destacados($post_type, "DESC");
}


function update_post_index_autores($post_type, $author) {
	fetch_autores($post_type, "DESC", $author);	
}


function fetch($post_type, $order){
	
	/*$args = array(
		'posts_per_page'   => 70,
		'offset'           => 0,
		'orderby'          => 'date',
		'order'            => $order,
		'post_type'        => $post_type,
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
*/
	$args = array(
        'posts_per_page' => 70,
        'offset'           => 0,
        'post_type' => $post_type,
        'meta_key' => 'publication_date', 
        'post_status'      => 'publish',
        'orderby' => 'meta_value',
        'order' => $order
    );

               // Eventos locales
              // $local_posts = get_posts( $args );



	$posts = get_posts($args);
	$index_array = array();

	for ($i = 0; $i < count($posts); $i++) { 
		$index_array[] = $posts[$i]->ID;
	}

	save_json_to_file($index_array, $post_type, $order, "indice");
}

function fetch_destacados($post_type, $order){
	$args = array(
		'posts_per_page'   => 70,
		'offset'           => 0,
		'orderby'          => 'date',
		'order'            => $order,
		'post_type'        => $post_type,
		'post_status'      => 'publish',
		'meta_key'         => 'destacada',
		'meta_value'       => 'on',
		'meta_compare'     => '=',
		'suppress_filters' => true 
	);

	$posts = get_posts($args);
	$index_array = array();

	for ($i = 0; $i < count($posts); $i++) { 
		$index_array[] = $posts[$i]->ID;
	}

	save_json_to_file($index_array, $post_type, $order, "destacados");
}


function fetch_autores($post_type, $order, $author){

	$index_array = array();

	$posts = query_posts("post_status=publish&post_type=" . $post_type . "&author_name=" . $author . "&order=" . $order);

	for ($i = 0; $i < count($posts); $i++) { 
		$index_array[] = $posts[$i]->ID;
	}

	save_json_to_file($index_array, $post_type, $author, "autores");
}


// Generar jsones al guardar un post
function save_post_and_update($post_id) {
	// Tipos de post para los que guardamos jsones
	$valid_types = array("publicacion", "historia", "taller", "partners");

	$post_type = get_post_type($post_id);
	
	// Si no es un tipo valido o no esta en estado publicado, salimos
	if (!in_array($post_type, $valid_types)) return;

	// Generar json del post
	post_to_json($post_id, $post_type);
	
	// Actualizar indice
	$authors = get_coauthors($post_id);
	if (!empty($authors)) {
		foreach ($authors as $author) {
			$name = '';
			if (is_a($author, 'WP_User')) {
				$name = $author->data->user_login;
			} else {
				$name = $author->user_login;
			}
			if (!empty($name)) {
				update_post_index_autores($post_type, $name);
			}
		}
	}

	update_post_index($post_type);

}
add_action('save_post', 'save_post_and_update');
add_action('delete_post', 'save_post_and_update');