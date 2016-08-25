<?php
	
// Registro del menú de WordPress
	add_theme_support( 'nav-menus' );
	if ( function_exists( 'register_nav_menus' ) )
	register_nav_menus(
		array(
		  'main' => 'menu_header'
		)
	);

//Registro de widget 
	
//Registro de sidebar
 
if(function_exists('register_sidebar'))
	
	register_sidebar( array(
		'name'          => 'Main Sidebar',
		'id'            => 'sidebar-0',
		'description'   => '',
        'class'         => '',
        'before_widget' => '<section class="moduloContenido_%2$s"><div class="wrapperContent">',
		'after_widget'  => '</div></section>',
		'before_title'  => '<h2 class="section_titulo">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => 'GrupoPpal ColCompleta',
		'id'            => 'sidebar-1',
		'description'   => __( 'Sidebar del Grupo Principal, columna completa', '' ),
		'class'         => '',
		'before_widget' => '',
		'after_widget'  => '',
        'before_title'  => '',
		'after_title'   => '',
	) );
	
	register_sidebar( array(
		'name'          => 'GrupoPpal ColPrincipal',
		'id'            => 'sidebar-2',
		'description'   => __( 'Sidebar del Grupo Principal, columna principal', '' ),
		'before_title'  => '<h2 class="section_titulo">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => 'GrupoPpal ColDerecha', 
		'id'            => 'sidebar-3',
		'description'   => __( 'Sidebar del Grupo Principal, columna derecha', '' ),'before_title'  => '<h2 class="section_titulo">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => 'GrupoSec ColCompleta',
		'id'            => 'sidebar-4',
		'description'   => __( 'Sidebar del Grupo Secundario, columna completa', '' ),
		'before_title'  => '<h2 class="section_titulo">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => 'GrupoSec ColPrincipal',
		'id'            => 'sidebar-5',
		'description'   => __( 'Sidebar del Grupo Secundario, columna principal', '' ),
		'before_title'  => '<h2 class="section_titulo">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => 'GrupoSec ColDerecha', 
		'id'            => 'sidebar-6',
		'description'   => __( 'Sidebar del Grupo Secundario, columna derecha', '' ),
		'before_title'  => '<h2 class="section_titulo">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => 'GrupoPpal ColIntro',
		'id'            => 'sidebar-7',
		'description'   => __( 'Sidebar del Grupo Secundario, columna intro', '' ),
		'before_title'  => '<h2 class="section_titulo">',
		'after_title'   => '</h2>',
	) );	

// Devuelve los enlaces a los idiomas
function get_language_links(){
    global $sitepress;

	if (method_exists($sitepress, "get_current_language")){  
	    if ($sitepress->get_current_language() == 'es') {
	        $language_active = 'English';
	        $language_inactive = 'Spanish';
	        //$page_id_trad = icl_object_id(get_the_ID(), 'page', true, 'en');
	        //$page_trad = get_page_link($page_id_trad);
	        $page_trad = '/en';
	    } else {
	        $language_active = 'Español';
	        $language_inactive = 'English';
	        $page_id_trad = icl_object_id(get_the_ID(), 'page', true, 'es');
	        //$page_trad = get_page_link($page_id_trad);
	        $page_trad = '/';
	    }
	    $languages = '<li class="item_02 activo"><a href="' . $page_trad . '">' . $language_active . '</a></li>';
	    //$languages .= '<li class="item_02 inactivo"><a href="">' . $language_inactive . '</a></li>';
	}
    return($languages);	
}	


