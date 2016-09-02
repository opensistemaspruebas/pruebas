<?php
/**
 * Plugin Name: OS Custom Search
 * Plugin URI: http://www.opensistemas.com/
 * Description: Buscador para publicaciones, historias y talleres.
 * Version: 1.0
 * Author: Marta Oliver
 * Author URI: http://www.opensistemas.com/
 * Text Domain: os_custom_search
 */

function mySearchFilter($query) {
	$post_type = $_GET['type'];
	if (!$post_type) {
		$post_type = 'any';
	}
    if ($query->is_search) {
        $query->set('post_type', $post_type);
    };
    return $query;
};

add_filter('pre_get_posts','mySearchFilter');