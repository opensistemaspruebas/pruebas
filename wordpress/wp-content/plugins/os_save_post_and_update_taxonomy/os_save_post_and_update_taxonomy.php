<?php

/*
	Plugin Name: OS Generación de jsones taxonomy
	Plugin URI: https://www.opensistemas.com/
	Description: Convierte el post a json y actualiza el indice
	Version: 1.0
	Author: Roberto Moreno
	Author URI: https://www.opensistemas.com/
	License: GPLv2 or later
	Text Domain: os_save_post_and_update_taxonomy
*/

function save_json_to_file_taxonomy($json, $taxonomy_type, $identificador, $json_type){
	$path = get_home_path() . "wp-content/jsons/" . $taxonomy_type;

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
		default:
			break;
	}
}

function post_to_json_taxonomy($term_id, $taxonomy_type){


 	$term_meta = get_term_meta($term_id);

	$json = array("_id" => $slug, "type" => $taxonomy_type);

	$json["descripURLpais"] = $term_meta['descripURLpais'][0];
	$json["URLpais"] = $term_meta['URLpais'][0];
	$json["isoCode"] = $term_meta['isoCode'][0];

	save_json_to_file_taxonomy($json, $taxonomy_type, $slug, "json");
}


function update_post_index_taxonomy($taxonomy_type){
	fetch_taxonomy($taxonomy_type, "ASC");
}


function fetch_taxonomy($taxonomy_type, $order){

	$args = array(
        'posts_per_page' => -1,

        'taxonomy' => 'ambito_geografico',
        'hide_empty' => 0
    );

	$index_array = array();

	foreach (get_terms('ambito_geografico', $args ) as $tag) {

		$index_array[] = $tag->slug;
	}

	save_json_to_file_taxonomy($index_array, $taxonomy_type, $order, "indice");
}


// Generar jsones al guardar un post
function save_post_and_update_taxonomy($term_id) {

	// Generar json del post
	post_to_json_taxonomy($term_id, 'ambito_geografico');
	

	update_post_index_taxonomy('ambito_geografico');

}
//add_action('delete_ambito_geografico', 'save_post_and_update_taxonomy');
add_action('edited_ambito_geografico', 'save_post_and_update_taxonomy');
add_action('create_ambito_geografico', 'save_post_and_update_taxonomy');