function get_footer_links() {

	global $sitepress;

	$links = array();

	if (method_exists($sitepress, "get_current_language")) {  
	    if ($sitepress->get_current_language() == 'es') {
	        array_push($links, "http://www.bancaresponsable.com/");
	        array_push($links, "http://www.fbbva.es/TLFU/tlfu/esp/home/index.jsp");
	        array_push($links, "http://www.fundacionmicrofinanzasbbva.org/");
	        //array_push($links, "http://www.fundacionbbvaprovincial.com/");
	    } else {
	        array_push($links, "http://bancaresponsable.com/en/");
	        array_push($links, "http://www.fbbva.es/TLFU/tlfu/ing/home/index.jsp");
	        array_push($links, "http://mfbbva.org/en/");
	        //array_push($links, "http://www.fundacionbbvaprovincial.com/");
	    }	    
	}

	return '<ul class="lista_websBBVA lista_1col">
			    <li><a target="_blank" href="'.$links[0].'" target="_blank">'.__("Banca Responsable Fundación").'</a></li>
			    <li><a target="_blank" href="'.$links[1].'" target="_blank">'.__("BBVA Fundación").'</a></li>
			    <li><a target="_blank" href="'.$links[2].'" target="_blank">'.__("Microfinanzas Fundación").'</a></li>
			</ul>';
			//<li><a target="_blank" href="'.$links[3].'" target="_blank">'.__("Fundación BBVA Provincial").'</a></li>
}
add_filter( 'attachments_default_instance', '__return_false' ); // disable the default instance

function get_footer_links_media(){

	global $sitepress;

	$links_media = array();

	if (method_exists($sitepress, "get_current_language")) {  
	    if ($sitepress->get_current_language() == 'es') {
	        array_push($links_media, "http://www.bbvasocialmedia.com/");	        
	    } else {
	        array_push($links_media, "http://www.bbvasocialmedia.com/en/");	        
	    }	    
	}

	array_push($links_media, "https://www.facebook.com/GrupoBBVA");
	array_push($links_media, "https://twitter.com/bbva");
	array_push($links_media, "https://plus.google.com/116515550915076317173/posts");
	array_push($links_media, "https://www.youtube.com/user/bbva");
	array_push($links_media, "https://www.linkedin.com/company/bbva");

	return '<ul class="lista_websBBVA lista_1col">
			    <li><a target="_blank" href="'.$links_media[0].'" target="_blank">BBVA Social Media</a></li>
			    <li><a target="_blank" href="'.$links_media[1].'" target="_blank">Facebook</a></li>
			    <li><a target="_blank" href="'.$links_media[2].'" target="_blank">Twitter</a></li>
			    <li><a target="_blank" href="'.$links_media[3].'" target="_blank">Google +</a></li>
			    <li><a target="_blank" href="'.$links_media[4].'" target="_blank">Youtube</a></li>
			    <li><a target="_blank" href="'.$links_media[5].'" target="_blank">Linkedin</a></li>
			</ul>';

}
add_filter( 'attachments_default_instance', '__return_false' ); // disable the default instance

function get_footer_links_bottom(){
	
	global $sitepress;

	$links_bottom = array();

	if (method_exists($sitepress, "get_current_language")) {  
	    if ($sitepress->get_current_language() == 'es') {
	        array_push($links_bottom, "contactoayuda/contacta-mapa/");
	        //array_push($links_bottom, "aviso-legal/");
	        array_push($links_bottom, "aviso-legal-y-politica-de-privacidad/");
	        array_push($links_bottom, "politica-de-cookies/");	        
	    } else {
	        array_push($links_bottom, "contact-map/");
	        //array_push($links_bottom, "legal-warning/");
	        array_push($links_bottom, "legal-warning-and-privacy-policy/");
	        array_push($links_bottom, "cookies-policy/");	        
	    }	    
	}

	return '<ul id="footer_politicaLinks" class="politicaLinks">
			    <li class="item_01"><a href="'.$links_bottom[0].'">'.__("Contacto").'</a></li>
			    <li class="item_02"><a href="'.$links_bottom[1].'">'.__("Aviso Legal y Política de Privacidad").'</a></li>
			    <li class="item_04 last"><a href="'.$links_bottom[2].'">'.__("Política de cookies").'</a></li>			    
			</ul>';

}
add_filter( 'attachments_default_instance', '__return_false' ); // disable the default instance


