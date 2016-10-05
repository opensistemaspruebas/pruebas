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

/*
titulo (texto)
descripcion (texto)
urlImagen (url)
urlPublicacion (url)
fecha
video (true/false)
pdf (true/false)
cita (true/false)
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

		default:
			$json["error"] = "Tipo de contenido desconocido";
			break;
	}

	//file_put_contents("/home/rmoreno/Proyectos/bbva_literacy/wordpress/wp-content/jsons/publicacion/".$post_id.".json", json_encode($json));
	save_json_to_file($json, $post_type, $post_id, "json");
}

function update_post_index($post_type){
	fetch($post_type, "ASC");
	fetch($post_type, "DESC");
	fetch_destacados($post_type, "DESC");
}

function fetch($post_type, $order){
	$args = array(
		'posts_per_page'   => 70,
		'offset'           => 0,
		'orderby'          => 'date',
		'order'            => $order,
		'post_type'        => $post_type,
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);

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


// Generar jsones al guardar un post
function save_post_and_update($post_id) {
	// Tipos de post para los que guardamos jsones
	$valid_types = array("publicacion", "historia");

	$post_type = get_post_type($post_id);
	
	// Si no es un tipo valido o no esta en estado publicado, salimos
	if (!in_array($post_type, $valid_types)) return;

	// Generar json del post
	post_to_json($post_id, $post_type);
	
	// Actualizar indice
	update_post_index($post_type);
}
add_action('save_post', 'save_post_and_update');
add_action('delete_post', 'save_post_and_update');