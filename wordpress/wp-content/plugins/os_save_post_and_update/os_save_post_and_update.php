<?php

/*
	Plugin Name: OS Generación de jsones
	Plugin URI: https://www.opensistemas.com/
	Description: Convierte el post a json y actualiza el indice
	Version: 1.0
	Author: Adrian Martinez
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_save_post_and_update
*/

if ( !function_exists( 'get_home_path' ) )
	require_once( dirname(__FILE__) . '/../../../wp-admin/includes/file.php' );

function save_json_to_file($json, $post_type, $identificador, $json_type) {

	$locale = 'es_ES';

	if (function_exists('wpml_get_language_information')) {
		$post_language_information = wpml_get_language_information($identificador);
		if (is_wp_error($post_language_information)) {
			return;
		}
		$locale = $post_language_information['locale'];
		
	}
	if(empty($locale)){
		$lang = ICL_LANGUAGE_CODE;
		$languages = icl_get_languages('skip_missing=0&orderby=code');
		
		$locale = $languages[$lang]['default_locale'];
	}

	$path = get_home_path() . "wp-content/jsons/" . $locale . "/" . $post_type;

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

	$format = "Y-m-d";

	// Campos del post a recoger en el json
	switch ($post_type) {
		case "publicacion":
			$json["titulo"] = get_the_title($post_id);
			$json["descripcion"] = get_post_meta($post_id, 'abstract_destacado', true);
			$json["urlImagen"] = get_post_meta($post_id, 'imagenCard', true);
			$json["urlPublicacion"] = get_permalink($post_id);
			$fecha_publicacion = get_post_meta($post_id, 'publication_date', true);
			if (!empty($fecha_publicacion)) {
				$dateobj = DateTime::createFromFormat($format, $fecha_publicacion);
				$json["fecha"] = $dateobj->format('Y/m/d') . ' - 00:00 AM';
			}
			$json["video"] = get_post_meta($post_id, "videoIntro-url", true) ? True: False;
			$json["pdf"] = False;
			$json["cita"] = False;
			break;
			
		case "historia":
			$json["titulo"] = get_the_title($post_id);
			$json["descripcion"] = get_post_meta($post_id,'texto-destacado',true);
			$json["urlImagen"] = get_post_meta($post_id, 'imagenCard', true);
			$json["urlPublicacion"] = get_permalink($post_id);
			$json["fecha"] = get_post_time('Y/m/d - g:i A', true, $post_id, true);
			$json["video"] = False;
			$json["pdf"] = False;
			$json["cita"] = False;
			break;

		case "practica":
			$json["titulo"] = get_the_title($post_id);
			$json["descripcion"] = get_post_meta($post_id,'texto-destacado',true);
			$json["urlImagen"] = get_post_meta($post_id, 'imagenCard', true);
			$json["urlPublicacion"] = get_permalink($post_id);
			$json["fecha"] = get_post_time('Y/m/d - g:i A', true, $post_id, true);
			$json["video"] = get_post_meta($post_id, "videoIntro-url", true) ? True: False;
			$json["pdf"] = False;
			$json["cita"] = False;
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


function update_post_index($post_type, $post_id){
	fetch($post_type, "ASC", $post_id);
	fetch($post_type, "DESC", $post_id);
	fetch_destacados($post_type, "DESC");
}


function update_post_index_autores($post_type, $author) {
	fetch_autores($post_type, "DESC", $author);	
}


function fetch($post_type, $order, $post_id){


	if($post_type == "publicacion"){

		$args = array(
	        'posts_per_page' => 70,
	        'offset'           => 0,
	        'post_type' => $post_type,
	        'meta_key' => 'publication_date', 
	        'post_status'      => 'publish',
	        'orderby' => 'meta_value',
	        'order' => $order,
	        'suppress_filters' => false
    	);

	}
	else{

		$args = array(
			'posts_per_page'   => 70,
			'offset'           => 0,
			'orderby'          => 'date',
			'order'            => $order,
			'post_type'        => $post_type,
			'post_status'      => 'publish',
			'suppress_filters' => false 
		);

	}

	$posts = get_posts($args);
	$last_post = get_post($post_id);

	$index_array = array();

	if($last_post->post_status != 'trash'){

		if(($order == 'DESC')){

			if(!in_array($last_post, $posts)){

				array_unshift($posts,$last_post);
			}
		}

		if(($order == 'ASC')){

			if(!in_array($last_post, $posts)){

				array_push($posts, $last_post);
			}
		}
	}

	for ($i = 0; $i < count($posts); $i++) { 
		
		$index_array[] = $posts[$i]->ID;
	}
	

	save_json_to_file($index_array, $post_type, $order, "indice");
}

function fetch_destacados($post_type, $order){


	if($post_type == "publicacion"){

    	$args = array(
	        'posts_per_page' => 70,
	        'offset'           => 0,
	        'post_type' => $post_type,
	        'meta_key' => 'publication_date', 
	        'post_status'      => 'publish',
	        'orderby' => 'meta_value',
	        'order' => $order,
	        'meta_query' => array(
		        array(
					'key'         => 'destacada',
					'value'       => 'on',
					'compare'     => '=',
		        ),
		    ),
		    'suppress_filters' => false
    	);

	}
	else{

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
			'suppress_filters' => false 
		);
	}

	$posts = get_posts($args);
	$index_array = array();

	$last_post = get_post($post_id);

	for ($i = 0; $i < count($posts); $i++) { 
		$index_array[] = $posts[$i]->ID;		
	}
	
	array_push($index_array, $last_post);

	save_json_to_file($index_array, $post_type, $order, "destacados");
}


function fetch_autores($post_type, $order, $author){

	$index_array = array();

	$posts = query_posts("post_status=publish&post_type=" . $post_type . "&author_name=" . $author . "&order=" . $order . '&lang=' . ICL_LANGUAGE_CODE);

	for ($i = 0; $i < count($posts); $i++) { 
		$index_array[] = $posts[$i]->ID;
	}

	save_json_to_file($index_array, $post_type, $author, "autores");
}


// Generar jsones al guardar un post
function save_post_and_update($post_id) {
	// si entramos a crear un post
	if ('auto-draft' === get_post_status($post_id) || 'draft' === get_post_status($post_id))
		return false;


	// Tipos de post para los que guardamos jsones
	$valid_types = array("publicacion", "historia", "practica", "taller", "partners");

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

	update_post_index($post_type,$post_id);
}

add_action('save_post', 'save_post_and_update');
add_action('delete_post', 'save_post_and_update');