function get_footer_links_media_icon(){

	global $sitepress;

	$links_media_icon = array();

	array_push($links_media_icon, "https://www.facebook.com/GrupoBBVA");
	array_push($links_media_icon, "https://twitter.com/bbva");
	array_push($links_media_icon, "https://plus.google.com/116515550915076317173/posts");
	array_push($links_media_icon, "https://www.youtube.com/user/bbva");
	array_push($links_media_icon, "https://www.linkedin.com/company/bbva");

	return '<ul id="footer_redesFollow" class="redesFollow">
			    <li class="item_01"><a target="_blank" href="'.$links_media_icon[0].'" class="icon-social_FB"><span class="textoIconoOcultar">Facebook</span></a></li>
			    <li class="item_02"><a target="_blank" href="'.$links_media_icon[1].'" class="icon-social_TW"><span class="textoIconoOcultar">Twitter</span></a></li>
			    <li class="item_03"><a target="_blank" href="'.$links_media_icon[4].'" class="icon-social_IN"><span class="textoIconoOcultar">Linkedin</span></a></li>
			    <li class="item_04"><a target="_blank" href="'.$links_media_icon[2].'" class="icon-social_GO"><span class="textoIconoOcultar">Google+</span></a></li>
			    <li class="item_05"><a target="_blank" href="'.$links_media_icon[3].'" class="icon-social_YT"><span class="textoIconoOcultar">Youtube</span></a></li>
			</ul>';


}
add_filter( 'attachments_default_instance', '__return_false' ); // disable the default instance


function get_footer_links_news(){
	
	global $sitepress;

	$links_media_news = array();

	if (method_exists($sitepress, "get_current_language")) {  
	    if ($sitepress->get_current_language() == 'es') {
	        array_push($links_media_news, "https://info.bbva.com/es/");

	    } else {
	        array_push($links_media_news, "https://info.bbva.com/en/");

	    }	    
	}

	return '<ul class="lista_websBBVA lista_1col">
			    <li><a target="_blank" href="'.$links_media_news[0].'" target="_blank">'.__("Noticias BBVA").'</a></li>
			</ul>';


}
add_filter( 'attachments_default_instance', '__return_false' ); // disable the default instance

if (!function_exists('os_print_r')) {

    function os_print_r($mi_array) {
        echo "<pre>";
        print_r($mi_array);
        echo "</pre>";
    }

}


add_filter( 'tax_icons_icon_array', 'prefix_add_tax_icons' );
function prefix_add_tax_icons($icons) {
	$icons = array(
		'BBVA' => 'logoBlanco_BBVA',
		'Bancomer' => 'logoBlanco_BBVAbancomer',		
		'Compass' => 'logoBlanco_BBVAcompass',
		'Continental' => 'logoBlanco_BBVAcontinental',
		'Francés' => 'logoBlanco_BBVAfrances',
		'Provincial' => 'logoBlanco_BBVAprovincial',
	);
	return $icons;
}


function load_custom_wp_admin_style() {
    wp_register_style('custom_wp_admin_css', get_template_directory_uri() . '/resources/css/admin-style.css', false, '1.0.0');    
    wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );


// Buscar solamente en páginas
function search_results($query) {	
	if ($query->is_search) {							
		$query->set('posts_per_page', 10);
		add_filter('posts_where', 'filter_where', 10, 2);
	}				
	return $query;
}
add_filter('pre_get_posts','search_results');


// Añadir resultados a la query de búsqueda
function filter_where($where, $query) {
	global $sitepress;
	$pages = search_content_in_widgets($query->query['s']);		
	if (!empty($pages)) {
		$where .= " OR ((prov_posts.ID IN (" . $pages . ")) AND (t.language_code='" . $sitepress->get_current_language() . "' OR t.language_code IS NULL))";
	}    			
    return $where;
}


function search_content_in_widgets($search_query) {
	global $wpdb;

	$results = $wpdb->get_results('SELECT option_name, option_value FROM prov_options WHERE option_name LIKE "%widget%" AND option_value LIKE "%' . $search_query . '%";', ARRAY_A);

	$ids_pages_widgets  = array();		

	foreach ($results as $result) {
		$name = $result['option_name'];	
		$values = $result['option_value'];
		$values_array = unserialize($values);
		foreach ($values_array as $value) {					

			$page_front = (empty($value['page-front']) ? "0" : $value['page-front']);
			$other_ids = (empty($value['other_ids']) ? "0" : $value['other_ids']);

			$other_ids = str_replace(" ", "", $other_ids);
			$others = explode(",", $other_ids);

			if ($page_front == 1) {
				$front = get_option('page_on_front');
				if (!(in_array($front, $ids_pages_widgets))) {
					$ids_pages_widgets[] = $front;
				}
			}

			if (count($others) > 0) {
				foreach ($others as $other) {				
					if ($other != 0 && !(in_array($other, $ids_pages_widgets))) {
						$ids_pages_widgets[] = $other;
					}
				}
			}					


			foreach ((array) $value as $k => $v) {
				if (substr($k, 0, strlen('page')) == "page" && $k != "page-front" && $v == 1) {				
					$page = substr($k, 5, strlen($k));
					if (!(in_array($page, $ids_pages_widgets))) {
						$ids_pages_widgets[] = $page;
					}
				}
			}

			if ($name == "widget_os_related_content") {

				//os_print_r($value);

				$titleLink1 = normaliza($value['titleLink1']);
				$titleLink2 = normaliza($value['titleLink2']);
				$titleLink3 = normaliza($value['titleLink3']);
				$titleLink4 = normaliza($value['titleLink4']);

				$link1 = $value['link1'];
				$link2 = $value['link2'];
				$link3 = $value['link3'];
				$link4 = $value['link4'];

				$search_query_normalizada = normaliza($search_query);

				if (!empty($titleLink1) && !empty($link1)) {
					if (stripos($titleLink1, $search_query_normalizada) !== false) {						
						if (!(in_array(get_attachment_id($link1), $ids_pages_widgets))) {
							$ids_pages_widgets[] = get_attachment_id($link1);															
						}					
					}
				}
				if (!empty($titleLink2) && !empty($link2)) {
					if (stripos($titleLink2, $search_query_normalizada) !== false) {
						if (!(in_array(get_attachment_id($link2), $ids_pages_widgets))) {
							$ids_pages_widgets[] = get_attachment_id($link2);											
						}					
					}
				}
				if (!empty($titleLink3) && !empty($link3)) {
					if (stripos($titleLink3, $search_query_normalizada) !== false) {
						if (!(in_array(get_attachment_id($link3), $ids_pages_widgets))) {
							$ids_pages_widgets[] = get_attachment_id($link3);															
						}
					}
				}
				if (!empty($titleLink4) && !empty($link4)) {
					if (stripos($titleLink4, $search_query) !== false) {
						if (!(in_array(get_attachment_id($link4), $ids_pages_widgets))) {
							$ids_pages_widgets[] = get_attachment_id($link4);							
						}					
					}
				}
			}
			
		}
	}

	return implode(",", $ids_pages_widgets);
}


// retrieves the attachment ID from the file URL
function get_attachment_id($attachment_url) {
	global $wpdb;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $attachment_url)); 
    return $attachment[0]; 
}


function normaliza($cadena) {
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    $cadena = strtolower($cadena);
    return utf8_encode($cadena);
}


function os_get_attachment_url($attachment_id) {
	global $wpdb;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT guid FROM $wpdb->posts WHERE ID='%s';", $attachment_id)); 
    return $attachment[0]; 
}

add_action('init', 'os_aplicarRedireccionAutor');

function os_aplicarRedireccionAutor(){

	if(isset($_GET['author']) || isset($_POST['author'])){

		header('HTTP/1.1 301 Moved Permanently'); 
		header("Location: " . home_url());
		exit();
	}
}

